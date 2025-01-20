<?php
session_start();
// Lidhja me databazen
$pdo = require __DIR__ . '/connect.php';
if (!isset($pdo)) {
    die('Database connection not established.');
}

// Inicializimi i variablave te erroreve
$success_message = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
$error_message = null;
$errors = [];

// Kontrollo nese ekziston remember me cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    // validimi i remember me
    $stmt = $pdo->prepare("SELECT user_id, token, expires_at FROM remember_me WHERE token = :token AND expires_at > NOW()");
    $stmt->execute([':token' => $token]);
    $rememberMeEntry = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rememberMeEntry) {
        // Fetch user data
        $stmt = $pdo->prepare("SELECT id, email, firstName FROM users WHERE id = :id");
        $stmt->execute([':id' => $rememberMeEntry['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Autentikimi i userit
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstName'] = $user['firstName'];

            // Gjenerojme token te ri dhe ruaj,me ndryshimet ne databaze
            $new_token = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare("UPDATE remember_me SET token = :token, expires_at = :expires_at WHERE user_id = :user_id");
            $stmt->execute([
                ':token' => $new_token,
                ':expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                ':user_id' => $user['id']
            ]);

            // update remember me cookie
            setcookie('remember_me', $new_token, [
                'expires' => time() + (86400 * 30), //86400 sec/dit *30 dit
                'path' => '/',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            header('Location: myAccount.php');
            exit();
        }
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);

    // Input validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    if (empty($errors)) {
        // Query to fetch user by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Handle login attempts
            $stmt = $pdo->prepare("SELECT * FROM login_attempts WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $user['id']]);
            $attempts = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($attempts && $attempts['blockedUntil'] > date('Y-m-d H:i:s')) {
                $error_message = "Your account is blocked. Try again after " . $attempts['blockedUntil'];
            } else {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Login successful, clear login attempts
                    $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE user_id = :user_id");
                    $stmt->execute([':user_id' => $user['id']]);

                    // Set user session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['firstName'] = $user['firstName'];
                    $_SESSION['isAdmin'] = ($user['role'] === 'admin');

                    // Handle "Remember Me" functionality
                    if ($remember_me) {
                        $token = bin2hex(random_bytes(32));
                        $expires_at = date('Y-m-d H:i:s', strtotime('+30 days'));

                        // Insert or update token in the remember_me table
                        $stmt = $pdo->prepare("
                            INSERT INTO remember_me (user_id, token, expires_at, created_at)
                            VALUES (:user_id, :token, :expires_at, NOW())
                            ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at, created_at = NOW()
                        ");
                        $stmt->execute([
                            ':user_id' => $user['id'],
                            ':token' => $token,
                            ':expires_at' => $expires_at
                        ]);

                        // Set the "remember_me" cookie
                        setcookie('remember_me', $token, [
                            'expires' => time() + (86400 * 30),
                            'path' => '/',
                            'secure' => false,
                            'httponly' => true,
                            'samesite' => 'Strict'
                        ]);
                    }

                    header('Location: myAccount.php');
                    exit();
                } else {
                    // Handle failed login attempts
                    if (!$attempts) {
                        $stmt = $pdo->prepare("INSERT INTO login_attempts (user_id, attempts, lastAttempt) VALUES (:user_id, 1, NOW())");
                        $stmt->execute([':user_id' => $user['id']]);
                    } else {
                        $new_attempts = $attempts['attempts'] + 1;

                        if ($new_attempts >= 7) {
                            $blocked_until = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                            $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = :attempts, lastAttempt = NOW(), blockedUntil = :blockedUntil WHERE user_id = :user_id");
                            $stmt->execute([
                                ':attempts' => $new_attempts,
                                ':blockedUntil' => $blocked_until,
                                ':user_id' => $user['id']
                            ]);
                            $error_message = "Too many failed attempts. You are blocked for 30 minutes.";
                        } else {
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

    <!-- Display success message -->
    <?php if ($success_message): ?>
        <div class="success-main">
            <p><?php echo $success_message; ?></p>
        </div>
    <?php endif; ?>

    <!-- Display error messages -->
    <?php if (!empty($errors) || $error_message): ?>
        <div class="error-main">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
            <?php if ($error_message): ?>
                <p><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Login -->
    <form method="POST" action="">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <i class="fas fa-eye" id="eye"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="input-group-checkbox">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Remember Me</label>
        </div>
        <div class="links" style="text-align: left">
            <a href="forgotPassword.php">Forgot password</a><br><br>
        </div>
        <input type="submit" class="btn" value="Log in" name="login">
    </form>

    <div class="links">
        <p>Don't have an account yet?</p>
        <a href="register.php">Register</a>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>