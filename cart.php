<?php
global $public_key;
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Load Stripe initialization
require_once 'stripe_initialization.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $UserID = $_SESSION['user_id'];

    // Fetch total price for the cart
    $sqlTotal = "SELECT SUM(c.Quantity * p.CurrentPrice) AS TotalPrice
            FROM cart c
            JOIN products p ON c.ProductID = p.ProductID
            WHERE c.UserID = ?";
    $stmtTotal = $conn->prepare($sqlTotal);
    if (!$stmtTotal) {
        throw new Exception("Error preparing total query: " . $conn->error);
    }

    $stmtTotal->bind_param("i", $UserID);
    $stmtTotal->execute();
    $resultTotal = $stmtTotal->get_result();
    $totalPrice = ($row = $resultTotal->fetch_assoc()) ? $row['TotalPrice'] : 0;

    // Fetch cart items
    $sqlItems = "SELECT c.CartID, c.ProductID, c.Quantity, p.ProductName, p.ImageURL, p.CurrentPrice, 
                (c.Quantity * p.CurrentPrice) AS TotalPrice
            FROM cart c
            JOIN products p ON c.ProductID = p.ProductID
            WHERE c.UserID = ?";
    $stmtItems = $conn->prepare($sqlItems);
    if (!$stmtItems) {
        throw new Exception("Error preparing items query: " . $conn->error);
    }

    $stmtItems->bind_param("i", $UserID);
    $stmtItems->execute();
    $resultItems = $stmtItems->get_result();

    // Create line items for Stripe
    $line_items = [];
    while ($item = $resultItems->fetch_assoc()) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $item['ProductName'],
                ],
                'unit_amount' => intval($item['CurrentPrice'] * 100),
            ],
            'quantity' => $item['Quantity'],
        ];
    }

    // Create Stripe Checkout Session
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/flowershop/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/flowershop/cart.php',
        'metadata' => [
            'user_id' => $UserID
        ]
    ]);

    // Log the checkout attempt
    $sql = "INSERT INTO api_logs (service_name, request_payload, response_payload, status_code) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing log entry: " . $conn->error);
    }

    $service_name = 'stripe_checkout';
    $request_payload = json_encode([
        'user_id' => $UserID,
        'amount' => $totalPrice,
        'line_items_count' => count($line_items)
    ]);
    $response_payload = json_encode([
        'session_id' => $checkout_session->id,
        'status' => 'initiated'
    ]);
    $status_code = 200;

    $stmt->bind_param("sssi", $service_name, $request_payload, $response_payload, $status_code);
    $stmt->execute();

} catch (\Stripe\Exception\ApiErrorException $e) {
    error_log('Stripe API Error: ' . $e->getMessage());
    $error_message = 'Payment processing error. Please try again later.';
} catch (\Exception $e) {
    error_log('Error: ' . $e->getMessage());
    $error_message = 'An unexpected error occurred. Please try again later.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<div class="cart-container">
    <h1>Your Shopping Cart</h1>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <?php if ($resultItems && $resultItems->num_rows > 0): ?>
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Reset the result pointer
            $resultItems->data_seek(0);
            while ($row = $resultItems->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="<?php echo htmlspecialchars($row['ImageURL']); ?>"
                                 alt="<?php echo htmlspecialchars($row['ProductName']); ?>">
                            <span><?php echo htmlspecialchars($row['ProductName']); ?></span>
                        </div>
                    </td>
                    <td>
                        <form action="updateCart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="cartID" value="<?php echo $row['CartID']; ?>">
                            <button type="submit" name="action" value="decrease">-</button>
                            <input type="text" class="quantity-input" name="quantity"
                                   value="<?php echo $row['Quantity']; ?>" readonly>
                            <button type="submit" name="action" value="increase">+</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($row['CurrentPrice'], 2); ?></td>
                    <td>$<?php echo number_format($row['TotalPrice'], 2); ?></td>
                    <td class="actions">
                        <form action="updateCart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="cartID" value="<?php echo $row['CartID']; ?>">
                            <button type="submit" name="action" value="delete" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <div class="total-price">Total Price: $<?php echo number_format($totalPrice, 2); ?></div>

        <div class="button-container">
            <a href="shop.php" class="button continue-shopping">Continue Shopping</a>
            <button id="checkout-button" class="checkout-button">Proceed to Checkout</button>
        </div>

        <script>
            const stripe = Stripe('<?php echo $public_key; ?>');
            const checkoutButton = document.getElementById('checkout-button');

            checkoutButton.addEventListener('click', function() {
                stripe.redirectToCheckout({
                    sessionId: '<?php echo $checkout_session->id; ?>'
                }).then(function(result) {
                    if (result.error) {
                        alert(result.error.message);
                    }
                });
            });
        </script>
    <?php else: ?>
        <div class="empty-cart">
            <p>Your cart is empty</p>
            <a href="shop.php" class="button continue-shopping">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>