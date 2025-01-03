<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'flowershop');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Handle form submission to add a product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $imageURL = $_POST['image_url'];
    $discountPercentage = $_POST['discount_percentage'];
    $currentPrice = $_POST['current_price'];
    $originalPrice = $_POST['original_price'];

    // Validate inputs
    if (!empty($productName) && !empty($imageURL) && is_numeric($discountPercentage) &&
        is_numeric($currentPrice) && is_numeric($originalPrice)) {

        // Insert the product into the database
        $sql = "INSERT INTO products (ProductName, ImageURL, DiscountPercentage, CurrentPrice, OriginalPrice)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssddd', $productName, $imageURL, $discountPercentage, $currentPrice, $originalPrice);

        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Invalid input. Please check all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Product</title>
</head>
<body>
<h1>Admin - Add Product</h1>

<!-- Display message after product addition -->
<?php
if (isset($message)) {
    echo '<div class="' . (strpos($message, 'Error') !== false ? 'error' : 'message') . '">' . $message . '</div>';
}
?>

<!-- Product Submission Form -->
<form method="post" action="admin.php">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required><br><br>

    <label for="image_url">Image URL:</label>
    <input type="text" id="image_url" name="image_url" required><br><br>

    <label for="discount_percentage">Discount Percentage:</label>
    <input type="number" id="discount_percentage" name="discount_percentage" step="any" required><br><br>

    <label for="current_price">Current Price:</label>
    <input type="number" id="current_price" name="current_price" step="any" required><br><br>

    <label for="original_price">Original Price:</label>
    <input type="number" id="original_price" name="original_price" step="any" required><br><br>

    <button type="submit">Add Product</button>
</form>
</body>
</html>
