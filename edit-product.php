<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if productID is provided
if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    // Query the database for the product details
    $sql = "SELECT * FROM products WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found!";
        exit();
    }
} else {
    echo "No product ID provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="http://localhost/FlowerShop/shop.css">
</head>
<body>
<h1>Edit Product</h1>
<form action="update_product.php" method="post">
    <input type="hidden" name="productID" value="<?php echo $product['ProductID']; ?>">

    <label>Product Name:</label>
    <input type="text" name="ProductName" value="<?php echo $product['ProductName']; ?>" required>

    <label>Image URL:</label>
    <input type="text" name="ImageURL" value="<?php echo $product['ImageURL']; ?>" required>

    <label>Discount Percentage:</label>
    <input type="number" name="DiscountPercentage" value="<?php echo $product['DiscountPercentage']; ?>" required>

    <label>Current Price:</label>
    <input type="number" name="CurrentPrice" value="<?php echo $product['CurrentPrice']; ?>" step="0.01" required>

    <label>Original Price:</label>
    <input type="number" name="OriginalPrice" value="<?php echo $product['OriginalPrice']; ?>" step="0.01" required>

    <button type="submit" class="edit-btn">Save Changes</button>
</form>

<script src="edit-product.js"></script>
</body>
</html>

<?php
$conn->close();
?>
