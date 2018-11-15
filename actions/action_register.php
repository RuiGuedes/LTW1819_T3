<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordCheck = $_POST['passwordCheck'];
    
    if($password === $passwordCheck) {
        try {
            insert_user($email, $username, $password);
            $_SESSION['username'] = $username;
            die(header('Location: ../templates/feed.html'));
          } catch (PDOException $e) {
            header('Location: ../pages/register.php');
          }
    }

    header('Location: ../pages/register.php');
?>