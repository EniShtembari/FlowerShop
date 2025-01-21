<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

$pdo = require __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];
    $code = rand(100000, 999999); // kodi i rigjeneruar 6 shifror
    $expiry = time() + 90; // 1 minute 30 seconda

    // kontrollo nese emaili eshte ne tabelen users
    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $user['id'];

        // update resetPasswordCode dhe resetPasswordExpiration
        $sql = "
            INSERT INTO verification_codes (id, resetPasswordCode, resetPasswordExpiration, status)
            VALUES (:id, :resetPasswordCode, :resetPasswordExpiration, 'unverified')
            ON DUPLICATE KEY UPDATE 
                resetPasswordCode = :resetPasswordCode,
                resetPasswordExpiration = :resetPasswordExpiration,
                status = 'unverified'
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':resetPasswordCode', $code);
        $resetPasswordExpiration = date("Y-m-d H:i:s", $expiry);
        $stmt->bindParam(':resetPasswordExpiration', $resetPasswordExpiration);

        if ($stmt->execute()) {
            // Send the reset code via email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply.bloomflowers@gmail.com';
                $mail->Password = 'nbtk lstr ogqa bpoo'; // Use App Password here
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="form-title">Forgot Password</h1>
    <?php if (!empty($message)) : ?>
        <div class="error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <button type="submit" class="btn">Send Reset Code</button>
    </form>

    <div id="loginLink" style="display: none;">
    <a href="index.php">Log in</a>
    </div>

</div>

<script>
    // Server-provided flag for visibility
    const showLoginLink = <?php echo json_encode(isset($showLoginLink) ? $showLoginLink : false); ?>;

    // Manage visibility of elements
    if (showLoginLink) {
        document.getElementById("resetForm").style.display = "none"; // Hide the form
        document.getElementById("loginLink").style.display = "block"; // Show the login link
    }
</script>
</body>
</html>
