<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle quantity update or deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartID']) && isset($_POST['action'])) {
    $cartID = intval($_POST['cartID']);
    $action = $_POST['action'];

    if ($action === 'increase') {
        $sql = "UPDATE cart SET Quantity = Quantity + 1 WHERE CartID = ?";
    } elseif ($action === 'decrease') {
        $sql = "UPDATE cart SET Quantity = GREATEST(Quantity - 1, 1) WHERE CartID = ?";
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM cart WHERE CartID = ?";
    }

    if (isset($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cartID);
        $stmt->execute();
    }
}

// Redirect back to the cart
header("Location: cart.php");
exit;
?>


