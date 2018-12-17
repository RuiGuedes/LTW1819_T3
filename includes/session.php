<?php
  $defaultCookieParams = session_get_cookie_params();
  session_set_cookie_params($defaultCookieParams['lifetime'], $defaultCookieParams['path'], $defaultCookieParams['domain'], true, true);

  session_start();
  session_regenerate_id(true);

  if(!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }

  // Dynamic feedback messages API
  function generate_message($type, $description) {
    $_SESSION['messages'][] = array('type' => $type, 'content' => $description);
  }

  function generate_error($description) {
    generate_message('error', $description);
  }

  function generate_success($description) {
    generate_message('success', $description);
  }

  function display_messages() {
    if (isset($_SESSION['messages'])) {
      $msgString = "<section id=\"messages\">";
      foreach ($_SESSION['messages'] as $message) {
        $msgString .= "<div class=\"" . $message['type'] . "\">" . $message['content'] . "</div>";
      }
      unset($_SESSION['messages']);
      return $msgString . "</section>"; 
    }
    else return '';
  }
?>

<?php function generate_random_token() {
  return bin2hex(openssl_random_pseudo_bytes(32));
} ?>