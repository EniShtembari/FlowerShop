<?php
session_start();
$pdo = require_once 'connect.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    $_SESSION['errors'] = ['token' => 'Invalid verification token.'];
    header('Location: index.php');
    exit();
}

// Check if token exists and is valid
$stmt = $pdo->prepare('SELECT * FROM users WHERE token = :token AND status = "unverified"');
$stmt->execute(['token' => $token]);
$user = $stmt->fetch();

if ($user) {
    // Update user status to verified
    $stmt = $pdo->prepare('UPDATE users SET status = "verified", token = NULL WHERE id = :id');
    $stmt->execute(['id' => $user['id']]);
    $_SESSION['success'] = 'Your email has been verified. You can now log in.';
    header('Location: index.php');
} else {
    $_SESSION['errors'] = ['verification' => 'Invalid or expired verification token.'];
    header('Location: index.php');
}
exit();
?>
