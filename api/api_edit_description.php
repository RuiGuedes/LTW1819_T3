<?php 
    include_once('../includes/session.php');
    include_once('../database/db_user.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Session expired, please login!');
        die(header('Location: ../pages/login.php'));
    }

    // TODO CSRF protection
    if ($_SESSION['username'] != $_POST['username']) {
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Invalid Request!');
        die(header('Location: ../pages/profile.php'));
    }

    set_user_biography($_SESSION['username'], $_POST['description']);

    echo json_encode(get_user_biography($_SESSION['username']));
?>