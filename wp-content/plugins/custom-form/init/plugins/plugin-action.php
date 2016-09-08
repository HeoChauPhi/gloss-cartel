<?php
function get_page_id($pageSlug) {
  $page = get_page_by_path($pageSlug);
  if ($page) {
    return $page->ID;
  } else {
    return null;
  }
}

// PostCode Page
function add_form_page() {

  global $wpdb;

  $page_postcode_title = 'CF Postcode';
  $page_postcode_name = 'cf-postcode';

  $page_login_title = 'CF Login';
  $page_login_name = 'cf-login';

  $page_subscribe_title = 'CF Subscribe';
  $page_subscribe_name = 'cf-subscribe';

  $page_thanks_title = 'CF Thank You';
  $page_thanks_name = 'cf-thanks';

  // the menu entry...
  delete_option("my_plugin_page_title");
  add_option("my_plugin_page_title", array($page_postcode_title, $page_login_title, $page_subscribe_title, $page_thanks_title), '', 'yes');
  // the slug...
  delete_option("my_plugin_page_name");
  add_option("my_plugin_page_name", array($page_postcode_name, $page_login_name, $page_subscribe_name, $page_thanks_name), '', 'yes');
  // the id...
  delete_option("my_plugin_page_id");
  add_option("my_plugin_page_id", '0', '', 'yes');

  $page_postcode = get_page_by_title( $page_postcode_title );
  $page_login = get_page_by_title( $page_login_title );
  $page_subscribe = get_page_by_title( $page_subscribe_title );
  $page_thanks = get_page_by_title( $page_thanks_title );

  if ( ! $page_postcode ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_postcode_title;
    $_p['post_slug'] = $page_postcode_name;
    $_p['post_content'] = "[form_post_code]";
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_postcode_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_postcode_id = $page_postcode->ID;

    //make sure the page is not trashed...
    $page_postcode->post_status = 'publish';
    $page_postcode_id = wp_update_post( $page_postcode );

  }

  if ( ! $page_login ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_login_title;
    $_p['post_slug'] = $page_login_name;
    $_p['post_content'] = "[form_login]";
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_login_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_login_id = $page_login->ID;

    //make sure the page is not trashed...
    $page_login->post_status = 'publish';
    $page_login_id = wp_update_post( $page_login );

  }

  if ( ! $page_subscribe ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_subscribe_title;
    $_p['post_slug'] = $page_subscribe_name;
    $_p['post_content'] = "[form_subscribe]";
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_subscribe_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_subscribe_id = $page_subscribe->ID;

    //make sure the page is not trashed...
    $page_subscribe->post_status = 'publish';
    $page_subscribe_id = wp_update_post( $page_subscribe );

  }

  if ( ! $page_thanks ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_thanks_title;
    $_p['post_slug'] = $page_thanks_name;
    $_p['post_content'] = "Thank You!";
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_thanks_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_thanks_id = $page_thanks->ID;

    //make sure the page is not trashed...
    $page_thanks->post_status = 'publish';
    $page_thanks_id = wp_update_post( $page_thanks );

  }

  delete_option( 'my_plugin_page_id' );
  add_option( 'my_plugin_page_id', array($page_postcode_id, $page_login_id, $page_subscribe_id, $page_thanks_id) );

}

function remove_form_page() {
  global $wpdb;

  $page_postcode_id = get_page_id('cf-postcode');
  $page_login_id = get_page_id('cf-login');
  $page_subscribe_id = get_page_id('cf-subscribe');
  $page_thanks_id = get_page_id('cf-thank-you');

  wp_delete_post($page_postcode_id);
  wp_delete_post($page_login_id);
  wp_delete_post($page_subscribe_id);
  wp_delete_post($page_thanks_id);
}
?>