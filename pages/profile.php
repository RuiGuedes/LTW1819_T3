<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_profile.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    $biography = get_user_biography($_SESSION['username']);

    $myChannels = get_user_subscriptions($_SESSION['username']);
  
    $filter = isset($_POST['filter']) ? $_POST['filter'] : 2;
    $userStories = get_user_stories($_SESSION['username'], $filter);

    // Stories number of votes
    $storiesVotes;
    foreach($userStories as $story) {
      $votes = get_story_votes($story['storyID'])['storyPoints'];
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
    }
    
    draw_common($_SESSION['username'], ['stories.css', 'profile_aside.css'], [], $filter);
    draw_profile($_SESSION['username'], htmlentities($biography), $myChannels, $userStories, $storiesVotes);
    draw_footer();
?>