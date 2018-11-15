<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_feed.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    draw_common($_SESSION['username']);
    draw_feed();
    draw_footer();
?>