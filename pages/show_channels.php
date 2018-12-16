<?php 
    include_once('../includes/session.php');
    include_once('../includes/functions.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_show_channels.php');
    include_once('../templates/tpl_general_aside.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
  
    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
      generate_error('Session expired, please login!');
      die(header('Location: ../pages/login.php'));
    }
    
    // Variables
    $username = isset($_GET['username']) ? htmlentities($_GET['username']) : $_SESSION['username'];
    $show = isset($_GET['show']) ? htmlentities($_GET['show']) : 'all';
    $defaultFilter = 2;
    $channels;

    // Checks user existence
    if(!check_user_existence($username)) {
      generate_error('Invalid user ! Try again.');
      die(header('Location: feed.php'));
    }

    // Retrieves channels to be displayed
    if($show === 'all') {
      $channels = get_all_channels();
    }
    else if($show === 'subscriptions'){
      $channels = get_user_subscriptions($username);
    }
    else {
      generate_error('Invalid show value !');
      die(header('Location: feed.php'));
    }

    // Retrieves top 10 channels
    $topChannels = get_top_channels();

    // Generate HTML
    draw_common(htmlentities($_SESSION['username']), ['show_channels.css', 'general_aside.css'], [], $defaultFilter, $defaultFilter);
    draw_channels_list(htmlentities_all($channels));
    draw_general_aside(htmlentities_all($topChannels), display_messages());
    draw_footer();
?>