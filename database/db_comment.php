<?php
  include_once('../includes/database.php');
  include_once('../includes/functions.php');

    /**
    *  Get's comment with a certain ID 
    */
    function get_comment($commentID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Comment WHERE commentID = ?');
        $stmt->execute(array($commentID));
        return $stmt->fetch();
    }

    /**
    *  Get's comment with a certain ID 
    */
    function get_comment_info($commentContent, $commentAuthor, $commentTime, $storyID, $parentID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Comment WHERE commentContent = ? AND commentAuthor = ? AND commentTime = ? AND storyID = ? AND parentID = ?');
        $stmt->execute(array($commentContent, $commentAuthor, $commentTime, $storyID, $parentID));
        return $stmt->fetch();
    }

    /**
    * Inserts new comment on database
    */
    function insert_new_comment($commentContent, $commentAuthor, $commentTime, $storyID, $parentID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO Comment (commentContent, commentPoints, commentAuthor, commentTime, storyID, parentID) 
                              VALUES(?, 0, ?, ?, ?, ?)');
        $stmt->execute(array($commentContent, $commentAuthor, $commentTime, $storyID, $parentID));
    }

    /**
    *  Get's all parent comments of a certain story
    */
    function get_parent_comments($storyID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Comment WHERE storyID = ? AND parentID IS NULL');
        $stmt->execute(array($storyID));
        return $stmt->fetchall();
    }

    /**
    *  Get's all child comments of a certain parent comment
    */
    function get_child_comments($parentID) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Comment WHERE parentID = ?');
        $stmt->execute(array($parentID));
        return $stmt->fetchall();
    }


?>