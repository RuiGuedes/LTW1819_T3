<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        generate_error('Session expired, please login!');
        die(header('Location: ../pages/login.php'));
    }

    // Legitimates request
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        generate_error('Request does not appear to be legitimate!');
        die(header('Location: ../actions/action_logout.php'));
    }

    // Needed variables to insert new channel
    $channelName = $_POST['channelName'];
    $logged_username = $_SESSION['username'];
    $username = $_POST['username'];

    if($username !== $logged_username) {
        generate_error('You can\'t create channels on other person profile !');
        die(header("Location: ../pages/profile.php?username=" . $username));
    }

    // Check channel existence
    if (!check_channel_existence($channelName)) {
        add_new_channel($channelName, $username);
        add_new_subscription($username, $channelName);
    }
    else {
        generate_error('Channel already exists!');
    }
    
    header('Location: ../pages/profile.php?username=' . $_SESSION['username']);
?>