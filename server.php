<?php
include './connection.php';

// initializing variables
$username = "";
$email    = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password_1 = $_POST['password_1'];
  $password_2 = $_POST['password_2'];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { $errors[] = "Username is required"; }
  if (empty($email)) { $errors[] = "Email is required"; }
  if (empty($password_1)) { $errors[] = "Password is required"; }
  if ($password_1 !== $password_2) {
    $errors[] = "The two passwords do not match";
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    if (isset($db)) {
        $result = $db->query($user_check_query);
    }
    if (isset($result)) {
        $user = $result->fetch(PDO::FETCH_ASSOC);
    }

    if (isset($user) && $user) { // if user exists
      if ($user['username'] === $username) {
        $errors[] = "Username already exists";
        echo "<script>alert('Username already exists')</script>";
      }

      if ($user['email'] === $email) {
        $errors[] = "email already exists";
        echo "<script>alert('email already exists')</script>";
      }
    }

  // Finally, register user if there are no errors in the form
  if (empty($errors)) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password)
  			  VALUES('$username', '$email', '$password')";
      if (isset($db)) {
          $db->exec($query);
      }
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are
  	logged in";
  	header('location: index.php');
  }
}

if (isset($_POST['login_user'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username)) {
  	$errors[] = "Username is required";
  }
  if (empty($password)) {
  	$errors[] = "Password is required";
  }

    if (empty($errors)) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'" ;
        //handling the result
        if (isset($db)) {
            $result = $db->query($query);
        }
        if (isset($result)) {
            $user = $result->fetch(PDO::FETCH_ASSOC);
        }
        if (isset($user) && $user) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are logged in";
            header('location: index.php');
        } else {
            echo "<script>alert('Wrong username/password combination')</script>";
        }
    }
}
