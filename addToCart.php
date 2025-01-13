<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure POST data is set and valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductID']) && !empty($_POST['ProductID']) && is_numeric($_POST['ProductID'])) {
    $UserID = $_SESSION['UserID'];
    $ProductID = intval($_POST['ProductID']); // Ensure it's an integer

    // Check if the product is already in the cart
    $checkCart = $conn->prepare("SELECT * FROM cart WHERE UserID = ? AND ProductID = ?");
    $checkCart->bind_param("ii", $UserID, $ProductID);
    $checkCart->execute();
    $result = $checkCart->get_result();

    if ($result->num_rows > 0) {
        // Product exists in the cart, update quantity
        $updateCart = $conn->prepare("UPDATE cart SET Quantity = Quantity + 1 WHERE UserID = ? AND ProductID = ?");
        $updateCart->bind_param("ii", $UserID, $ProductID);
        $updateCart->execute();
    } else {
        // Product doesn't exist in the cart, add it
        $addCart = $conn->prepare("INSERT INTO cart (UserID, ProductID, Quantity) VALUES (?, ?, 1)");
        $addCart->bind_param("ii", $UserID, $ProductID);
        $addCart->execute();
        $_SESSION['cart_message'] = "Product has been added to your cart!";
    }

    // Redirect back to shop page
    header("Location: shop.php");
    exit;
} else {
    // Invalid request handling
    echo "Invalid request. Please try again.";
    exit;
}
?>
