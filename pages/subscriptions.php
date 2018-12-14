<?php 
    include_once('../includes/session.php');
    include_once('../includes/functions.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_subscriptions.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));
    
    $username = isset($_GET['username']) ? htmlentities($_GET['username']) : $_SESSION['username'];
    $show = isset($_GET['show']) ? htmlentities($_GET['show']) : 'all';
    $defaultFilter = 2;

    if(!check_user_existence($username)) {
      generate_error('Invalid user !');
      die(header('Location: feed.php'));
    }

    // Retrieves channels to be displayed
    $channels = get_user_subscriptions($username);
    if($show === 'all') {
      $channels = get_all_channels();
    }
    else if($show === 'subscriptions'){
      $channels = get_user_subscriptions($username);
    }
    else {
      generate_error('Invalid show value ! Available show values: <all> OR <subscriptions>');
      die(header('Location: feed.php'));
    }

    // Retrieves top 10 channels
    $topChannels = get_top_channels();

    draw_common($_SESSION['username'], ['subscriptions.css', 'general_aside.css'], [], $defaultFilter);
    draw_user_subscriptions(htmlentities_all($channels));
    draw_general_aside(htmlentities_all($topChannels), display_messages());
    draw_footer();
?>