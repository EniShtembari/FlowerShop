<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

require_once 'connect.php';

session_start();

// Check if email exists in the session
$email = $_SESSION['email'] ?? null;

if ($email) {
    $pdo = require 'connect.php';

    try {
        // Generate a new verification code and expiration time
        $newCode = random_int(100000, 999999);
        $newExpiration = date('Y-m-d H:i:s', time() + 90);

        // Update the verification code and expiration in the database
        $stmt = $pdo->prepare('UPDATE users SET verificationCode = :verificationCode, codeExpiration = :codeExpiration WHERE email = :email');
        $stmt->execute([
            'verificationCode' => $newCode,
            'codeExpiration' => $newExpiration,
            'email' => $email,
        ]);

        // Send the new verification code via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply.bloomflowers@gmail.com';
            $mail->Password = 'nbtk lstr ogqa bpoo'; // Use App Password here
            $mail->SMTPSecure ='tsl';
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
            $mail->Subject = 'Resend Verification Code';
            $mail->Body = "Hi,<br><br>Your new verification code is: <b>$newCode</b><br><br>Please enter this code to verify your email. The code will expire in 90 seconds.<br><br>Thanks!";

            $mail->send();
            $_SESSION['success'] = 'A new verification code has been sent to your email.';
        } catch (Exception $e) {
            $_SESSION['errors'] = ['Failed to send email: ' . $mail->ErrorInfo];
        }
    } catch (PDOException $e) {
        $_SESSION['errors'] = ['Database error: ' . $e->getMessage()];
    }

    header('Location: verify.php');
    exit();
} else {
    // If the email is not in the session, redirect to the registration page
    $_SESSION['errors'] = ['Session expired. Please register again.'];
    header('Location: register.php');
    exit();
}
