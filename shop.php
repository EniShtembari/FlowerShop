<?php
session_start();
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

// Handle form submission for editing products
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $stmt->bind_param("ssdddi", $productName, $imageURL, $discountPercentage, $currentPrice, $originalPrice, $productID);

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

// Retrieve all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <link rel="stylesheet" href="shop.css">
    <link href="https://fonts.googleapis.com/css2?family=Diphylleia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/FlowerShop/edit-container.css">
</head>
<body>

<!-- Display cart message if set -->
<?php if (isset($_SESSION['cart_message'])): ?>
    <div class="cart-message">
        <?php
        echo $_SESSION['cart_message'];
        unset($_SESSION['cart_message']);
        ?>
    </div>
<?php endif; ?>


<!--page1-->
<div class="shop">
    <div class="content">
        <h1>Our Shop</h1>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <!-- Show "Go to Admin" button only if the user is an admin -->
        <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
            <form action="admin.php" method="get">
                <button type="submit" class="admin-btn">Go to Admin</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Product Section -->
<section class="product" id="product">
    <div class="box-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $productID = $row['ProductID'];
                $productName = $row['ProductName'];
                $imageURL = $row['ImageURL'];
                $discountPercentage = $row['DiscountPercentage'];
                $currentPrice = $row['CurrentPrice'];
                $originalPrice = $row['OriginalPrice'];
                ?>
                <!-- Display product box -->
                <div class="box">
                    <span class="discount"> -<?php echo $discountPercentage; ?>% </span>
                    <div class="image">
                        <img src="<?php echo $imageURL; ?>" alt="<?php echo $productName; ?>">
                        <div class="icons">
                            <button class="add-to-wishlist">
                                <a href="wishlist.php?add_to_wishlist=<?php echo $productID; ?>">❤️</a>
                            </button>

                            <form action="addToCart.php" method="POST" style="display: inline;">
                                <input type="hidden" name="ProductID" value="<?php echo $productID; ?>">
                                <button type="submit" class="cart-btn">Add to cart</button>
                            </form>

                        </div>
                    </div>
                    <div class="content">
                        <h3><?php echo $productName; ?></h3>
                        <div class="price">$<?php echo $currentPrice; ?> <span>$<?php echo $originalPrice; ?></span>
                        </div>
                        <!-- Add Edit Button -->
                        <form action="edit.php" method="get">
                            <input type="hidden" name="productID" value="<?php echo $productID; ?>">
                            <button type="submit" class="edit-btn">Edit Product</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
    </div>

    <!--add a product-->
    <!-- Display products from the database -->
    <?php if ($result->num_rows > 0): ?>
        <div class="product-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="box" data-id="<?php echo $row['ProductID']; ?>">
                    <span class="discount">-<?php echo $row['DiscountPercentage']; ?>%</span>
                    <div class="image">
                        <img src="<?php echo $row['ImageURL']; ?>" alt="<?php echo $row['ProductName']; ?>">
                    </div>
                    <div class="content">
                        <h3><?php echo $row['ProductName']; ?></h3>
                        <div class="price">
                            $<?php echo $row['CurrentPrice']; ?> <span>$<?php echo $row['OriginalPrice']; ?></span>
                        </div>
                        <button class="cart-btn">🛒 Add to Cart</button>
                        <!-- Show "Edit Product" button only if the user is an admin -->
                        <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                            <button class="edit-btn" onclick="openModal(<?php echo $row['ProductID']; ?>, '<?php echo $row['ProductName']; ?>', '<?php echo $row['ImageURL']; ?>', <?php echo $row['DiscountPercentage']; ?>, <?php echo $row['CurrentPrice']; ?>, <?php echo $row['OriginalPrice']; ?>)">
                                Edit Product
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>

</section>

<!--Modal Section-->
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
</body>
</html>
