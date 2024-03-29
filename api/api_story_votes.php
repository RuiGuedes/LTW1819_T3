<?php 
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_story.php');

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

    // Variables
    $username = $_POST['username'];
    $storyID = $_POST['rootid'];
    $voteType = $_POST['voteType'];

    // Checks if user already voted or not
    $userVote = get_user_story_vote($username, $storyID);

    // Updates user vote
    if($userVote == null) {
        add_story_vote($storyID, $username, $voteType);
    }
    else if($userVote !== $voteType) {
        update_story_vote($storyID, $username, $voteType);
    }
    else {
        remove_story_vote($storyID, $username);
    }

    // Updates story number of votes
    update_story_votes($storyID);
    
    // Sends request response
    $storyVotes = get_story_votes($storyID);
    $storyVotes = $storyVotes == null ? 0 : $storyVotes;
    
    echo json_encode($storyVotes);
?>