<?php
  $defaultCookieParams = session_get_cookie_params();
  session_set_cookie_params($defaultCookieParams['lifetime'], $defaultCookieParams['path'], $defaultCookieParams['domain'], true, true);

  session_start();
  session_regenerate_id(true);
?>