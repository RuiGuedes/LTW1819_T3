<?php
  include_once('../includes/database.php');

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
        $stmt = $db->prepare('INSERT INTO Story VALUES(?, ?, ?, ?, ?, ?, ?');
        $stmt->execute(array($storyTitle, $storyContent, 0, $storyAuthor, 0, $storyTime, $channelName));
    }

?>