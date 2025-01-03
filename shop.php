<?php
// Include the connection file
$pdo = require 'connect.php';

// Prepare and execute the query
$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);

// Fetch all results
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="box">
                    <span class="discount">-<?= htmlspecialchars($product["discount"]) ?>%</span>
                    <div class="image">
                        <img src="<?= htmlspecialchars($product["image_url"]) ?>" alt="<?= htmlspecialchars($product["name"]) ?>">
                        <div class="icons">
                            <a href="#" class="likes">❤️</a>
                            <a href="#" class="cart-btn">Add to cart</a>
                            <a href="#" class="shares">🔗</a>
                        </div>
                    </div>
                    <div class="content">
                        <h3><?= htmlspecialchars($product["name"]) ?></h3>
                        <div class="price">$<?= htmlspecialchars($product["price"]) ?> <span>$<?= htmlspecialchars($product["original_price"]) ?></span></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
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
