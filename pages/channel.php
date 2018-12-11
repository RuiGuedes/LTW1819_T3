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
    $channel = htmlentities_all(get_channel($channelName));

    // Checks filter value in order to order results from the next query
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 2;

    // Retrieves channel stories order by the value presente on filter variable
    $channelStories = htmlentities_all(get_channel_stories($channelName, $filter));

    // Stories number of votes
    $storiesVotes; $votedStories;
    foreach($channelStories as $story) {
      $votes = get_story_votes($story['storyID']);
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
      $votedStories[$story['storyID']] = get_user_vote($_SESSION['username'], $story['storyID']);
    }

    // Number of followers relative to the present channel
    $channelFollowers = count(get_channel_followers($channelName));
<<<<<<< HEAD
    
    // Retrieve channel Owner
    $channelOwner = get_channel_owner($channelName);
    
    //die();
=======
>>>>>>> a03649fae769239ff8eab1cc907bcceef667389b

    // Checks user subscription to a certain channel
    $status = check_user_subscription($_SESSION['username'], $channelName);

    draw_common($_SESSION['username'], ['stories.css', 'channel_aside.css'], [], $filter);
    draw_channel_feed($channelStories, $storiesVotes, $votedStories);
    draw_channel_aside($channel, $channelStories, $channelFollowers, $channelOwner, $status);
    draw_footer();
?>