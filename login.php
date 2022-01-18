<?php include('./server.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <div>
        <h1>Website Title</h1>
        <a href="index.php"><i class="fas fa-home"></i>Home</a>
        <a href="crud/read.php"><i class="fas fa-address-book"></i>Contacts</a>
        <a href="register.php"><i class="fas fa-register"></i>Register</a>
    </div>
</nav>

<div class="header">
    <h2>Login</h2>
</div>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php include('errors.php'); ?>
    <div class="input-group">
        <label>Username
        <input type="text" name="username" >
        </label>
    </div>
    <div class="input-group">
        <label>Password
        <input type="password" name="password">
        </label>
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="login_user">Login</button>
    </div>
    <p>
        Not yet a member? <a href="register.php">Sign up</a>
    </p>
</form>
</body>
</html>