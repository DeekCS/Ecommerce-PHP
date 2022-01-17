<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Register</h2>
</div>

<form id="register" method="post" action="register.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
        <label>Username
        <input type="text" id="username" name="username" value="<?php echo $username; ?>"
        placeholder="Enter username">
        </label>
        <small class="username-error"></small>
    </div>
    <div class="input-group">
        <label>Email
        <input type="email" id="email" name="email" value="<?php echo $email; ?>"
        placeholder="Enter your email...">
        </label>
        <small class="email-error"></small>
    </div>
    <div class="input-group">
        <label>Password
        <input id="password" type="password" name="password_1" placeholder="Enter Password...">
        </label>
        <small class="password-error"></small>
    </div>
    <div class="input-group">
        <label>Confirm password
        <input id="password2" type="password" name="password_2" placeholder="Confirm your password...">
        </label>
        <small class="password2-error"></small>
    </div>
    <div class="input-group">
        <button id="submit" type="submit" class="btn" name="reg_user">Register</button>
    </div>
    <p>
        Already a member? <a href="login.php">Sign in</a>
    </p>
</form>
<script src="validate.js"></script>
</body>
</html>