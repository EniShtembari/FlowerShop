<?php
$pdo = require __DIR__ . '/connect.php';

// handle initial reset code submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"], $_POST["code"])) {
    $email = $_POST["email"];
    $code = $_POST["code"];

    // merr id e userit
    $userSql = "SELECT id FROM users WHERE email = :email";
    $userStmt = $pdo->prepare($userSql);
    $userStmt->bindParam(':email', $email);
    $userStmt->execute();
    $userId = $userStmt->fetchColumn();

    if ($userId) {
        // kontrollo nese ekziston nje vlere aktuale
        $checkSql = "SELECT id FROM verification_codes WHERE id = :userId";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':userId', $userId);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn()) {
            // updato kodin
            $updateSql = "
                UPDATE verification_codes 
                SET 
                    resetPasswordCode = :code,
                    resetPasswordExpiration = DATE_ADD(NOW(), INTERVAL 1 HOUR),
                    status = 'unverified'
                WHERE id = :userId
            ";
            $stmt = $pdo->prepare($updateSql);
        } else {
            // shto rekord te ri
            $insertSql = "
                INSERT INTO verification_codes 
                (id, resetPasswordCode, resetPasswordExpiration, status) 
                VALUES 
                (:userId, :code, DATE_ADD(NOW(), INTERVAL 1 HOUR), 'unverified')
            ";
            $stmt = $pdo->prepare($insertSql);
        }

        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':userId', $userId);

        if ($stmt->execute()) {
            $message = "Reset code saved successfully!";
            $messageClass = "success";
        } else {
            $message = "Error saving reset code.";
            $messageClass = "error";
        }
    } else {
        $message = "User not found.";
        $messageClass = "error";
    }
}

// handle password reset
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["password"], $_POST["confirmPassword"], $_POST["email"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($password !== $confirmPassword) {
        $message = "Passwords do not match!";
        $messageClass = "error";
    } else {
        // Merr id e userit dhe kodin nqs jan valid
        $sql = "SELECT u.id, vc.resetPasswordCode 
                FROM users u 
                JOIN verification_codes vc ON u.id = vc.id 
                WHERE u.email = :email 
                AND vc.resetPasswordExpiration > NOW()
                AND vc.status = 'unverified'
                ORDER BY vc.resetPasswordExpiration DESC 
                LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $updateSql = "UPDATE users SET password = :password WHERE id = :userId";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':password', $hashedPassword);
            $updateStmt->bindParam(':userId', $result['id']);

            if ($updateStmt->execute()) {
                $markUsedSql = "UPDATE verification_codes 
                              SET status = 'verified',
                                  resetPasswordCode = NULL,
                                  resetPasswordExpiration = NULL 
                              WHERE id = :userId";
                $markUsedStmt = $pdo->prepare($markUsedSql);
                $markUsedStmt->bindParam(':userId', $result['id']);
                $markUsedStmt->execute();

                $message = "Password successfully reset! You can now login with your new password.";
                $messageClass = "success";
            } else {
                $message = "Error updating password.";
                $messageClass = "error";
            }
        } else {
            $message = "Invalid or expired reset link.";
            $messageClass = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-weight: 500;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.2s;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="form-title">Reset Password</h1>
    <?php if (!empty($message)) : ?>
        <div class="message <?php echo $messageClass; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
        <input type="hidden" name="code" value="<?php echo htmlspecialchars($_GET['code'] ?? ''); ?>">
        <div class="input-group">
            <i class="fas fa-eye" id="eyePassword"></i>
            <input type="password" name="password" id="password" placeholder="New password" required>
        </div>
        <div class="input-group">
            <i class="fas fa-eye" id="eyeConfirm"></i>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm new password" required>
        </div>
        <div class="button-container">
            <button type="submit" class="btn">Reset Password</button>
            <a href="index.php" class="btn-secondary">Back to Login</a>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function togglePassword(eyeIcon, passwordInput) {
            eyeIcon.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
        }

        const eyePassword = document.getElementById('eyePassword');
        const eyeConfirm = document.getElementById('eyeConfirm');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirmPassword');

        togglePassword(eyePassword, passwordInput);
        togglePassword(eyeConfirm, confirmInput);
    });
</script>
</body>
</html>