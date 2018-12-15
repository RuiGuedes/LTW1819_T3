<?php
    include_once('../templates/tpl_register.php');
    include_once('../includes/session.php');

    $email    = isset($_GET['email'])    ? $_GET['email']    : '';
    $username = isset($_GET['username']) ? $_GET['username'] : '';

    draw_register(htmlentities($email), htmlentities($username), display_messages());
?>