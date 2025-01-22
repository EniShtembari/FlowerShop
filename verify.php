<?php
global $pdo;
session_start();
require_once 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "Email is not set.";
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $email = $_SESSION['email'] ?? null;
    $code = $_POST['verificationCode'];

    if (!$email) {
        $errors[] = 'Session expired. Please register again.';
    } elseif (empty($code)) {
        $errors[] = 'Verification code is required.';
    } else {
        //merr id e userit ne baze te emailit
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Fetch detajet e verification code
            $stmt = $pdo->prepare('SELECT * FROM verification_codes WHERE id = :id AND status = :status');
            $stmt->execute([
                'id' => $user['id'],
                'status' => 'unverified',
            ]);
            $verification = $stmt->fetch();

            if ($verification) {
                $currentTime = date('Y-m-d H:i:s');
                if ($currentTime > $verification['verificationCodeExpiration']) {
                    $errors[] = 'The verification code has expired. Please request a new code.';
                } elseif ($verification['verificationCode'] === $code) {
                    // statusi do te behet verified
                    $stmt = $pdo->prepare('UPDATE verification_codes SET status = :status WHERE id = :id');
                    $stmt->execute([
                        'status' => 'verified',
                        'id' => $user['id'],
                    ]);

                    $_SESSION['success_message'] = 'Email verified successfully!';
                    header('Location: index.php');
                    exit();
                } else {
                    $errors[] = 'Invalid verification code.';
                }
            } else {
                $errors[] = 'Invalid request. Verification details not found.';
            }
        } else {
            $errors[] = 'Invalid request. User not found.';
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
    <link rel="stylesheet" href="css/style.css">
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
    <p>Didn't receive the code? <a href="resend.php">Resend Code</a></p>
</div>
</body>
</html>
