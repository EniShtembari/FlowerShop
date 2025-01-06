<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

$pdo = require __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];
    $code = rand(100000, 999999); // 6-digit code
    $expiry = time() + 90; // 90 seconds

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Update reset code and expiration
        $sql = "UPDATE users 
                SET resetPassword = :resetPassword, resetPasswordExpiration = :resetPasswordExpiration 
                WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':resetPassword', $code);
        $stmt->bindParam(':resetPasswordExpiration', date("Y-m-d H:i:s", $expiry));
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            // Send the reset code via email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply.bloomflowers@gmail.com';
                $mail->Password = 'your-app-password'; // Replace with an app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('noreply.bloomflowers@gmail.com', 'Bloom Flowers');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Code';
                $mail->Body = "Hi,<br><br>Your password reset code is: <b>$code</b><br>This code will expire in 1.5 minutes.";

                $mail->send();
                header('Location: verifyReset.php?email=' . urlencode($email));
                exit();
            } catch (Exception $e) {
                $message = "Failed to send the email: " . $mail->ErrorInfo;
            }
        } else {
            $message = "Error updating reset code in the database.";
        }
    } else {
        $message = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Forgot Password</h1>
    <?php if (!empty($message)) : ?>
        <div class="error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Reset Code</button>
    </form>
</div>
</body>
</html>
