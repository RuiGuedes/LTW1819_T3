<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Session expired, please login!');
        die(header('Location: ../pages/login.php'));
    }

    $channelName = $_POST['channelName'];
    $logged_username = $_SESSION['username'];
    $profile = $_GET['username'];

    if($profile !== $logged_username) {
        generate_error('You can\'t create channels on other person profile !');
        die(header("Location: ../pages/profile.php?username=" . $profile));
    }

    if (!check_channel_existence($channelName)) {
        add_new_channel($channelName, $username);
        add_new_subscription($username, $channelName);
    }
    else 
        generate_error('Channel already exists!');
    
    header('Location: ../pages/profile.php?username=' . $_SESSION['username']);
?>