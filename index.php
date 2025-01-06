<?php
session_start();  // Start the session

// Include database connection
$pdo = require __DIR__ . '/connect.php';
if (!isset($pdo)) {
    die('Database connection not established.');
}

// Initialize variables
$success_message = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
$error_message = null;
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate input
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

                    // Check account status
                    if ($user['status'] === 'unverified') {
                        $errors['unverified'] = 'Your account is not verified. Please verify your email.';
                    } else {
                        // Set session variables for the logged-in user
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['firstName'] = $user['firstName'];

                        // Redirect to homepage
                        header('Location: homepage.php');
                        exit();
                    }
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
                            $stmt->execute([
                                ':attempts' => $new_attempts,
                                ':blockedUntil' => $blocked_until,
                                ':user_id' => $user['id']
                            ]);
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

    <!-- Login Form -->
    <form method="POST" action="">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <i class="fas fa-eye" id="eye"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
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
