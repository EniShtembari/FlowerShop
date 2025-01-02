<?php
session_start();  // Start the session

// Database connection
$pdo = require __DIR__ . '/connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["sig"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check for failed attempts
        $stmt = $pdo->prepare("SELECT * FROM login_attempts WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user['id']]);
        $attempts = $stmt->fetch(PDO::FETCH_ASSOC);

        // Block login if the user is blocked
        if ($attempts && $attempts['blockedUntil'] > date('Y-m-d H:i:s')) {
            $error_message = "Your account is blocked. Try again after " . $attempts['blockedUntil'];
        } else {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Successful login: reset attempts
                $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE user_id = :user_id");
                $stmt->execute([':user_id' => $user['id']]);

                // Start session for the user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: user-account.php");  // Redirect to user account
                exit();
            } else {
                // Failed login: handle attempts
                if (!$attempts) {
                    // No previous attempts: create record
                    $stmt = $pdo->prepare("INSERT INTO login_attempts (user_id, attempts, lastAttempt) VALUES (:user_id, 1, NOW())");
                    $stmt->execute([':user_id' => $user['id']]);
                } else {
                    // Update failed attempts
                    $new_attempts = $attempts['attempts'] + 1;

                    // Block if attempts exceed the limit
                    if ($new_attempts >= 7) {
                        $blocked_until = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                        $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = :attempts, lastAttempt = NOW(), blockedUntil = :blockedUntil WHERE user_id = :user_id");
                        $stmt->execute([':attempts' => $new_attempts, ':blockedUntil' => $blocked_until, ':user_id' => $user['id']]);
                        $error_message = "Too many failed attempts. You are blocked for 30 minutes.";
                    } else {
                        // Increment attempts
                        $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = :attempts, lastAttempt = NOW() WHERE user_id = :user_id");
                        $stmt->execute([':attempts' => $new_attempts, ':user_id' => $user['id']]);
                        $error_message = "Invalid email or password.";
                    }
                }
            }
        }
    } else {
        $error_message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" id="login">
    <h1 class="form-title">Login</h1>
    <form method="POST" action="">

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fa fa-eye" id="eye"></i>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="error-main">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <a href="forgotPassword.php">Forgot password</a>
        <br><br>
        <input type="submit" class="btn" value="Log in" name="sig">

    </form>

    <div class="links">
        <p>Don't have an account yet?</p>
        <a href="register.php">Register</a>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
