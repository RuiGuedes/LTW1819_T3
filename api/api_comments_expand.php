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

    // Convert time format
    foreach($comments as $k1 => $v1) {
        foreach($v1 as $k2 => $v2) {
            if($k2 === 'commentTime') {
                $comments[$k1][$k2] = data_converter($v2);
            }
        }
    }

    // Retrieve user comment type
    $votedComments;
    for($index = 0; $index < count($comments); $index++) {
        $votedComments[$comments[$index]['commentID']] = get_user_comment_vote($_SESSION['username'], $comments[$index]['commentID']);
    }

    $encode[0] = $comments;
    $encode[1] = isset($votedComments) ? $votedComments : [] ;

    echo json_encode($encode);
?>