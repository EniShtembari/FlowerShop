<?php
session_start();

// boshatis sessionin
session_unset();
session_destroy();

// hiq cookie
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/', null, false, true);
}

// remove the token from the database
if (isset($_SESSION['user_id'])) {
    $pdo = require __DIR__ . '/connect.php';
    $stmt = $pdo->prepare("UPDATE users SET rememberMe = NULL WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);
}

header('Location: index.php');
exit();

