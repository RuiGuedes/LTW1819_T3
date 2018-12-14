<?php
  include_once('../includes/database.php');
  include_once('../includes/functions.php');

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
     * Get a certain channel
     */
    function get_channel($channelName) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Channel WHERE name = ?');
        $stmt->execute(array($channelName));
        return $stmt->fetch();
    }

     /**
     * Get all channels
     */
    function get_all_channels() {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Channel');
        $stmt->execute(array());
        return $stmt->fetchall();
    }

    /**
     *  Add a new channel
     */
    function add_new_channel($channelName, $owner) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO Channel VALUES(?, ?, ?)');
        $stmt->execute(array($channelName, $owner, ""));
    }

    /**
     * Sets a channel's description
     */
    function set_channel_description($channelname, $description) {
        $stmt = Database::instance()->db()->prepare('UPDATE Channel SET description = ? WHERE name == ?');
        $stmt->execute(array($description, $channelname));
      }

    /**
     * Get's all channel stories order by a certain filter
     */
    function get_channel_stories($channelName, $filter) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Story JOIN Channel ON Story.channelName = Channel.name WHERE Story.channelName = ? ORDER BY ' . orderBy($filter));
        $stmt->execute(array($channelName));
        return $stmt->fetchall();
    }

    /**
     * Get a channel owner
     */
     function get_channel_owner($channelName){
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT owner FROM Channel WHERE Channel.name = ?');
      $stmt->execute(array($channelName));
      return $stmt->fetch()['owner']; 
     }

      /**
       * Get's top 10 channels order by followers 
       */
      function get_top_channels() {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT channelName, count(*) as followers FROM Subscription GROUP BY channelName
                        UNION SELECT name, 0 as followers FROM Channel WHERE name NOT IN (SELECT channelName FROM Subscription) GROUP BY name ORDER BY followers DESC LIMIT 10');
        $stmt->execute(array());
        return $stmt->fetchall();
      }

      /**
       *  Get the number of followers of certain channel
       */
      function get_channel_followers($channelName) {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT DISTINCT * FROM Subscription WHERE channelName = ?');
        $stmt->execute(array($channelName));
        return $stmt->fetchall();
      }

?>