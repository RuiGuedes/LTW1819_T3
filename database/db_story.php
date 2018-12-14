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
     *  Checks story existence
     */
    function check_story_existence($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Story WHERE storyID = ?');
        $stmt->execute(array($storyID));
        return $stmt->fetch()? true : false; // Return true if story exists
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
    *  Get's last story ID 
    */
    function get_last_storyID() {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT max(storyID) as storyMaxID FROM Story');
        $stmt->execute();
        return $stmt->fetch()['storyMaxID'];
    }

    /**
     * Get's the number of votes of a certain story
     */
    function get_story_votes($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT storyPoints FROM Story WHERE storyID = ?');
        $stmt->execute(array($storyID));
        return $stmt->fetch()['storyPoints'];
    }

    /**
     * Add vote to a certain story from a specific user
     */
    function add_story_vote($storyID, $username, $voteType) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO StoryVotes VALUES(?, ?, ?)');
        $stmt->execute(array($storyID, $username, $voteType));
    }

    /**
     * Remove vote from a certain story relative to a specific user
     */
    function remove_story_vote($storyID, $username) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('DELETE FROM StoryVotes WHERE storyID = ? AND username = ?');
        $stmt->execute(array($storyID, $username));
    }

    /**
     * Update vote relative to a certain story from a specific user
     */
    function update_story_vote($storyID, $username, $voteType) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE StoryVotes SET voteType = ? WHERE storyID = ? AND username = ?');
        $stmt->execute(array($voteType, $storyID, $username));
    }

    /**
     * Update the number of votes of a certain story 
     */
    function update_story_votes($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE Story SET storyPoints = (SELECT SUM(voteType) FROM StoryVotes WHERE StoryVotes.storyID = ?) WHERE Story.storyID = ?');
        $stmt->execute(array($storyID, $storyID));
    }

    /**
     * Get's the number of comments of a certain story
     */
    function get_story_comments($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT storyComments FROM Story WHERE storyID = ?');
        $stmt->execute(array($storyID));
        return $stmt->fetch()['storyComments'];
    }

    /**
     * Update the number of comments of a certain story 
     */
    function update_story_comments($storyID, $comments) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('UPDATE Story SET storyComments = ? WHERE storyID = ?');
        $stmt->execute(array($comments, $storyID));
    }

    /**
     * Get all stories that matches the searched content
     */
    function get_search_stories($filter, $searchFilter, $content) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Story WHERE ' . search_query_converter($searchFilter) . ' LIKE ? ORDER BY ' . orderBy($filter));
        $stmt->execute(array('%' . $content . '%'));
        return $stmt->fetchAll(); 
    }

?>