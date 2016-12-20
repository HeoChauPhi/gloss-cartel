<?php
function app_output_buffer() {
  ob_start();
}
add_action('init', 'app_output_buffer');

// Shortcode Function for form Post code
add_shortcode( 'form_post_code', 'create_form_post_code' );
function create_form_post_code() {
  $title = array();
  $args = array(
    'post_type' => 'postcode',
  );
  $postcode = new WP_Query($args);
  ob_start();
    if($postcode->have_posts()) {
      while ( $postcode->have_posts() ) {
        $postcode->the_post();
        $post_title = get_the_title();
        array_push($title, $post_title);
      }
    }

    $context = Timber::get_context();

    if (isset($_POST['postcodeform'])){
      $post_code = $_POST['postcodeform']['postcode'];

      if (in_array($post_code, $title)){
        //header('Location:'.get_bloginfo('url').'/cf-login');
        wp_redirect(home_url('cf-login'));
      } else {
        //header('Location:'.get_bloginfo('url').'/cf-subscribe');
        wp_redirect(home_url('cf-subscribe'));
      }
      exit();
    }

    Timber::render('templates/form-post-code.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}


// Shortcode Function for form Convert and Check email, post code
add_shortcode( 'form_subscribe', 'create_form_subscribe' );
function create_form_subscribe() {
  $title = array();
  $args = array(
    'post_type' => 'postcode',
    'post_status' => 'any',
  );
  $postcode = new WP_Query($args);
  ob_start();
    if($postcode->have_posts()) {
      while ( $postcode->have_posts() ) {
        $postcode->the_post();
        $post_title = get_the_title();
        array_push($title, $post_title);
      }
    }

    $context = Timber::get_context();

    if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {

      $email =  $_POST['email'];
      // ADD THE FORM INPUT TO $new_post ARRAY
      $email_float = str_replace(array('@', '.', ' '),"",$email);
      $email_convert = hash('adler32', $email_float);

      if (in_array($email_convert, $title)){
        echo 'Email existed';
        wp_redirect('');
      } else if (empty($_POST['email'])) {
        echo 'Email required.';
      } else {

        $new_post = array(
          'post_title'    =>   $email_convert,
          'post_status'   =>   'pending',
          'post_type' =>   'postcode'
        );

        //SAVE THE POST
        $pid = wp_insert_post($new_post);
        update_post_meta($pid, '_cmb_email', $email);

        //REDIRECT TO THE NEW POST ON SAVE
        $link = home_url('cf-thank-you');
        wp_redirect( $link );
        exit();
      }
      do_action('wp_insert_post', 'wp_insert_post');
    }

    Timber::render('templates/form-subscribe.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

// Login form
add_shortcode( 'form_login', 'create_form_login' );
function create_form_login() {
  ob_start();
    if (isset($_POST['login_submit'])) {
      global $user;
      $creds = array();
      $creds['user_login'] = $_POST['login_email'];
      $creds['user_password'] =  $_POST['login_password'];
      $creds['remember'] = true;
      $user = wp_signon( $creds, false );
      if ( is_wp_error($user) ) {
        echo $user->get_error_message();
      }
      if ( !is_wp_error($user) ) {
        wp_redirect(home_url('wp-admin'));
      }
    }

    $context = Timber::get_context();
    //$context['action'] = $_SERVER['REQUEST_URI'];
    $context['action'] = "https://secure.acuityscheduling.com/login.php?loggedout=1&ajax=0&popup=0";
    $context['book_link'] = home_url('cf_book_now');
    Timber::render('templates/form-login.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

// Register form
add_shortcode( 'form_register', 'create_form_register' );
function create_form_register() {
  ob_start();

    $context = Timber::get_context();
    Timber::render('templates/form-register.twig', $context);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}
?>
