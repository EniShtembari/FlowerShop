<?php
$pdo = require __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"], $_POST["code"])) {
    $email = $_POST["email"];
    $code = $_POST["code"];

    // Get user ID first
    $userSql = "SELECT id FROM users WHERE email = :email";
    $userStmt = $pdo->prepare($userSql);
    $userStmt->bindParam(':email', $email);
    $userStmt->execute();
    $userId = $userStmt->fetchColumn();

    // Modified query to get the most recent reset code
    $codeSql = "
        SELECT * 
        FROM verification_codes 
        WHERE id = :userId 
        AND resetPasswordCode IS NOT NULL 
        ORDER BY resetPasswordExpiration DESC 
        LIMIT 1
    ";

    $codeStmt = $pdo->prepare($codeSql);
    $codeStmt->bindParam(':userId', $userId);
    $codeStmt->execute();
    $codeResult = $codeStmt->fetch(PDO::FETCH_ASSOC);

    if (
        $codeResult &&
        $codeResult['resetPasswordCode'] === $code &&
        strtotime($codeResult['resetPasswordExpiration']) > time()
    ) {
        header('Location: resetPassword.php?email=' . urlencode($email));
        exit();
    } else {
        $message = "Invalid or expired reset code.";
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
    <?php if (!empty($message)) : ?>
        <div class="error"><?php echo htmlspecialchars($message); ?></div>
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