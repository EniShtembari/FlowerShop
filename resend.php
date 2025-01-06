<?php
session_start();
require_once 'connect.php';

$email = $_SESSION['email'] ?? null;

if ($email) {
    $pdo = require 'connect.php';

    // Generate new code and expiration
    $newCode = random_int(100000, 999999);
    $newExpiration = date('Y-m-d H:i:s', time() + 90);

    $stmt = $pdo->prepare('UPDATE users SET verificationCode = :verificationCode, code_expiration = :code_expiration WHERE email = :email');
    $stmt->execute([
        'verificationCode' => $newCode,
        'code_expiration' => $newExpiration,
        'email' => $email,
    ]);

    // Send the new code via email (reuse PHPMailer code from `user-account.php`)

    $_SESSION['success'] = 'A new verification code has been sent to your email.';
    header('Location: verify.php');
    exit();
} else {
    $_SESSION['errors'] = ['Session expired. Please register again.'];
    header('Location: register.php');
    exit();
}
