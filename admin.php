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
            // Success message for popup
            $message = "Product added successfully!";
            $redirect = true;
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f0f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #ff4081;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 5px;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        button {
            background-color: #ff4081;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #f50057;
        }

        .message {
            background-color: #c8e6c9;
            color: #388e3c;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }

        .error {
            background-color: #ffccbc;
            color: #d32f2f;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }

        .form-group input {
            width: calc(100% - 22px);
            margin-bottom: 10px;
        }

    </style>
</head>
<body>

<h1>Admin - Add Product</h1>

<div class="container">
    <!-- Display message after product addition -->
    <?php
    if (isset($message)) {
        echo '<div class="' . (strpos($message, 'Error') !== false ? 'error' : 'message') . '">' . $message . '</div>';
    }
    ?>

    <!-- Product Submission Form -->
    <form method="post" action="admin.php">
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>
        </div>

        <div class="form-group">
            <label for="image_url">Image URL:</label>
            <input type="text" id="image_url" name="image_url" required>
        </div>

        <div class="form-group">
            <label for="discount_percentage">Discount Percentage:</label>
            <input type="number" id="discount_percentage" name="discount_percentage" step="any" required>
        </div>

        <div class="form-group">
            <label for="current_price">Current Price:</label>
            <input type="number" id="current_price" name="current_price" step="any" required>
        </div>

        <div class="form-group">
            <label for="original_price">Original Price:</label>
            <input type="number" id="original_price" name="original_price" step="any" required>
        </div>

        <button type="submit">Add Product</button>
    </form>
</div>

<!-- JavaScript for Popup and Redirection -->
<?php if (isset($redirect) && $redirect) { ?>
    <script type="text/javascript">
        alert("Product added successfully!");
        window.location.href = "shop.php";
    </script>
<?php }
?>

</body>
</html>
