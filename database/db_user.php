<?php
    include_once('../includes/database.php');

    /**
     * Verifies if a certain username, password combination
     * exists in the database. Use the sha1 hashing function.
     */
    function validate_login($username, $password) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM User WHERE username = ? AND password = ?');
      $stmt->execute(array($username, sha1($password)));
      return $stmt->fetch() ? true : false; 
    }

    /**
     * Inserts new user into the database
     */
    function insert_user($email, $username, $password) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('INSERT INTO User VALUES(?, ?, ?, ?)');
      $stmt->execute(array($username, sha1($password), $email, ""));
    }

    /**
     * Adds a new channel to the user subscriptions
     */
    function add_new_subscription($username, $channelName) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('INSERT INTO Subscription VALUES(?, ?)');
      $stmt->execute(array($username, $channelName));
    }

    /**
     * Get's all user subscriptions
     */
    function get_user_subscriptions($username) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Subscription JOIN Channel ON Subscription.channelName = Channel.name WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetchAll();  
    }

    /**
     * Get's user stories order by parameters set on filter
     */
    function get_user_stories($username, $filter) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Story WHERE storyAuthor = ? ORDER BY ' . orderBy($filter));
      $stmt->execute(array($username));
      return $stmt->fetchAll(); 
    }

    /**
     * Convert filter elements to their respective value
     */
    function orderBy($value) {
      switch($value) {
        case 0:
          return 'storyPoints DESC';
        break;
        case 1:
          return 'storyPoints ASC';
        break;
        case 3:
          return 'storyID ASC';
        break;
        default:        
          return 'storyID DESC';
        break;
      }
    }
?>