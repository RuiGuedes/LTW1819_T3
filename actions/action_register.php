<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordCheck = $_POST['passwordCheck'];

    // Input Filtering (Email must be encoded instead)
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        // Error Message -> Invalid characters on username
        die(header('Location: ../pages/register.php'));
    }


    if ($password === $passwordCheck) {
        try {
            insert_user($email, $username, $password);
            $_SESSION['username'] = $username;
            die(header('Location: ../pages/feed.php'));
          } catch (PDOException $e) {
            // Error Message -> Register failed
            header('Location: ../pages/register.php');
          }
    }
    else {
        // Warning Message -> Password Check different from password
        header('Location: ../pages/register.php');
    }
?>