<?php
    include_once('../includes/session.php');
    include_once('../includes/functions.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_story.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');
    include_once('../database/db_comment.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    // Retrives a certain story with ID equals to <storyID>
    $storyID = isset($_GET['storyID']) && is_numeric($_GET['storyID']) ? $_GET['storyID'] : 0;
    $story = get_story($storyID);

    // Validate story
    if (empty($story)) {
      generate_error('Story not available !');
      die(header('Location: feed.php'));
    }

    // Stories number of votes and check user vote type
    $votes = get_story_votes($storyID);
    $storyVotes[$storyID] = $votes == null ? 0 : $votes;
    $votedStory[$storyID] = get_user_vote($_SESSION['username'], $storyID);
    
    // Retrieves top 10 channels
    $channels = get_top_channels();

    // Retrieve main comments
    $comments = get_parent_comments($storyID);

    /* echo $comments['commentPoints'];
    die();  */
    draw_common($_SESSION['username'], ['story.css', 'stories.css', 'general_aside.css'], []);
    draw_story(htmlentities_all($story), $storyVotes, $votedStory, $comments);
    draw_general_aside(htmlentities_all($channels), display_messages());
    draw_footer(); 
?>