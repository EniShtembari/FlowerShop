<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$UserID = $_SESSION['user_id'];

// Fetch cart items for the user
$sql = "SELECT c.CartID, c.Quantity, p.ProductName, p.ImageURL, p.CurrentPrice, 
        (c.Quantity * p.CurrentPrice) AS TotalPrice
        FROM cart c
        JOIN products p ON c.ProductID = p.ProductID
        WHERE c.UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $UserID);
$stmt->execute();
$result = $stmt->get_result();

$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
<div class="cart-container">
    <h1>Your Shopping Cart</h1>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <!-- Product Image and Name -->
                <td>
                    <div class="product-info">
                        <img src="<?php echo htmlspecialchars($row['ImageURL']); ?>"
                             alt="<?php echo htmlspecialchars($row['ProductName']); ?>">
                        <span><?php echo htmlspecialchars($row['ProductName']); ?></span>
                    </div>
                </td>
                <!-- Quantity -->
                <td>
                    <form action="updateCart.php" method="POST" style="display: inline;">
                        <input type="hidden" name="cartID" value="<?php echo $row['CartID']; ?>">
                        <button type="submit" name="action" value="decrease">-</button>
                        <input type="text" class="quantity-input" name="quantity"
                               value="<?php echo $row['Quantity']; ?>" readonly>
                        <button type="submit" name="action" value="increase">+</button>
                    </form>
                </td>
                <!-- Price and Total -->
                <td>$<?php echo $row['CurrentPrice']; ?></td>
                <td>$<?php echo $row['TotalPrice']; ?></td>
                <!-- Delete Action -->
                <td class="actions">
                    <form action="updateCart.php" method="POST" style="display: inline;">
                        <input type="hidden" name="cartID" value="<?php echo $row['CartID']; ?>">
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php $totalPrice += $row['TotalPrice']; ?>
        <?php endwhile; ?>
    </table>
    <div class="total-price">Total Price: $<?php echo $totalPrice; ?></div>
    <button class="checkout-button">Proceed to Checkout</button>
    <a href="shop.php" class="button">Continue shopping</a>
</div>
</body>
</html>
