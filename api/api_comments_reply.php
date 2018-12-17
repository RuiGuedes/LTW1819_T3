<?php 
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');
    include_once('../database/db_comment.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        generate_error('Session expired, please login!');
        die(header('Location: ../pages/login.php'));
    }

    // Legitimates request
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        generate_error('Request does not appear to be legitimate!');
        die(header('Location: ../actions/action_logout.php'));
    }

    // Needed variables to insert new comment
    $commentContent = htmlentities($_POST['commentContent']);
    $commentAuthor = $_SESSION['username'];
    $commentTime = date('Y-m-d H:i:s');
    $storyID = $_POST['storyID'];
    $parentID = isset($_POST['parentID']) ? $_POST['parentID'] : NULL;

    // Check if story exists and add it's comment to the database
    if (check_story_existence($storyID)) {
        insert_new_comment($commentContent, $commentAuthor, $commentTime, $storyID, $parentID);
        $commentVotes = get_story_comments($storyID) + 1;
        update_story_comments($storyID, $commentVotes);
    }
    else {
        die(header('Location: ../pages/feed.php')); 
    }
    
    // Sends request response
    $comment = get_comment_info($commentContent, $commentAuthor, $commentTime, $storyID, $parentID);
    
    // Convert time format
    foreach($comment as $k => $v) {
        if($k === 'commentTime') {
            $comment[$k] = data_converter($v);
        }
    }

    echo json_encode($comment);
?>