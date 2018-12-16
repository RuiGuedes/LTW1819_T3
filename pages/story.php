<?php
    include_once('../includes/session.php');
    include_once('../includes/functions.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_story.php');
    include_once('../templates/tpl_general_aside.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');
    include_once('../database/db_comment.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
      generate_error('Session expired, please login!');
      die(header('Location: ../pages/login.php'));
    }

    // Variables
    $defaultFilter = 2;

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
    $votedStory[$storyID] = get_user_story_vote($_SESSION['username'], $storyID);

    // Retrieve main comments
    $comments = get_parent_comments($storyID);
    $commentVotes = []; $votedComments = [];
    foreach($comments as $comment) {
      $votes = get_comment_votes($comment['commentID']);
      $commentVotes[$comment['commentID']] = $votes == null ? 0 : $votes;
      $votedComments[$comment['commentID']] = get_user_comment_vote($_SESSION['username'], $comment['commentID']);
    }

    // Retrieves top 10 channels
    $channels = get_top_channels();

    // Generate HTML
    draw_common(htmlentities($_SESSION['username']), ['story.css', 'stories.css', 'general_aside.css'], [], htmlentities($defaultFilter), htmlentities($defaultFilter));
    draw_story(htmlentities_all($story), htmlentities_all($storyVotes), htmlentities_all($votedStory), htmlentities_all($comments), htmlentities_all($commentVotes), htmlentities_all($votedComments));
    draw_general_aside(htmlentities_all($channels), display_messages());
    draw_footer(); 
?>