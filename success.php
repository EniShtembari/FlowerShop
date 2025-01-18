<?php
session_start();
require_once 'stripe_initialization.php';

if (!isset($_GET['session_id'])) {
    header('Location: cart.php');
    exit;
}

$session_id = $_GET['session_id'];

try {
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "flowershop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update payment log
    $sql = "UPDATE payment_logs 
            SET status = ?, 
                payment_intent_id = ?,
                updated_at = CURRENT_TIMESTAMP 
            WHERE session_id = ?";
    $stmt = $conn->prepare($sql);
    $status = $payment_intent->status;
    $payment_intent_id = $payment_intent->id;
    $stmt->bind_param("sss", $status, $payment_intent_id, $session_id);
    $stmt->execute();

    if ($payment_intent->status === 'succeeded') {
        // Create order
        $user_id = $session->metadata->user_id;

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert into orders
            $sql = "INSERT INTO orders (user_id, total_amount, payment_intent_id) 
                   VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $total_amount = $payment_intent->amount / 100; // Convert from cents
            $stmt->bind_param("ids", $user_id, $total_amount, $payment_intent_id);
            $stmt->execute();
            $order_id = $conn->insert_id;

            // Get cart items
            $sql = "SELECT c.ProductID, c.Quantity, p.CurrentPrice 
                   FROM cart c 
                   JOIN products p ON c.ProductID = p.ProductID 
                   WHERE c.UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Insert order items
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                   VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            while ($item = $result->fetch_assoc()) {
                $stmt->bind_param("iiid", $order_id, $item['ProductID'],
                    $item['Quantity'], $item['CurrentPrice']);
                $stmt->execute();
            }

            // Clear cart
            $sql = "DELETE FROM cart WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
    }

} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
<div class="success-container">
    <h1>Payment Successful!</h1>
    <p>Thank you for your purchase. Your order has been processed successfully.</p>
    <a href="shop.php" class="button">Continue Shopping</a>
</div>
</body>
</html>