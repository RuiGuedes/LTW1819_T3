<?php
    include_once('../includes/session.php');
    include_once('../includes/functions.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_story.php');
    include_once('../database/db_story.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
      die(header('Location: login.php'));

    // Retrives a certain story with ID equals to <storyID>
    $storyID = isset($_POST['storyID']) && is_numeric($_POST['storyID']) ? $_POST['storyID'] : 0;
    $story = htmlentities_all(get_story($storyID));

    if (empty($story))
      die(header('Location: feed.php'));
    else {
      draw_common($_SESSION['username'], ['story.css'], []);
      draw_story($story);
      draw_footer(); 
    }
?>