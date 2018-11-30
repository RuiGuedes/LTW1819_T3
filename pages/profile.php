<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_profile.php');
    include_once('../database/db_user.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    $biography = get_user_biography($_SESSION['username']);

    $myChannels = get_user_subscriptions($_SESSION['username']);
  
    $filter = isset($_POST['filter']) ? $_POST['filter'] : 2;
    $userStories = get_user_stories($_SESSION['username'], $filter);
    
    draw_common($_SESSION['username'], ['profile.css'], [], $filter);
    draw_profile($_SESSION['username'], htmlentities($biography), $myChannels, $userStories);
    draw_footer();
?>