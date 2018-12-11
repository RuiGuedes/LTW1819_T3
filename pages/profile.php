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
      die(header('Location: ../actions/action_logout.php'));

    $biography = get_user_biography($username);

    $myChannels = get_user_subscriptions($username);

    $filter = isset($_GET['filter']) ? $_GET['filter'] : 2;
    $userStories = get_user_stories($username, $filter);

    // Stories number of votes
    $storiesVotes; $votedStories;
    foreach($userStories as $story) {
      $votes = get_story_votes($story['storyID']);
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
      $votedStories[$story['storyID']] = get_user_vote($username, $story['storyID']);
    }
    
    draw_common($_SESSION['username'], ['stories.css', 'profile_aside.css'], [], $filter);
    draw_profile($username, htmlentities($biography), display_messages(), htmlentities_all($myChannels), htmlentities_all($userStories), $storiesVotes, $votedStories);
    draw_footer();
?>