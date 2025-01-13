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

// Start session to track logged-in user
session_start();
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$user_id = $_SESSION['user_id'];  // Retrieve user_id from session

// Add product to wishlist
if (isset($_GET['add_to_wishlist'])) {
    $product_id = $_GET['add_to_wishlist'];

    // Prevent SQL injection using prepared statements
    $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product added to wishlist.');</script>";
    } else {
        echo "<script>alert('Error adding product to wishlist: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Remove product from wishlist
if (isset($_GET['remove_from_wishlist'])) {
    $product_id = $_GET['remove_from_wishlist'];

    // Prevent SQL injection using prepared statements
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product removed from wishlist.');</script>";
    } else {
        echo "<script>alert('Error removing product from wishlist: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fetch wishlist products for the logged-in user
$sql = "SELECT products.* 
        FROM wishlist 
        JOIN products ON wishlist.product_id = products.ProductID 
        WHERE wishlist.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/FlowerShop/wishlist.css">
    <title>My Wishlist</title>
</head>
<body>
<header>
    <h1>My Wishlist</h1>
</header>
<div class="container">
    <?php
    // Check if the user has any products in their wishlist
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="wishlist-item">';
            echo '<img src="' . $row['ImageURL'] . '" alt="' . $row['ProductName'] . '">';
            echo '<div class="item-details">';
            echo '<div class="item-title">' . $row['ProductName'] . '</div>';
            echo '<div class="item-price">$' . $row['CurrentPrice'] . '</div>';
            echo '</div>';
            echo '<button class="remove-btn">
                          <a href="wishlist.php?remove_from_wishlist=' . $row['ProductID'] . '">Remove</a>
                      </button>';
            echo '</div>';
        }
    } else {
        // Display this message if no products are in the wishlist
        echo "<p>Your wishlist is empty.</p>";
    }
    ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
