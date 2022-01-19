<?php
session_start();
include './connection.php';

if (!isset($_SESSION['email'])  ){
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";
//    header('location: ../login.php');
}


?>
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
    <h2>Home Page</h2>
</div>
<div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success" >
            <h3>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>

    <?php  if (isset($_SESSION['email'])) : ?>
        <?php echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        ?>
        <p>Welcome <?php echo ucfirst($_SESSION[0]['first_name']); ?></strong></p>
        <p> <a  href="logout.php?logout=true" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

</body>
</html>