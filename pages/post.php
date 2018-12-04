<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_post.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    // Checks channel existence
    $channelName = isset($_GET['channelName']) ? $_GET['channelName'] : '';

    if(!check_channel_existence($channelName)) 
      die(header('Location: feed.php'));

    // Retrieves channel information
    $channel = get_channel($channelName);

    // Retrieves channel stories order by the default filter value (2)
    $channelStories = get_channel_stories($channelName, 2);

    // Number of followers relative to the present channel
    $channelFollowers = count(get_channel_followers($channelName));

    draw_common($_SESSION['username'], ['post.css', 'channel_aside.css'], []);
    draw_post($channelName);
    draw_post_aside($channel, $channelStories, $channelFollowers);
    draw_footer();
?>