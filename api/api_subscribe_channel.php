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

    $channelName = $_POST['channelName'];
    $username = $_POST['username'];

    // Subscribes or unsubscribes a channel 
    if(check_channel_existence($channelName)) 
        check_user_subscription($username, $channelName) ? remove_subscription($username, $channelName) : add_new_subscription($username, $channelName);
?>