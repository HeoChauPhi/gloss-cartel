<?php
function ascb_post_request($url, $postdata) {
  $content = "";
  // Add post data to request.
  foreach($postdata as $key => $value) {
    $content .= "{$key}={$value}&";
  }
  $params = array('http' => array(
    'method' => 'POST',
    'header' => 'Content-Type: application/x-www-form-urlencoded',
    'content' => $content
  ));
  $ctx = stream_context_create($params);
  $fp = fopen($url, 'rb', false, $ctx);
  if (!$fp) {
    throw new Exception("Connection problem, {$php_errormsg}");
  }
  $response = @stream_get_contents($fp);
  if ($response === false) {
    throw new Exception("Response error, {$php_errormsg}");
  }

  return $response;
}

function asbc_get_apoiment($user_id, $user_key, $url_api) {
  /* $userID = '12648352';
  $key = '7a929774222d17671054d7cc5199f029';*/

  $userID = $user_id;
  $key = $user_key;
  $url = $url_api;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERPWD, "$userID:$key");
  $result = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($result, true);

  return $data;
}

function remove_cookie($name) {
  if( isset($_COOKIE[$name]) ) {
    unset($_COOKIE[$name]);
    if(is_array($_COOKIE[$name])) {
      print_r($_COOKIE[$name]);
      foreach ($_COOKIE[$name] as $key => $value) {
        setcookie($name[$key], null, -1, '/'); // 86400 = 1 day
      }
    } else {
      setcookie($name, null, -1, '/'); // 86400 = 1 day
    }
  }

  return;
}

// Add Timber value
add_filter('timber_context', 'ascb_twig_data');
function ascb_twig_data($data){
  if( isset($_COOKIE['signin']['email']) && !empty($_COOKIE['signin']['email'])) {
    $data['user_login'] = $_COOKIE['signin']['email'];
    $data['block_user'] = 1;
  } else {
    $data['block_user'] = "";
  }

  return $data;
}
