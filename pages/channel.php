<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_channel.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    // Checks channel existence
    $channelName = isset($_GET['channelName']) ? $_GET['channelName'] : '';
    
    if(!check_channel_existence($channelName)) 
      die(header('Location: feed.php'));

    // Retrieves channel information
    $channel = get_channel($channelName);

    // Checks filter value in order to order results from the next query
    $filter = isset($_POST['filter']) ? $_POST['filter'] : 2;

    // Retrieves channel stories order by the value presente on filter variable
    $channelStories = get_channel_stories($channelName, $filter);

    // Stories number of votes
    $storiesVotes;
    foreach($channelStories as $story) {
      $votes = get_story_votes($story['storyID'])['storyPoints'];
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
    }

    // Number of followers relative to the present channel
    $channelFollowers = count(get_channel_followers($channelName));

    // Checks user subscription to a certain channel
    $status = check_user_subscription($_SESSION['username'], $channelName);

    draw_common($_SESSION['username'], ['stories.css', 'channel_aside.css'], [], $filter);
    draw_channel_feed($channelStories, $storiesVotes);
    draw_channel_aside($channel, $channelStories, $channelFollowers, $status);
    draw_footer();
?>