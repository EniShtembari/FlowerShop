<?php
session_start();

// Clear the session
session_unset();
session_destroy();

// Remove the "remember_me" cookie
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/', null, false, true);
}

// Remove the token from the database
if (isset($_SESSION['UserID'])) {
    $pdo = require __DIR__ . '/connect.php';
    $stmt = $pdo->prepare("UPDATE users SET rememberMe = NULL WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['UserID']]);
}

header('Location: index.php');
exit();

