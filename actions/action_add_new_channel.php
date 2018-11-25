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
        echo "<script type='text/javascript'>alert('channel already exists!')</script>";

    header('Location: ../pages/profile.php');
?>