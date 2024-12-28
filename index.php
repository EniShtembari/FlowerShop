<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" id="login">
        <h1 class="form-title">Login</h1>
        <form method="POST" action="user-account.php">

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fa fa-eye" id="eye"></i>
            </div>

            <p class="forgot-password">Forgot password</p>
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