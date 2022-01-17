<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

try {
  $db = new PDO('mysql:host=localhost;dbname=php', 'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

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
      }

      if ($user['email'] === $email) {
        $errors[] = "email already exists";
      }
    }

  // Finally, register user if there are no errors in the form
  if (count($errors) === 0) {
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

  if (count($errors) === 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = $db->query($query);
  	if ($results->rowCount() === 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		$errors[] = "Wrong username/password combination";
  	}
  }
}

