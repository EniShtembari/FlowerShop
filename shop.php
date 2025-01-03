<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "flowershop"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products
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

<!--page1-->
<div class="shop">
    <div class="content">
        <h1>Our Shop</h1>
    </div>
</div>


<!--product section-->
<section class="product" id="product">

    <div class="box-container">

        <?php
        // Check if there are products and display them
        if ($result->num_rows > 0) {
        // Loop through each product
        while($row = $result->fetch_assoc()) {
        // Assign variables from the result
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
                        <a href="#" class="likes">❤️</a>
                        <a href="#" class="cart-btn">Add to cart</a>
                        <a href="#" class="shares">🔗</a>
                    </div>
                </div>
                <div class="content">
                    <h3><?php echo $productName; ?></h3>
                    <div class="price">$<?php echo $currentPrice; ?> <span>$<?php echo $originalPrice; ?></span></div>
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




    <!--next button-->
    <div class="pagination-container">
        <div class="pagination">
            <a href="shop.html" class="page active">1</a>
            <a href="shop1.html" class="page">2</a>
            <a href="shop1.html" class="page">next</a>
        </div>
    </div>





</section>
</body>
</html>