<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" id="signup" style="display: none">
    <h1 class="form-title">Register</h1>
    <form method="POST" action="">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="firstName" id="firstName" placeholder="First Name" required>
            <label for="firstName">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lastName" id="lastName" placeholder="Last Name" required>
            <label for="lastName">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="confirmPassword" name="confirmPassword" id="confirmPassword" placeholder="Repeat password" required>
            <label for="confirmPassword">Repeat password</label>
        </div>
        <input type="submit" class="btn" value="Sign up" name="sig">
        <div class="links">
            <p>Already have an account?</p>
            <button id="logInButton">Log in</button>
        </div>
    </form>
</div>


    <div class="container" id="login">
        <h1 class="form-title">Login</h1>
        <form method="POST" action="">

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <p>Fogot password</p>
            <input type="submit" class="btn" value="Log in" name="sig">
            <div class="links">
                <p>Don't have an account yet?</p>
                <button id="signUpButton">Sign Up</button>
            </div>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>