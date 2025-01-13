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

$UserID = $_SESSION['UserID'];

// Fetch cart items for the user
$sql = "SELECT c.Quantity, p.ProductName, p.CurrentPrice, (c.Quantity * p.CurrentPrice) AS TotalPrice
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
    <title>Shopping Cart</title>
</head>
<body>
<h1>Your Shopping Cart</h1>
<table>
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ProductName']); ?></td>
            <td><?php echo $row['Quantity']; ?></td>
            <td>$<?php echo $row['CurrentPrice']; ?></td>
            <td>$<?php echo $row['TotalPrice']; ?></td>
        </tr>
        <?php $totalPrice += $row['TotalPrice']; ?>
    <?php endwhile; ?>
</table>
<h2>Total Price: $<?php echo $totalPrice; ?></h2>
</body>
</html>
