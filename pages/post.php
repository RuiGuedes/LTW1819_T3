<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_post.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
      generate_error('Session expired, please login!');
      die(header('Location: ../pages/login.php'));
    }

    // Variables
    $channelName = isset($_GET['channelName']) ? $_GET['channelName'] : '';
    $defaultFilter = 2;

    // Checks channel existence
    if(!check_channel_existence($channelName)) {
      generate_error('Invalid channel ! Try again.');
      die(header('Location: feed.php'));
    }

    // Retrieves channel information
    $channel = get_channel($channelName);

    // Retrieves channel stories order by the default filter value (2)
    $postedStories = count(get_channel_stories($channelName, 2));

    // Number of followers relative to the present channel
    $channelFollowers = count(get_channel_followers($channelName));

    // Retrieve channel Owner
    $channelOwner = get_channel_owner($channelName);

    // Generate HTML
    draw_common(htmlentities($_SESSION['username']), ['post.css', 'channel_aside.css'], [], $defaultFilter, $defaultFilter);
    draw_post(htmlentities($channelName));
    draw_post_aside(htmlentities_all($channel), htmlentities($postedStories), htmlentities($channelFollowers), htmlentities($channelOwner));
    draw_footer();
?>