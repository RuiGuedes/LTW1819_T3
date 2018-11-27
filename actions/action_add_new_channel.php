<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    $channelName = $_POST['channelName'];
    $username = $_SESSION['username'];

    if(!check_channel_existence($channelName)) {
        add_new_channel($channelName, $username);
        add_new_subscription($username, $channelName);
    }
    else 
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Channel already exists !');
    
    header('Location: ../pages/profile.php');
?>