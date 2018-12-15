<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordCheck = $_POST['passwordCheck'];

    // Input Filtering (Email must be encoded instead)
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        generate_error('username must contain alphanumeric characters only!');
        die(header("Location: ../pages/register.php?email=" . $email));
    }

    // Verifies if password fields match
    if ($password !== $passwordCheck) {
        generate_error('Password confirmation failed - The entered passwords aren\'t the same!');
        die(header("Location: ../pages/register.php?email=" . $email . "&username=" . $username));
    }
    
    // Tries to insert the new user. Generates error if not possible
    try {
        insert_user($email, $username, $password);
        $_SESSION['username'] = $username;
        die(header('Location: ../pages/feed.php'));
    } catch (PDOException $e) {
        generate_error('Selected username already exists!');
        header("Location: ../pages/register.php?email=" . $email);
    }
?>