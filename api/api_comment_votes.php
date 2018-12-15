<?php 
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_comment.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username'])) {
        generate_error('Session expired, please login!');
        die(header('Location: ../pages/login.php'));
    }

    // Variables
    $username = $_POST['username'];
    $commentID = $_POST['rootid'];
    $voteType = $_POST['voteType'];
    
    // Checks if user already voted or not
    $userVote = get_user_comment_vote($username, $commentID);

    // Updates user vote
    if($userVote == null) {
        add_comment_vote($commentID, $username, $voteType);
    }
    else if($userVote !== $voteType) {
        update_comment_vote($commentID, $username, $voteType);
    }
    else {
        remove_comment_vote($commentID, $username);
    }

    // Updates comment number of votes
    update_comment_votes($commentID);
    
    // Sends request response
    $commentVotes = get_comment_votes($commentID);
    $commentVotes = $commentVotes == null ? 0 : $commentVotes;
    
    echo json_encode($commentVotes);
?>