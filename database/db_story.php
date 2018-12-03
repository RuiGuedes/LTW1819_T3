<?php
  include_once('../includes/database.php');
  include_once('../includes/functions.php');

    /**
    *  Get's story with a certain ID 
    */
    function get_story($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Story WHERE storyID = ?');
        $stmt->execute(array($storyID));
        return $stmt->fetch();
    }

    /**
     * Add's a new story
     */
    function add_new_story($storyTitle, $storyContent, $storyAuthor, $storyTime, $channelName) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO Story (storyTitle, storyContent, storyPoints, storyAuthor, storyComments, storyTime, channelName) VALUES(?, ?, 0, ?, 0, ?, ?)');
        $stmt->execute(array($storyTitle, $storyContent, $storyAuthor, $storyTime, $channelName));
    }

    /**
     * Get's the number of votes of a certain story
     */
    function get_story_votes($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT storyPoints FROM Story WHERE storyID = ?');
        $stmt->execute(array($storyID));
        return $stmt->fetch();
    }

    /**
     * Update the number of votes of a certain story 
     */
    function update_story_votes($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE Story SET storyPoints = (SELECT SUM(voteType) FROM Votes WHERE Votes.storyID = ?) WHERE Story.storyID = ?');
        $stmt->execute(array($storyID, $storyID));
    }

?>