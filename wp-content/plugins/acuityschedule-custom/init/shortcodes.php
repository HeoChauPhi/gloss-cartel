<?php
// ASCB categories

// add_action( 'wp_ajax_ascbupdatefield', 'ascbAjax_callback' );
// add_action( 'wp_ajax_nopriv_ascbupdatefield', 'ascbAjax_callback' );
function ascbAjax_callback() {
  $values = $_REQUEST;
  $content = $values['apoimentid'];
  $result = json_encode(array('markup' => $content));
  echo $result;
  wp_die();
}

add_shortcode( 'ascb_scheduling', 'ASCB_acuityscheduling' );
function ASCB_acuityscheduling( $atts ) {
  $options = get_option('ascb_board_settings');

  extract( shortcode_atts( array(
    'user_id'       => $options['ascb_user_id'],
    'user_key'      => $options['ascb_user_key'],
    'url_api'       => $options['ascb_url_api'],
    'product_url'   => $options['ascb_product_url']
  ), $atts ) );
  ob_start();
    $ascb_arr = array();

    $data = asbc_get_apoiment($user_id, $user_key, $url_api);
    $product = asbc_get_apoiment($user_id, $user_key, $product_url);

    foreach($data as $key => $item) {
      $ascb_arr[$item['category']][$key] = $item;
    }
    $ascb_arr['Product And Package'] = $product;

    $link_signup = home_url('appointment-scheduling-registor');
    $link_paynow = home_url('appointment-scheduling-client-choose');

    $context = Timber::get_context();
    $context['data'] = $ascb_arr;

    if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'Book Now' ) {
      if( isset($_POST['client_area'], $_POST['client_service'], $_POST['client_date'], $_POST['client_time']) ) {
        $client_area = $_POST['client_area'];
        $client_service = $_POST['client_service'];
        $client_date = $_POST['client_date'];
        $client_time = $_POST['client_time'];
      }

      if( empty($client_area) || empty($client_service) || empty($client_date) || empty($client_time) ) {
        $context['area_message'] = __('Please enter Your Area', 'ascb');
        $context['service_message'] = __('Please choose Service', 'ascb');
        $context['date_message'] = __('Please choose Date', 'ascb');
        $context['time_message'] = __('Please choose Time', 'ascb');
        wp_redirect('');
      } else if( !empty($client_area) || !empty($client_service) || !empty($client_date) || !empty($client_time) ) {
        setcookie("Client", "", -1, '/'); // 86400 = 1 day
        setcookie("Client[Area]", $client_area, time() + 3600, '/'); // 86400 = 1 day
        setcookie("Client[Service]", $client_service, time() + 3600, '/'); // 86400 = 1 day
        setcookie("Client[Date]", $client_date, time() + 3600, '/'); // 86400 = 1 day
        setcookie("Client[Time]", $client_time, time() + 3600, '/'); // 86400 = 1 day

        if(isset($_COOKIE['signin']['email'])) {
          wp_redirect($link_paynow);
        } else {
          wp_redirect($link_signup);
        }
      }
    }

    Timber::render('templates/form-book-feature.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

// Client Choose
add_shortcode( 'ascb_client_choose', 'ASCB_client_choose' );
function ASCB_client_choose( $atts ) {
  $options = get_option('ascb_board_settings');

  extract( shortcode_atts( array(
    'user_id'       => $options['ascb_user_id'],
    'user_key'      => $options['ascb_user_key'],
    'url_api'       => $options['ascb_url_api'],
    'product_url'   => $options['ascb_product_url'],
    'tax_name'      => 'service_product'
  ), $atts ) );

  ob_start();
    $ascb_arr = array();
    $data = asbc_get_apoiment($user_id, $user_key, $url_api);
    $product = asbc_get_apoiment($user_id, $user_key, $product_url);

    foreach ($product as $value) {
      array_push($data, $value);
    }

    if(isset($_COOKIE['Client']['Service'])) {
      foreach ($data as $value) {
        if($value['id'] == $_COOKIE['Client']['Service'] ) {
          $data = $value;
        }
      }
    }

    $link = home_url('appointment-scheduling-confirm');

    $args = array(
      'parent' => 0,
      'hide_empty' => false
    );

    $context = Timber::get_context();
    $context['categories'] = Timber::get_terms($tax_name, $args);
    $context['data'] = $data;

    if( isset($_COOKIE['signin']['email']) && !empty($_COOKIE['signin']['email'])) {
      $context['user_email'] = $_COOKIE['signin']['email'];
    } else {
      $context['user_email'] = "";
    }

    if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'Confirm') {
      if( isset($_POST['confirm_category'], $_POST['confirm_name'], $_POST['confirm_price'], $_POST['confirm_duration'], $_POST['confirm_image']) ) {
        $confirm_catimg   = $_POST['confirm_catimg'];
        $confirm_category   = $_POST['confirm_category'];
        $confirm_name       = $_POST['confirm_name'];
        $confirm_price      = $_POST['confirm_price'];
        $confirm_duration   = $_POST['confirm_duration'];
        $confirm_image      = $_POST['confirm_image'];
      }

      setcookie("confirm", "", -1, '/'); // 86400 = 1 day
      setcookie("confirm[Catimg]", $confirm_catimg, time() + 3600, '/'); // 86400 = 1 day
      setcookie("confirm[Category]", $confirm_category, time() + 3600, '/'); // 86400 = 1 day
      setcookie("confirm[Name]", $confirm_name, time() + 3600, '/'); // 86400 = 1 day
      setcookie("confirm[Price]", $confirm_price, time() + 3600, '/'); // 86400 = 1 day
      setcookie("confirm[Duration]", $confirm_duration, time() + 3600, '/'); // 86400 = 1 day
      setcookie("confirm[Image]", $confirm_image, time() + 3600, '/'); // 86400 = 1 day

      wp_redirect($link);
    }

    if( isset($_COOKIE['signin']['email']) && !empty($_COOKIE['signin']['email'])) {
      $context['user_email'] = $_COOKIE['signin']['email'];
    } else {
      $context['user_email'] = "";
    }

    Timber::render('templates/appointment-scheduling-client-choose.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

// ASCB from Confirm

add_shortcode( 'ascb_confirm', 'ASCB_confirm' );
function ASCB_confirm( $atts ) {
  $options = get_option('ascb_board_settings');

  extract( shortcode_atts( array(
    'user_id'       => $options['ascb_user_id'],
    'user_key'      => $options['ascb_user_key'],
    'url_api'       => $options['ascb_url_api'],
    'product_url'   => $options['ascb_product_url'],
    'tax_name'      => 'service_product'
  ), $atts ) );

  ob_start();
    $link = home_url('appointment-scheduling-success');

    $context = Timber::get_context();

    if( isset($_COOKIE['Client'], $_COOKIE['confirm'], $_COOKIE['signin']) ) {
      // fields show
      $context['cat_img']       = $_COOKIE['confirm']['Catimg'];
      $context['confirm_title'] = $_COOKIE['confirm']['Name'];
      $context['confirm_date']  = $_COOKIE['Client']['Date'];
      $context['confirm_time']  = $_COOKIE['Client']['Time'];
      $context['confirm_price'] = $_COOKIE['confirm']['Price'];

      // Fields Confirm form
      $date = date_create($_COOKIE['Client']['Date']);
      $date_format = date_format($date, 'Y-m-d');

      $context['confirm_id']        = $_COOKIE['Client']['Service'];
      $context['confirm_datetime']  = $date_format . 'T' . $_COOKIE['Client']['Time'];
      if( isset($_COOKIE['signin']['email']) && !empty($_COOKIE['signin']['email']) ){
        $context['confirm_email']     = $_COOKIE['signin']['email'];

        $ascb_user_logged = get_page_by_title( $_COOKIE['signin']['email'], OBJECT, 'ascb_user' );
        $first_name = get_post_meta( $ascb_user_logged->ID, '_cmb2_ascb_first_name', true );
        $last_name = get_post_meta( $ascb_user_logged->ID, '_cmb2_ascb_last_name', true );
      } else {
        $first_name = "";
        $last_name  = "";
      }

      $context['confirm_firstName']  = $first_name;
      $context['confirm_lastName']   = $last_name;
    }

    if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'Confirm') {
      if( isset($_POST['confirm_id'], $_POST['confirm_datetime'], $_POST['confirm_firstName'], $_POST['confirm_lastName'], $_POST['confirm_email'], $_POST['confirm_phone']) ) {
        $confirm_end_id         = $_POST['confirm_id'];
        $confirm_end_datetime   = $_POST['confirm_datetime'];
        $confirm_end_firstName  = $_POST['confirm_firstName'];
        $confirm_end_lastName   = $_POST['confirm_lastName'];
        $confirm_end_email      = $_POST['confirm_email'];
        $confirm_end_phone      = $_POST['confirm_phone'];
      }

      if( empty($confirm_end_phone) ) {
        $context['message_phone'] = __('Phone is Require!', 'ascb');
      } else if( empty($confirm_end_id) || empty($confirm_end_datetime) || empty($confirm_end_firstName) || empty($confirm_end_lastName) || empty($confirm_end_email) ) {
        $context['message_confirm_end'] = __('Please rechoose!', 'ascb');
        wp_redirect('');
      } else {
        $acuity = new AcuityScheduling(array(
          'userId' => $user_id,
          'apiKey' => $user_key
        ));
        // Make the create-appointment request:
        $appointment = $acuity->request('/appointments', array(
          'method' => 'POST',
          'data' => array(
            'appointmentTypeID' => $confirm_end_id,
            'datetime'          => $confirm_end_datetime,
            'firstName'         => $confirm_end_firstName,
            'lastName'          => $confirm_end_lastName,
            'email'             => $confirm_end_email,
            'phone'             => $confirm_end_phone
          )
        ));

        if( $appointment['status_code'] == 400 ) {
          $context['message_confirm_end'] = __($appointment['message'], 'ascb');
        } else {
          wp_redirect($link);
        }
      }
    }

    if( isset($_COOKIE['signin']['email']) && !empty($_COOKIE['signin']['email'])) {
      $context['user_email'] = $_COOKIE['signin']['email'];
    } else {
      $context['user_email'] = "";
    }

    Timber::render('templates/appointment-scheduling-confirm.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

// ASCB from Signin and Signup

add_shortcode( 'ascb_signup', 'ASCB_signup' );
function ASCB_signup( $atts ) {
  $title = array();
  $args = array(
    'post_type' => 'ascb_user',
    'post_status' => 'any',
  );
  $ascb_user = new WP_Query($args);

  extract( shortcode_atts( array(
  ), $atts ) );

  ob_start();
    if( $ascb_user->have_posts() ) {
      while ( $ascb_user->have_posts() ) {
        $ascb_user->the_post();
        $post_title = get_the_title();
        $post_password = ascb_post_meta('ascb_pass');

        $title_float = str_replace(array('@', '.', ' '),"",$post_title);
        $title_convert = hash('adler32', $title_float);
        $title[] = $title_convert;
      }
    }

    $link_paynow = home_url('appointment-scheduling-client-choose');

    $context = Timber::get_context();

    if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'Sign me up') {
      if( isset($_POST['signup_first_name'], $_POST['signup_last_name'], $_POST['signup_email'], $_POST['signup_password'], $_POST['signup_re_password']) ) {
        $signup_first_name  = $_POST['signup_first_name'];
        $signup_last_name   = $_POST['signup_last_name'];
        $signup_email       = $_POST['signup_email'];
        $signup_password    = $_POST['signup_password'];
        $signup_re_password = $_POST['signup_re_password'];
      }

      if( empty($signup_first_name) || empty($signup_last_name) || empty($signup_email) || empty($signup_password) || empty($signup_re_password) ) {
        $context['signup_first_name']   = __('First Name is Require!', 'ascb');
        $context['signup_last_name']    = __('Last Name is Require!', 'ascb');
        $context['signup_email']        = __('Email is Require!', 'ascb');
        $context['signup_password']     = __('Password is Require!', 'ascb');
        $context['signup_re_password']  = __('Password is not correct!', 'ascb');
      } else {
        $email_float = str_replace(array('@', '.', ' '), "", $signup_email);
        $email_convert = hash('adler32', $email_float);

        if( in_array($email_convert, $title) ) {
          $context['message_signup'] = __('Email ' . $signup_email . ' is existed!', 'ascb');
        } elseif( $signup_password != $signup_re_password ) {
          $context['signup_re_password']  = __('Re-Password is not correct!', 'ascb');
        } else {
          setcookie("signin", "", time() - 86400, '/'); // 86400 = 1 day
          setcookie("signin[email]", $signup_email, time() + 86400, '/'); // 86400 = 1 day
          setcookie("signin[emailid]", $email_convert, time() + 86400, '/'); // 86400 = 1 day

          $new_post = array(
            'post_title'    =>   $signup_email,
            'post_status'   =>   'pending',
            'post_type' =>   'ascb_user'
          );

          // SAVE THE POST
          $pid = wp_insert_post($new_post);
          update_post_meta($pid, '_cmb2_ascb_first_name', $signup_first_name);
          update_post_meta($pid, '_cmb2_ascb_last_name', $signup_last_name);
          update_post_meta($pid, '_cmb2_ascb_email', $signup_email);
          update_post_meta($pid, '_cmb2_ascb_pass', $signup_password);

          wp_redirect($link_paynow);
        }
      }
    }

    if( isset($_COOKIE['signin']['email']) && !empty($_COOKIE['signin']['email'])) {
      $context['user_email'] = $_COOKIE['signin']['email'];
    } else {
      $context['user_email'] = "";
    }

    Timber::render('templates/form-signup.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

add_shortcode( 'ascb_signin', 'ASCB_signin' );
function ASCB_signin( $atts ) {
  $title = array();
  $args = array(
    'post_type' => 'ascb_user',
    'post_status' => 'any',
  );
  $ascb_user = new WP_Query($args);

  extract( shortcode_atts( array(
  ), $atts ) );

  ob_start();
    if( $ascb_user->have_posts() ) {
      while ( $ascb_user->have_posts() ) {
        $ascb_user->the_post();
        $post_title = get_the_title();
        $post_password = ascb_post_meta('ascb_pass');

        $title_float = str_replace(array('@', '.', ' '),"",$post_title);
        $title_convert = hash('adler32', $title_float);
        $title[$title_convert] = $post_password;
      }
    }


    $link_paynow = home_url('appointment-scheduling-client-choose');

    $context = Timber::get_context();

    if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'Sign In') {
      if( isset($_POST['signin_email'], $_POST['signin_password']) ) {
        $signin_email     = $_POST['signin_email'];
        $signin_password  = $_POST['signin_password'];
      }

      if ( empty($signin_email) || empty($signin_password) ) {
        $context['message_email'] = __('Email Require', 'ascb');
        $context['message_pass']  = __('Password Require', 'ascb');
      } else {
        $email_float = str_replace(array('@', '.', ' '), "", $signin_email);
        $email_convert = hash('adler32', $email_float);

        if( array_key_exists($email_convert, $title) && $signin_password == $title[$email_convert] ) {
          setcookie("signin", "", time() - 86400, '/'); // 86400 = 1 day
          setcookie("signin[email]", $signin_email, time() + 86400, '/'); // 86400 = 1 day
          setcookie("signin[emailid]", $email_convert, time() + 86400, '/'); // 86400 = 1 day

          wp_redirect($link_paynow);
        } else {
          $context['message_signin'] = __('Email or Password for ' . $signin_email . ' does not exist!', 'ascb');
        }
      }
    }

    if( isset($_COOKIE['signin']['email']) && !empty($_COOKIE['signin']['email'])) {
      $context['user_email'] = $_COOKIE['signin']['email'];
    } else {
      $context['user_email'] = "";
    }

    Timber::render('templates/form-signin.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

// Block User
add_shortcode( 'ascb_block_user', 'ASCB_block_user' );
function ASCB_block_user( $atts ) {
  extract( shortcode_atts( array(
  ), $atts ) );

  ob_start();
    $context = Timber::get_context();

    Timber::render('templates/block-user.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}
