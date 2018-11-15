<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_login.php');

    // Verify if user is logged in
    if (isset($_SESSION['username']))
      die(header('Location: feed.php'));

    draw_login();
?>