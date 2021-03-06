<?php
require_once('connection.php');

// initializing variables
$username = "";
$email = "";
$birthday = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    $birthday = $_POST['birthday'];

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password_1)) {
        $errors[] = "Password is required";
    }
    if (empty($birthday)) {
        $errors[] = "Birthday is required";
    }
    if ($password_1 !== $password_2) {
        $errors[] = "The two passwords do not match";
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $stmt = $pdo->prepare($user_check_query);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            $errors[] = "Username already exists";
        }

        if ($user['email'] === $email) {
            $errors[] = "email already exists";
        }
    }


    // Finally, register user if there are no errors in the form
    if (empty($errors)) {
        $password = md5($password_1);//encrypt the password before saving in the database
        $birthday = date('Y-m-d', strtotime($birthday));
        $age = date_diff(date_create($birthday), date_create('now'))->y;
        if ($age < 16) {
            $errors[] = "You are not allowed to register, your age is less than 16";
        } else {
            $query = "UPDATE users SET last_login = NOW() WHERE username = '$username'";
            $stmt = $pdo->query($query);
            $query = "INSERT INTO users (username, email, password, date_of_birth, age)   
  			  VALUES('$username', '$email', '$password', '$birthday', '$age')";
            $stmt = $pdo->query($query);
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['birthday'] = $birthday;
            $_SESSION['age'] = $age;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
    }
}


    if (isset($_POST['login_user'])) {
        $username = $_POST['username'];



        $password = md5($_POST['password']);

        if (empty($username)) {
            $errors[] = "Username is required";
        }
        if (empty($password)) {
            $errors[] = "Password is required";
        }

        if (empty($errors)) {
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $stmt = $pdo->query($query);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            //handling the result
            if ($data) {
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['last_login'] = $data['last_login'];
                $_SESSION['success'] = "You are now logged in";

                if ($data['isAdmin'] === 1) {
                    $_SESSION['isAdmin'] = true;
                    $query = "UPDATE users SET last_login = NOW() WHERE username = '$username'";
                    $stmt = $pdo->query($query);
                    header('location: admin/index.php');
                } else {
                    $query = "UPDATE users SET last_login = NOW() WHERE username = '$username'";
                    $stmt = $pdo->query($query);
                    $_SESSION['isAdmin'] = false;
                    header('location: index.php');
                }
            } else {
                $errors[] = "Wrong username/password combination";
            }
        }
    }
