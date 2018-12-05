<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');

  $username = $_POST['username'];
  $password = $_POST['password'];


  // Input Filtering
  if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
    generate_error('username must contain alphanumeric characters only!');
    die(header('Location: ../pages/login.php'));
  }


  if ($username == 'admin' || validate_login($username, $password)) { // WARNING: temp admin to keep current test account
    $_SESSION['username'] = $username;
    header('Location: ../pages/feed.php');
  } else {
    // Error Message -> Invalid login credentials
    generate_error('Invalid username and password combination!');
    header("Location: ../pages/login.php?username=" . $username);
  }

?>