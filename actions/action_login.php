<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

  if (validate_login($username, $password)) {
    $_SESSION['username'] = $username;
    header('Location: ../pages/feed.php');
  } else {
    header('Location: ../pages/login.php');
  }

?>