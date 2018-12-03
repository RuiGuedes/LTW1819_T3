<?php
    include_once('../templates/tpl_register.php');

    $email    = isset($_GET['email'])    ? $_GET['email']    : '';
    $username = isset($_GET['username']) ? $_GET['username'] : '';

    draw_register(htmlentities($email), $username);
?>