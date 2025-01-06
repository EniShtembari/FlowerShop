<?php
$pdo = require __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"], $_POST["code"])) {
    $email = $_POST["email"];
    $code = $_POST["code"];

    // Check if the reset code is valid and not expired
    $sql = "SELECT resetPassword, resetPasswordExpiration FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['resetPassword'] == $code && time() < strtotime($user['resetPasswordExpiration'])) {
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Verify Reset Code</h1>
    <?php if (!empty($message)) : ?>
        <div class="error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
        <input type="text" name="code" placeholder="Enter reset code" required>
        <button type="submit">Verify Code</button>
    </form>
</div>
</body>
</html>
