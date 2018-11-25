<?php
  include_once('../includes/database.php');

    /**
     *  Checks if a certain channel already exists
     */
    function check_channel_existence($channelName) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Channel WHERE name = ?');
        $stmt->execute(array($channelName));
        return $stmt->fetch()? true : false; // Return true if channel exists
    }

    /**
     *  Add a new channel
     */
    function add_new_channel($channelName, $owner) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO Channel VALUES(?, ?, ?, ?)');
        $stmt->execute(array($channelName, $owner, "", "NoImage.png"));
    }

?>