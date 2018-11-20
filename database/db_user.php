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
?>