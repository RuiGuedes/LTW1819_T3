<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_story.php');


    $storyTitle = $_POST['title'];
    $storyContent = $_POST['content'];
    $storyAuthor = $_SESSION['username'];
    $channelName = $_POST['channelName'];
    $storyTime = getdate();
    
    /* add_new_story($storyTitle, $storyContent, $storyAuthor, $storyTime, $channelName) */ /* Query already made, missing details */
    
    /* header('Location: ../pages/profile.php'); */ /* - Redirect where ??? */
?>