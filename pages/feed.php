<?php 
    include_once('../includes/session.php');
    include_once('../includes/functions.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');
    include_once('../templates/tpl_general_aside.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    // Variables
    $username = $_SESSION['username'];
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 2;
    $searchFilter = isset($_GET['searchFilter']) ? $_GET['searchFilter'] : 2;

    // Get stories
    $stories = isset($_GET['search']) ? get_search_stories($filter, $searchFilter, $_GET['search']) : get_user_channel_stories($username, $filter);
    
    // Stories number of votes and check user vote type
    $storiesVotes = []; $votedStories = [];
    foreach($stories as $story) {
      $votes = get_story_votes($story['storyID']);
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
      $votedStories[$story['storyID']] = get_user_story_vote($username, $story['storyID']);
    } 
    
    // Retrieves top 10 channels
    $channels = get_top_channels();

    // Generate HTML
    draw_common(htmlentities($username), ['stories.css', 'general_aside.css'], [], htmlentities($filter), htmlentities($searchFilter));
    draw_stories(htmlentities_all($stories), htmlentities_all($storiesVotes), htmlentities_all($votedStories));
    draw_general_aside(htmlentities_all($channels), display_messages());
    draw_footer();
?>