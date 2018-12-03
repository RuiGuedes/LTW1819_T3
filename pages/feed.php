<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_feed.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    $filter = isset($_POST['filter']) ? $_POST['filter'] : 2;
    $stories = get_user_channel_stories($_SESSION['username'], $filter);

    // Stories number of votes
    $storiesVotes;
    foreach($stories as $story) {
      $votes = get_story_votes($story['storyID'])['storyPoints'];
      $storiesVotes[$story['storyID']] = $votes == null ? 0 : $votes;
    }

    // Get top 10 channels
    $channels = get_top_channels();

    draw_common($_SESSION['username'], ['stories.css', 'general_aside.css'], [], $filter);
    draw_feed($stories, $storiesVotes);
    draw_general_aside($channels);
    draw_footer();
?>