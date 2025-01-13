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
        <!-- Cool admin button -->
        <form action="admin.php" method="get">
            <button type="submit" class="admin-btn">Add Product</button>
        </form>
    </div>
</div>
</div>


<!--product section-->
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
                                <a href="wishlist.php?add_to_wishlist=<?php echo $productID; ?>">â¤ï¸</a>

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
                <div class="product">
                    <img src="<?php echo htmlspecialchars($row['ImageURL']); ?>" alt="Product Image">
                    <h2><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                    <p class="discount">Discount: <?php echo htmlspecialchars($row['DiscountPercentage']); ?>%</p>
                    <p>
                        Price: $<?php echo htmlspecialchars($row['CurrentPrice']); ?>
                        <span class="original-price">$<?php echo htmlspecialchars($row['OriginalPrice']); ?></span>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>


    <!--next button-->
    <div class="pagination-container">
        <div class="pagination">
            <a href="shop.html" class="page active">1</a>
            <a href="shop1.html" class="page">2</a>
            <a href="shop1.html" class="page">next</a>
        </div>
    </div>
</section>
<script src="http://localhost/FlowerShop/shop.js"></script>
</body>
</html>