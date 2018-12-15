<?php
    include_once('../includes/database.php');
    include_once('../includes/functions.php');

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
      $stmt = Database::instance()->db()->prepare('INSERT INTO User VALUES(?, ?, ?, ?, ?)');
      $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT), $email, 0, ""));
    }

    /**
     *  Checks user existence
     */
    function check_user_existence($username) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch()? true : false; // Return true if user exists
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
     * Get's user stories order by parameters set on filter
     */
    function get_user_stories($username, $filter) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Story WHERE storyAuthor = ? ORDER BY ' . orderBy($filter));
      $stmt->execute(array($username));
      return $stmt->fetchAll(); 
    }

    /**
     * Get's user stories order by parameters set on filter
     */
    function get_user_search_stories($username, $filter, $searchFilter, $content) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Story WHERE storyAuthor = ? AND ' . search_query_converter($searchFilter) . ' LIKE ? ORDER BY ' . orderBy($filter));
      $stmt->execute(array($username, '%' . $content . '%'));
      return $stmt->fetchAll(); 
    }

    /**
     * Get's user subscribed channel stories order by parameters set on filter
     */
    function get_user_channel_stories($username, $filter) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Story WHERE Story.channelName IN (
                            SELECT channelName FROM Subscription WHERE username = ?) ORDER BY ' . orderBy($filter));
      $stmt->execute(array($username));
      return $stmt->fetchAll(); 
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
     * Checks whether user is already subscribed or not to a certain channel
     */
    function check_user_subscription($username, $channelName) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Subscription WHERE username = ? AND channelName = ?');
      $stmt->execute(array($username, $channelName));
      return $stmt->fetch() ? true : false; 
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
     * Removes a certain channel from the user subscriptions
     */
    function remove_subscription($username, $channelName) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('DELETE FROM Subscription WHERE username = ? AND channelName = ?');
      $stmt->execute(array($username, $channelName));
    }

    /**
     * Returns the type of vote that a user has given to a story
     */
    function get_user_story_vote($username, $storyID) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT voteType FROM StoryVotes WHERE username = ? AND storyID = ?');
      $stmt->execute(array($username, $storyID));
      return $stmt->fetch()['voteType']; 
    }

    /**
     * Returns the type of vote that a user has given to a comment
     */
    function get_user_comment_vote($username, $commentID) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT voteType FROM CommentVotes WHERE username = ? AND commentID = ?');
      $stmt->execute(array($username, $commentID));
      return $stmt->fetch()['voteType']; 
    }

    /**
     * Returns every story where user has voted
     */
    function get_user_voted_stories($username) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT storyID, voteType FROM StoryVotes WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetchall(); 
    }

    /**
     * Returns user number of points
     */
    function get_user_points($username) {
      $db = Database::instance()->db();

      $stmt = $db->prepare('SELECT sum(storyPoints) as StoryPoints FROM Story WHERE storyAuthor = ?');
      $stmt->execute(array($username));
      $storyPoints = $stmt->fetch()['StoryPoints'];

      $stmt = $db->prepare('SELECT sum(commentPoints) as CommentPoints FROM Comment WHERE commentAuthor = ?');
      $stmt->execute(array($username));
      $commentPoints = $stmt->fetch()['CommentPoints'];

      return $storyPoints + $commentPoints; 
    }

    /**
     * Returns user number of posts
     */
    function get_user_num_posted_stories($username) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT count(*) as Posts FROM Story WHERE storyAuthor = ?');
      $stmt->execute(array($username));
      return $stmt->fetch()['Posts']; 
    }

    /**
     * Returns user number of subscriptions
     */
    function get_user_num_subscriptions($username) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT count(*) as Subs FROM Subscription WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch()['Subs']; 
    }


?>