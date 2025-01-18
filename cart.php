<?php
//session_start();
//
//// Check if the user is logged in
//if (!isset($_SESSION['user_id'])) {
//    header("Location: index.php");
//    exit;
//}
//require_once 'stripe/stripe-php/init.php';
//use Stripe\Stripe;
//use Stripe\Checkout\Session;
//// Stripe API Keys
//$private_key = "sk_test_51QdZaOIA6j8Agjdo5GJTLy0SpIDPNae1bPpzug7GTqcDIUlNR7CKK1ojTH9gGYRe0uEHUjbnpIDGSKukUVTONETg00wfXvfRpk";
//$public_key = "pk_test_51QdZaOIA6j8AgjdoONN2YmHKTojcogE82ZcF8ntm0l1YwdZNUKNnlDgxb62vZ7IBVbS1NfyGQoRNxjWn6o0bvJxE00alHhiENc";
//
//Stripe::setApiKey($private_key);
//
//// Database connection
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "flowershop";
//
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//
//$UserID = $_SESSION['user_id'];
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    // Fetch cart items for the user
//    $sql = "SELECT c.Quantity, p.ProductName, p.ImageURL, p.CurrentPrice,
//            (c.Quantity * p.CurrentPrice) AS TotalPrice
//            FROM cart c
//            JOIN products p ON c.ProductID = p.ProductID
//            WHERE c.UserID = ?";
//    $stmt = $conn->prepare($sql);
//    $stmt->bind_param("i", $UserID);
//    $stmt->execute();
//    $result = $stmt->get_result();
//
//    $totalPrice = 0;
//
//    while ($row = $result->fetch_assoc()) {
//        $totalPrice += $row['TotalPrice']; // Calculate total price
//    }
//
//    // Validate total price
//    if ($totalPrice <= 0) {
//        http_response_code(400);
//        echo json_encode(["error" => "Your cart is empty."]);
//        exit;
//    }
//
//    try {
//        // Create a Payment Intent
//        $paymentIntent = PaymentIntent::create([
//            'amount' => $totalPrice * 100, // Convert to cents
//            'currency' => 'usd',
//            'payment_method_types' => ['card'],
//        ]);
//
//        // Return the client secret to the frontend
//        echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
//    } catch (Exception $e) {
//        http_response_code(500);
//        echo json_encode(['error' => $e->getMessage()]);
//    }
//    exit;
//}
//
//// Fetch cart items for the user
//$sql = "SELECT c.CartID, c.Quantity, p.ProductName, p.ImageURL, p.CurrentPrice,
//        (c.Quantity * p.CurrentPrice) AS TotalPrice
//        FROM cart c
//        JOIN products p ON c.ProductID = p.ProductID
//        WHERE c.UserID = ?";
//$stmt = $conn->prepare($sql);
//$stmt->bind_param("i", $UserID);
//$stmt->execute();
//$result = $stmt->get_result();
//$resultItems = $result;
//
//$totalPrice = 0;
//$line_items = []; // Prepare items for Stripe Checkout
//
//while ($row = $result->fetch_assoc()) {
//    $totalPrice += $row['TotalPrice']; // Accumulate the total price
//
//    // Add each product to the Stripe line items array
//    $line_items[] = [
//        'price_data' => [
//            'currency' => 'usd',
//            'product_data' => [
//                'name' => $row['ProductName'],
//            ],
//            'unit_amount' => $row['CurrentPrice'] * 100, // Convert price to cents
//        ],
//        'quantity' => $row['Quantity'],
//    ];
//}
//
//?>
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$UserID = $_SESSION['user_id'];

// Fetch total price for the cart
$totalPrice = 0;
$sqlTotal = "SELECT SUM(c.Quantity * p.CurrentPrice) AS TotalPrice
        FROM cart c
        JOIN products p ON c.ProductID = p.ProductID
        WHERE c.UserID = ?";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param("i", $UserID);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();

if ($row = $resultTotal->fetch_assoc()) {
    $totalPrice = $row['TotalPrice'];
}

// Fetch cart items for the table display
$sqlItems = "SELECT c.CartID, c.Quantity, p.ProductName, p.ImageURL, p.CurrentPrice, 
            (c.Quantity * p.CurrentPrice) AS TotalPrice
        FROM cart c
        JOIN products p ON c.ProductID = p.ProductID
        WHERE c.UserID = ?";
$stmtItems = $conn->prepare($sqlItems);
$stmtItems->bind_param("i", $UserID);
$stmtItems->execute();
$resultItems = $stmtItems->get_result();


// Define your public Stripe key
$public_key = 'your-public-stripe-key-here';
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Cart</title>
        <link rel="stylesheet" href="cart.css">
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
    <?php
    // Include the header at the very top, before the main content starts
    require 'header.php';
    ?>
    <div class="cart-container">
        <h1>Your Shopping Cart</h1>
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $resultItems->fetch_assoc()): ?>
                <tr>
                    <!-- Product Image and Name -->
                    <td>
                        <div class="product-info">
                            <img src="<?php echo htmlspecialchars($row['ImageURL']); ?>"
                                 alt="<?php echo htmlspecialchars($row['ProductName']); ?>">
                            <span><?php echo htmlspecialchars($row['ProductName']); ?></span>
                        </div>
                    </td>
                    <!-- Quantity -->
                    <td>
                        <form action="updateCart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="cartID" value="<?php echo $row['CartID']; ?>">
                            <button type="submit" name="action" value="decrease">-</button>
                            <input type="text" class="quantity-input" name="quantity"
                                   value="<?php echo $row['Quantity']; ?>" readonly>
                            <button type="submit" name="action" value="increase">+</button>
                        </form>
                    </td>
                    <!-- Price and Total -->
                    <td>$<?php echo $row['CurrentPrice']; ?></td>
                    <td>$<?php echo $row['TotalPrice']; ?></td>
                    <!-- Delete Action -->
                    <td class="actions">
                        <form action="updateCart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="cartID" value="<?php echo $row['CartID']; ?>">
                            <button type="submit" name="action" value="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <div class="total-price">Total Price: $<?php echo $totalPrice; ?></div>
        <div class="button-container">
            <a href="shop.php" class="button continue-shopping">Continue shopping</a>
            <button class="checkout-button" id="checkoutButton">Proceed to Checkout</button>
        </div>
    </div>
    <script>
        const stripe = Stripe('<?php echo htmlspecialchars($public_key); ?>'); // Your public Stripe key

        document.getElementById('checkoutButton').addEventListener('click', function () {
            // Send POST request to create a Payment Intent
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Failed to create a payment intent. Please try again.');
                    }
                    return response.json();
                })
                .then(function (data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Get the client secret from the response
                    const clientSecret = data.clientSecret;

                    // Confirm the payment using Stripe Elements
                    stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: {
                                // Pass the card input here using a Stripe Element (requires additional setup)
                                // Example: if you have a card element initialized (not shown in this example),
                                // this would look like: `card: cardElement`
                            },
                        },
                    })
                        .then(function (result) {
                            if (result.error) {
                                // Show error to the customer
                                alert(result.error.message);
                            } else if (result.paymentIntent.status === 'succeeded') {
                                // Payment successful
                                alert('Payment successful!');
                                // Redirect or display success
                                window.location.href = 'success.php';
                            }
                        });
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    </script>
    <?php
    require 'footer.php';
    ?>
    </body>
    </html>
