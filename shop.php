<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle delete product request
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $productID = $_POST['productID'];

        if (!empty($productID)) {
            $sql = "DELETE FROM products WHERE ProductID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productID);

            if ($stmt->execute()) {
                $message = "Product deleted successfully.";
            } else {
                $message = "Error deleting product: " . $conn->error;
            }
            $stmt->close();
        }
    }
    // Handle update product request
    else {
        $productID = $_POST['productID'];
        $productName = $_POST['productName'];
        $imageURL = $_POST['imageURL'];
        $discountPercentage = $_POST['discountPercentage'];
        $currentPrice = $_POST['currentPrice'];
        $originalPrice = $_POST['originalPrice'];

        // Validate inputs
        if (!empty($productID) && !empty($productName) && !empty($imageURL)) {
            $sql = "UPDATE products SET 
                    ProductName = ?, 
                    ImageURL = ?, 
                    DiscountPercentage = ?, 
                    CurrentPrice = ?, 
                    OriginalPrice = ? 
                    WHERE ProductID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdddi",
                $productName,
                $imageURL,
                $discountPercentage,
                $currentPrice,
                $originalPrice,
                $productID
            );

            if ($stmt->execute()) {
                $message = "Product updated successfully.";
            } else {
                $message = "Error updating product: " . $conn->error;
            }
            $stmt->close();
        } else {
            $message = "Please fill in all required fields.";
        }
    }
}

// Retrieve all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);


?>

<?php
// Include the footer file

include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <link rel="stylesheet" href="http://localhost/FlowerShop/shop.css">
    <link href="https://fonts.googleapis.com/css2?family=Diphylleia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/FlowerShop/edit-container.css">
    <link rel="stylesheet" href="http://localhost/FlowerShop/delete-product.css">
</head>
<body>

<div class="shop">
    <div class="content">
        <h1>Our Shop</h1>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <!-- Display success/error message -->
        <?php if (!empty($_SESSION['cart_message'])): ?>
            <div class="cart-message">
                <p><?php echo htmlspecialchars($_SESSION['cart_message']); ?></p>
            </div>
            <?php unset($_SESSION['cart_message']); // Clear the message ?>
        <?php endif; ?>

        <?php if (!empty($message)) echo "<p>$message</p>"; ?>

        <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
            <form action="admin.php" method="get">
                <button type="submit" class="admin-btn">Add Product</button>
            </form>
        <?php endif; ?>
    </div>
</div>


<section class="product" id="product">
    <div class="box-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="box" data-id="<?php echo $row['ProductID']; ?>">
                    <!-- Trash icon only visible for admins -->
                    <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                        <form action="shop.php" method="post" class="delete-form">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="productID" value="<?php echo $row['ProductID']; ?>">
                            <button type="submit" class="delete-icon" onclick="return confirm('Are you sure you want to delete this product?')">
                                🗑️
                            </button>
                        </form>
                    <?php endif; ?>
                    <span class="discount">-<?php echo $row['DiscountPercentage']; ?>%</span>
                    <div class="image">
                        <img src="<?php echo $row['ImageURL']; ?>" alt="<?php echo $row['ProductName']; ?>">
                    </div>
                    <div class="content">
                        <h3><?php echo $row['ProductName']; ?></h3>
                        <div class="price">
                            $<?php echo $row['CurrentPrice']; ?> <span>$<?php echo $row['OriginalPrice']; ?></span>
                        </div>
                        <form action="addToCart.php" method="POST">
                            <input type="hidden" name="ProductID" value="<?php echo $row['ProductID']; ?>">
                            <button type="submit" class="cart-btn">🛒 Add to Cart</button>
                        </form>
                        <div class="content-buttons">
                            <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                                <button class="edit-btn" onclick="openModal(<?php echo $row['ProductID']; ?>, '<?php echo $row['ProductName']; ?>', '<?php echo $row['ImageURL']; ?>', <?php echo $row['DiscountPercentage']; ?>, <?php echo $row['CurrentPrice']; ?>, <?php echo $row['OriginalPrice']; ?>)">
                                    Edit Product
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</section>

<div class="modal" id="edit-modal">
    <form action="shop.php" method="post">
        <h2>Edit Product</h2>
        <input type="hidden" name="productID" id="edit-productID">

        <label for="edit-productName">Product Name</label>
        <input type="text" name="productName" id="edit-productName" required>

        <label for="edit-imageURL">Image URL</label>
        <input type="text" name="imageURL" id="edit-imageURL" required>

        <label for="edit-discountPercentage">Discount Percentage</label>
        <input type="number" name="discountPercentage" id="edit-discountPercentage" step="0.01" required>

        <label for="edit-currentPrice">Current Price</label>
        <input type="number" name="currentPrice" id="edit-currentPrice" step="0.01" required>

        <label for="edit-originalPrice">Original Price</label>
        <input type="number" name="originalPrice" id="edit-originalPrice" step="0.01" required>

        <button type="submit" class="save-btn">💾 Save Changes</button>
    </form>
</div>
<script src="edit-product.js"></script>
<script src="timeout.js"></script>
<?php
// Include the footer file
include 'footer.php';
?>
</body>
</html>
