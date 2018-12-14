<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_profile.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    // Checks user existence
    $username = isset($_GET['username']) ? $_GET['username'] : '';

    if(!check_user_existence($username)) 
      die(header('Location: profile.php?username='. $_SESSION['username']));

    $biography = get_user_biography($username);

    $filter = isset($_GET['filter']) ? $_GET['filter'] : 2;
    $userStories = get_user_stories($username, $filter);

    // Stories number of votes
    $storiesVotes = []; $votedStories = [];
    foreach($userStories as $story) {
      $votes = get_story_votes($story['storyID']);
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
      $votedStories[$story['storyID']] = get_user_story_vote($username, $story['storyID']);
    }
    
    $userPoints = get_user_points($_GET['username']);
    $userNumPosts = get_user_num_posted_stories($_GET['username']);
    $userNumSubs = get_user_num_subscriptions($_GET['username']);

    draw_common($_SESSION['username'], ['stories.css', 'profile_aside.css', 'channel_aside.css'], [], $filter);
    draw_profile(htmlentities_all($userStories), $storiesVotes, $votedStories);
    draw_profile_aside($username, htmlentities($biography), display_messages(), $userPoints, $userNumPosts, $userNumSubs);
    draw_footer();
?>