<?php
  include_once('../includes/session.php');
  
  // Destroys current session
  session_destroy();

  header('Location: ../pages/login.php');
?>