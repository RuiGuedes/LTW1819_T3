<?php 
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        generate_error('Session expired, please login!');
        die(header('Location: ../pages/login.php'));
    }

    // TODO CSRF protection


    if (isset($_POST['username'])) {
        user_edit_description($_POST['username']);
    }
    else if (isset($_POST['channelname'])) {
        channel_edit_description($_POST['channelname']);
    }
    else {
        generate_error('Invalid Request!');
        die(header($_SERVER['PHP_SELF']));
    }

    function user_edit_description($username) {
        if ($_SESSION['username'] != $username) {
            generate_error('Invalid Request!');
            die(header($_SERVER['PHP_SELF']));
        }
    
        set_user_biography($_SESSION['username'], $_POST['description']);
        die(json_encode(get_user_biography($_SESSION['username'])));
    }


    function channel_edit_description($channelname) {
        $channel = get_channel($channelname);
        if ($_SESSION['username'] != $channel['owner']) {
            generate_error('Invalid Request!');
            die(header($_SERVER['PHP_SELF']));
        }

        set_channel_description($channelname, $_POST['description']);
        die(json_encode(get_channel($channelname)['description']));
    }
?>