<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_feed.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    $channels = get_top_channels();

    draw_common($_SESSION['username'], ['feed.css', 'general_aside.css'], []);
    draw_feed();
    draw_general_aside($channels);
    draw_footer();
?>