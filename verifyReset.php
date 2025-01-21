<?php
$pdo = require __DIR__ . '/connect.php';

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
        // kontrollo reset pass aktual
        $verifySql = "
            UPDATE verification_codes 
            SET status = 'verified'
            WHERE id = :userId 
            AND resetPasswordCode = :code
            AND resetPasswordExpiration > NOW()
            AND status = 'unverified'
        ";

        $verifyStmt = $pdo->prepare($verifySql);
        $verifyStmt->bindParam(':userId', $userId);
        $verifyStmt->bindParam(':code', $code);

        if ($verifyStmt->execute() && $verifyStmt->rowCount() > 0) {
            header('Location: resetPassword.php?email=' . urlencode($email));
            exit();
        } else {
            $message = "Invalid or expired reset code.";
            $messageClass = "error";
        }
    } else {
        $message = "User not found.";
        $messageClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Reset Code</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1 class="form-title">Verify Reset Code</h1>
    <?php if (!empty($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
    <?php endif; ?>
    <form method="POST">
        <div class="input-group">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
            <input type="text" name="code" placeholder="Enter reset code" required>
        </div>
        <button type="submit" class="btn">Verify Code</button>
    </form>
</div>
</body>
</html>