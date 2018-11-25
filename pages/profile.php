<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_profile.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    draw_common($_SESSION['username'], ['profile.css'], []);
    draw_profile($_SESSION['username']);
    draw_footer();
?>