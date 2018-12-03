<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_channel.php');
    include_once('../database/db_story.php');

    // Checks channel existence
    $channelName = isset($_POST['channelName']) ? $_POST['channelName'] : '';

    if(!check_channel_existence($channelName)) 
      die(header('Location: feed.php'));

    // Stores variables to be inserted on database
    $storyTitle = $_POST['title'];
    $storyContent = $_POST['content'];
    $storyAuthor = $_SESSION['username'];
    $storyTime = date('Y-m-d H:i:s');

    // Add's new story 
    add_new_story($storyTitle, $storyContent, $storyAuthor, $storyTime, $channelName);
    
    header('Location: ../pages/channel.php?channelName=' . $channelName);
?>