<?php
global $pdo;
session_start();
require_once 'connect.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $email = $_SESSION['email'] ?? null;
    $code = $_POST['verificationCode'];

    if (!$email) {
        $errors[] = 'Session expired. Please register again.';
    } elseif (empty($code)) {
        $errors[] = 'Verification code is required.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND verificationCode = :code AND status = :status');
        $stmt->execute(['email' => $email, 'code' => $code, 'status' => 'unverified']);
        $user = $stmt->fetch();

        if ($user) {
            $stmt = $pdo->prepare('UPDATE users SET status = :status WHERE email = :email');
            $stmt->execute(['status' => 'verified', 'email' => $email]);
            $_SESSION['success_message'] = 'Email verified successfully!';
            header('Location: index.php');
            exit();
        } else {
            $errors[] = 'Invalid verification code.';
        }
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
    <h1>Verify Email</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-main">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <input type="text" name="verificationCode" placeholder="Enter 6-digit code" required>
        </div>
        <button type="submit" name="verify" class="btn">Verify</button>
    </form>
</div>
</body>
</html>
