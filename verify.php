<?php
session_start();
require_once 'connect.php';
global $pdo;

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $email = $_SESSION['email'] ?? null;
    $code = $_POST['verificationCode'];

    if (empty($code)) {
        $errors[] = 'Verification code is required.';
    }

    if ($email) {
        // Check if the verification code is correct
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND verificationCode = :code AND status = :status');
        $stmt->execute(['email' => $email, 'code' => $code, 'status' => 'unverified']);
        $user = $stmt->fetch();

        if ($user) {
            // Update status to "verified"
            $stmt = $pdo->prepare('UPDATE users SET status = :status WHERE email = :email');
            $stmt->execute(['status' => 'verified', 'email' => $email]);

            // Redirect to the login page
            $_SESSION['success_message'] = 'Email verified successfully! Please log in.';
            header('Location: index.php');
            exit();
        } else {
            $errors[] = 'Invalid verification code.';
        }
    } else {
        $errors[] = 'Session expired. Please register again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" id="verify">
    <h1 class="form-title">Verify Email</h1>

    <?php if ($errors): ?>
        <div class="error-main">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="verify.php">
        <div class="input-group">
            <input type="text" name="verificationCode" placeholder="Enter 6-digit code" required>
        </div>
        <input type="submit" class="btn" value="Verify" name="verify">
    </form>
</div>
</body>
</html>

