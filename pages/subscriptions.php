<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_subscriptions.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));
    
    $subscriptions = get_user_subscriptions($_SESSION['username']);

    $channels = get_top_channels();

    draw_common($_SESSION['username'], ['subscriptions.css', 'general_aside.css'], []);
    draw_user_subscriptions($subscriptions);
    draw_general_aside($channels);
    draw_footer();
?>