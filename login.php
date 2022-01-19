<?php
session_start();
require_once('connection.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $password = md5($_POST['password']);
    echo $email;
    echo $password;
    if (empty($email) || empty($password)) {
        $errors[] = 'All fields are required';
    }
    else{
        $query = "SELECT * FROM members WHERE email = '$email' AND password = '$password'";
        //check using pdo query
        $result = $pdo->query($query);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if($data){
            if ($data[0]['isAdmin'] === 1) {
                $_SESSION['isAdmin'] = true;
                $first_name=$_POST['first_name'];
                $last_name=$_POST['last_name'];
                $_SESSION['email'] = $email;
                header("Location:google.com");
            }
            else{
             $_SESSION['isAdmin'] = false;
             $_SESSION['email'] = $email;
                header("Location:index.php");
            }
        }
        else{
            $errors[] = 'Wrong email or password';
        }
    }
}

?>

<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-5 mt-5 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-25">Login</h1>
            <?php
            if (isset($errors) && count($errors) > 0) {
                foreach ($errors as $error_msg) {
                    echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                }
            }
            ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" placeholder="Enter Email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Password:</label>
                    <input type="password" name="password" placeholder="Enter Password" class="form-control">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                <a href="register.php" class="btn btn-primary">Register</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>