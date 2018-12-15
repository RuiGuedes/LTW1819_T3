<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');
    include_once('../templates/tpl_channel.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    // Variables
    $channelName = isset($_GET['channelName']) ? $_GET['channelName'] : '';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 2;
    $searchFilter = isset($_GET['searchFilter']) ? $_GET['searchFilter'] : 2;

    // Checks channel existence
    if(!check_channel_existence($channelName)) {
      generate_error('Invalid channel ! Try again.');
      die(header('Location: feed.php'));
    } 

    // Retrieves channel information
    $channel = get_channel($channelName);

    // Retrieves channel stories order by the value presente on filter variable
    $channelStories = isset($_GET['search']) ? get_channel_search_stories($channelName, $filter, $searchFilter, $_GET['search']) : get_channel_stories($channelName, $filter);

    // Stories number of votes and check user vote type
    $storiesVotes = []; $votedStories = [];
    foreach($channelStories as $story) {
      $votes = get_story_votes($story['storyID']);
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
      $votedStories[$story['storyID']] = get_user_story_vote($_SESSION['username'], $story['storyID']);
    }

    // Number of followers relative to the present channel
    $channelFollowers = count(get_channel_followers($channelName));
    
    // Retrieve channel Owner
    $channelOwner = get_channel_owner($channelName);

    // Checks user subscription to a certain channel
    $status = check_user_subscription($_SESSION['username'], $channelName);

    // Generate HTML
    draw_common(htmlentities($_SESSION['username']), ['stories.css', 'channel_aside.css'], [], $filter, $searchFilter);
    draw_stories(htmlentities_all($channelStories), htmlentities_all($storiesVotes), htmlentities_all($votedStories));
    draw_channel_aside(htmlentities_all($channel), htmlentities(count($channelStories)), htmlentities($channelFollowers), htmlentities($channelOwner), htmlentities($status));
    draw_footer();
?>