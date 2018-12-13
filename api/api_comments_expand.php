<?php 
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');
    include_once('../database/db_comment.php');
    include_once('../includes/functions.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Session expired, please login!');
        die(header('Location: ../pages/login.php'));
    }

    // Needed variables to insert new comment
    $parentID = isset($_POST['parentID']) ? $_POST['parentID'] : die(header('Location: ../pages/feed.php'));
    
    // Sends request response
    $comments = get_child_comments($parentID);

    echo json_encode($comments);
?>