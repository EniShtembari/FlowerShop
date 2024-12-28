<?php
session_start();
if(isset($_SESSION['errors'])){
    $errors=$_SESSION['errors'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" id="register" style="">
    <h1 class="form-title">Register</h1>

    <?php
        if(isset($errors['user_exist'])){
            echo '<div class="error-main"><p>'.$errors['user_exist'].'</p></div>';
            unset($errors['user_exist']);
        }
    ?>

    <form method="POST" action="user-account.php">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="firstName" id="firstName" placeholder="First Name" required>
            <?php
                if(isset($errors['firstName'])){
                    echo '<div class="error"><p>'.$errors['first_name'].'</p></div>';
                }
            ?>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lastName" id="lastName" placeholder="Last Name" required>
            <?php
            if(isset($errors['lastName'])){
                echo '<div class="error"><p>'.$errors['firstName'].'</p></div>';
            }
            ?>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <?php
            if(isset($errors['email'])){
                echo '<div class="error"><p>'.$errors['email'].'</p></div>';
            }
            ?>
        </div>
        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fa fa-eye" id="eye"></i>
            <?php
            if(isset($errors['password'])){
                echo '<div class="error"><p>'.$errors['password'].'</p></div>';
            }
            ?>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirmPassword"  placeholder="Confirm password" required>
            <?php
            if(isset($errors['confirmPassword'])){
                echo '<div class="error"><p>'.$errors['confirmPassword'].'</p></div>';
            }
            ?>
        </div>
        <input type="submit" class="btn" value="Register" name="register">
        <div class="links">
            <p>Already have an account?</p>
            <a href="index.php">Log in</a>
        </div>
    </form>
</div>


<script src="script.js"></script>
</body>
</html>

<?php
if(isset($_SESSION['errors'])){
    unset($_SESSION['errors']);
}
