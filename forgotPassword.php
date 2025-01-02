<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $token = bin2hex(random_bytes(16));
        $tokenHash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        $pdo = require __DIR__ . "/connect.php";

        if (!($pdo instanceof PDO)) {
            die("Database connection failed or returned an invalid object.");
        }

        $sql = "UPDATE users
                SET resetPassword = :resetPassword,
                    resetPasswordExpiresAt = :resetPasswordExpiresAt
                WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':resetPassword', $tokenHash);
        $stmt->bindParam(':resetPasswordExpiresAt', $expiry);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $message = "Reset token generated and saved successfully.";
                $messageClass = "success-main";
            } else {
                $message = "Email address not found in the database.";
                $messageClass = "error-main";
            }
        } else {
            $message = "Error updating the database.";
            $messageClass = "error-main";
        }
    } else {
        $message = "Email is not set.";
        $messageClass = "error-main";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" >
    <h1 class="form-title">Forgot password</h1>

        <?php if (!empty($message)) : ?>
            <div class="<?php echo $messageClass; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <button class="btn">Send</button>

    </form>


</body>
</html>
