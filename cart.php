<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Welcome to the Flower Shop</h1>
</header>
<main>
    <div class="product-list">
        <div class="product" data-id="1" data-name="Roses" data-price="10">
            <h2>Roses</h2>
            <p>Price: $10</p>
            <button class="add-to-cart">Add to Cart</button>
        </div>
        <div class="product" data-id="2" data-name="Tulips" data-price="8">
            <h2>Tulips</h2>
            <p>Price: $8</p>
            <button class="add-to-cart">Add to Cart</button>
        </div>
        <div class="product" data-id="3" data-name="Sunflowers" data-price="12">
            <h2>Sunflowers</h2>
            <p>Price: $12</p>
            <button class="add-to-cart">Add to Cart</button>
        </div>
        <div class="product" data-id="1" data-name="Roses" data-price="10">
            <h2>Roses</h2>
            <p>Price: $10</p>
            <button class="add-to-cart">Add to Cart</button>
        </div>
        <div class="product" data-id="2" data-name="Tulips" data-price="8">
            <h2>Tulips</h2>
            <p>Price: $8</p>
            <button class="add-to-cart">Add to Cart</button>
        </div>
        <div class="product" data-id="3" data-name="Sunflowers" data-price="12">
            <h2>Sunflowers</h2>
            <p>Price: $12</p>
            <button class="add-to-cart">Add to Cart</button>
        </div>
    </div>
</main>
<footer>
    <a href="cart.php">Go to Cart</a>
</footer>
<script src="script.js"></script>
</body>
</html>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f9f9f9;
}

header {
  background-color: #6a1b9a;
  color: white;
  padding: 1rem;
  text-align: center;
}

.product-list {
  display: flex;
  justify-content: space-around;
  padding: 2rem;
}

.product {
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 1rem;
  background-color: white;
  width: 200px;
  text-align: center;
}

button {
  background-color: #6a1b9a;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  cursor: pointer;
  border-radius: 3px;
}

button:hover {
  background-color: #8e24aa;
}
document.querySelectorAll('.add-to-cart').forEach(button => {
  button.addEventListener('click', () => {
   const product = button.closest('.product');
   const id = product.dataset.id;
   const name = product.dataset.name;
   const price = product.dataset.price;

   fetch('cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id, name, price })
  })
  .then(response => response.json())
  .then(data => alert(data.message));
  });
});
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];
    $name = $data['name'];
    $price = $data['price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }

    echo json_encode(['message' => 'Product added to cart']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    echo json_encode($_SESSION['cart']);
    exit;
}
?>
<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Your Shopping Cart</h1>
</header>
<main>
    <?php if (empty($cart)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>$<?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo $item['price'] * $item['quantity']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>
<footer>
    <a href="index.html">Continue Shopping</a>
</footer>
</body>
</html>
