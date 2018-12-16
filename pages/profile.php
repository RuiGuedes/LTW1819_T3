<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');
    include_once('../templates/tpl_profile.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
      generate_error('Session expired, please login!');
      die(header('Location: ../pages/login.php'));
    }

    // Variables
    $username = isset($_GET['username']) ? $_GET['username'] : '';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 2;
    $searchFilter = isset($_GET['searchFilter']) ? $_GET['searchFilter'] : 2;

    // Checks user existence
    if(!check_user_existence($username)) {
      generate_error('Invalid user ! Try again.');
      die(header('Location: profile.php?username='. $_SESSION['username']));
    }

    // Retrieves user biography
    $biography = get_user_biography($username);

    // Retrieves user stories in a certain order
    $userStories = isset($_GET['search']) ? get_user_search_stories($username, $filter, $searchFilter, $_GET['search']) : get_user_stories($username, $filter);

    // Stories number of votes
    $storiesVotes = []; $votedStories = [];
    foreach($userStories as $story) {
      $votes = get_story_votes($story['storyID']);
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
      $votedStories[$story['storyID']] = get_user_story_vote($username, $story['storyID']);
    }
    
    // Retrieve user statistics
    $userPoints = get_user_points($username);
    $userNumPosts = get_user_num_posted_stories($username);
    $userNumSubs = get_user_num_subscriptions($username);

    // Generate HTML
    draw_common(htmlentities($_SESSION['username']), ['stories.css', 'profile_aside.css', 'channel_aside.css'], [], htmlentities($filter), htmlentities($searchFilter));
    draw_stories(htmlentities_all($userStories), htmlentities_all($storiesVotes), htmlentities_all($votedStories));
    draw_profile_aside(htmlentities($username), htmlentities($biography), display_messages(), htmlentities($userPoints), htmlentities($userNumPosts), htmlentities($userNumSubs));
    draw_footer();
?>