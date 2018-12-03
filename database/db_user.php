<?php
    include_once('../includes/database.php');

    /**
     * Verifies if a certain username, password combination
     * exists in the database. Use the sha1 hashing function.
     */
    function validate_login($username, $password) {
      $stmt = Database::instance()->db()->prepare('SELECT * FROM User WHERE username = ?');
      $stmt->execute(array($username));
      $user = $stmt->fetch();
      return $user !== false && password_verify($password, $user['password']); 
    }

    /**
     * Inserts new user into the database
     */
    function insert_user($email, $username, $password) {
      $stmt = Database::instance()->db()->prepare('INSERT INTO User VALUES(?, ?, ?, ?)');
      $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]), $email, ""));
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
     * Sets a user's biography
     */
    function set_user_biography($username, $biography) {
      $stmt = Database::instance()->db()->prepare('UPDATE User SET biography = ? WHERE username == ?');
      $stmt->execute(array($biography, $username));
    }

    /**
     * Gets the user biography
     */
    function get_user_biography($username) {
      $stmt = Database::instance()->db()->prepare('SELECT biography FROM User WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch()['biography'];
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

    /**
     * Checks whether user is already subscribed or not to a certain channel
     */
    function check_user_subscription($username, $channelName) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Subscription WHERE username = ? AND channelName = ?');
      $stmt->execute(array($username, $channelName));
      return $stmt->fetch() ? true : false; 
    }

    /**
     * Removes a certain channel from the user subscriptions
     */
    function remove_subscription($username, $channelName) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('DELETE FROM Subscription WHERE username = ? AND channelName = ?');
      $stmt->execute(array($username, $channelName));
    }
?>