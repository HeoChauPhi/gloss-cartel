<?php
// load the theme's framework

function asbc_get_page_id($pageSlug) {
  $page = get_page_by_path($pageSlug);
  if ($page) {
    return $page->ID;
  } else {
    return null;
  }
}

// PostCode Page
function asbc_add_form_page() {

  global $wpdb;

  $page_asbc_register_title = 'Appointment Scheduling Registor';
  $page_asbc_register_name = 'appointment-scheduling-registor';

  $page_asbc_signin_title = 'Appointment Scheduling Signin';
  $page_asbc_signin_name = 'appointment-scheduling-signin';

  $page_asbc_choose_title = 'Appointment Scheduling Client Choose';
  $page_asbc_choose_name = 'appointment-scheduling-client-choose';

  $page_asbc_confirm_title = 'Appointment Scheduling Confirm';
  $page_asbc_confirm_name = 'appointment-scheduling-confirm';

  $page_asbc_success_title = 'Appointment Scheduling Success';
  $page_asbc_success_name = 'appointment-scheduling-success';

  // the menu entry...
  delete_option("asbc_plugin_page_title");
  add_option("asbc_plugin_page_title", array(
    $page_asbc_register_title,
    $page_asbc_register_name,
    $page_asbc_choose_title,
    $page_asbc_confirm_title,
    $page_asbc_success_title), '', 'yes');
  // the slug...
  delete_option("asbc_plugin_page_name");
  add_option("asbc_plugin_page_name", array(
    $page_asbc_register_name,
    $page_asbc_signin_name,
    $page_asbc_choose_name,
    $page_asbc_confirm_name,
    $page_asbc_success_name), '', 'yes');
  // the id...
  delete_option("asbc_plugin_page_id");
  add_option("asbc_plugin_page_id", '0', '', 'yes');

  $page_asbc_register = get_page_by_title( $page_asbc_register_title );
  $page_asbc_signin   = get_page_by_title( $page_asbc_signin_title );
  $page_asbc_choose   = get_page_by_title( $page_asbc_choose_title );
  $page_asbc_confirm  = get_page_by_title( $page_asbc_confirm_title );
  $page_asbc_success  = get_page_by_title( $page_asbc_success_title );

  // Page Register
  if ( ! $page_asbc_register ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_asbc_register_title;
    $_p['post_slug'] = $page_asbc_register_name;
    $_p['post_content'] = '[ascb_signup]';
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_asbc_register_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_asbc_register_id = $page_asbc_register->ID;

    //make sure the page is not trashed...
    $page_asbc_register->post_status = 'publish';
    $page_asbc_register_id = wp_update_post( $page_asbc_register );

  }

  // Page Signin
  if ( ! $page_asbc_signin ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_asbc_signin_title;
    $_p['post_slug'] = $page_asbc_signin_name;
    $_p['post_content'] = '[ascb_signin]';
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_asbc_signin_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_asbc_signin_id = $page_asbc_signin->ID;

    //make sure the page is not trashed...
    $page_asbc_signin->post_status = 'publish';
    $page_asbc_signin_id = wp_update_post( $page_asbc_signin );

  }

  // Page Client Choose
  if ( ! $page_asbc_choose ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_asbc_choose_title;
    $_p['post_slug'] = $page_asbc_choose_name;
    $_p['post_content'] = '[ascb_client_choose]';
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_asbc_choose_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_asbc_choose_id = $page_asbc_choose->ID;

    //make sure the page is not trashed...
    $page_asbc_choose->post_status = 'publish';
    $page_asbc_choose_id = wp_update_post( $page_asbc_choose );

  }

  // Page Confirm
  if ( ! $page_asbc_confirm ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_asbc_confirm_title;
    $_p['post_slug'] = $page_asbc_confirm_name;
    $_p['post_content'] = '[ascb_confirm]';
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_asbc_confirm_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_asbc_confirm_id = $page_asbc_confirm->ID;

    //make sure the page is not trashed...
    $page_asbc_confirm->post_status = 'publish';
    $page_asbc_confirm_id = wp_update_post( $page_asbc_confirm );

  }

  // Page Success
  if ( ! $page_asbc_success ) {

    // Create post object
    $_p = array();
    $_p['post_title'] = $page_asbc_success_title;
    $_p['post_slug'] = $page_asbc_success_name;
    $_p['post_content'] = '[ascb_success]';
    $_p['post_status'] = 'publish';
    $_p['post_type'] = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status'] = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_asbc_success_id = wp_insert_post( $_p );

  }
  else {
    // the plugin may have been previously active and the page may just be trashed...

    $page_asbc_success_id = $page_asbc_success->ID;

    //make sure the page is not trashed...
    $page_asbc_success->post_status = 'publish';
    $page_asbc_success_id = wp_update_post( $page_asbc_success );

  }

  delete_option( 'asbc_plugin_page_id' );
  add_option( 'asbc_plugin_page_id', array(
    $page_asbc_register_id,
    $page_asbc_signin_id,
    $page_asbc_choose_id,
    $page_asbc_confirm_id,
    $page_asbc_success_id) );

}

function asbc_remove_form_page() {
  global $wpdb;

  $page_asbc_register_id = asbc_get_page_id('appointment-scheduling-registor');
  $page_asbc_signin_id = asbc_get_page_id('appointment-scheduling-signin');
  $page_asbc_choose_id = asbc_get_page_id('appointment-scheduling-client-choose');
  $page_asbc_confirm_id = asbc_get_page_id('appointment-scheduling-confirm');
  $page_asbc_success_id = asbc_get_page_id('appointment-scheduling-success');

  wp_delete_post($page_asbc_register_id);
  wp_delete_post($page_asbc_signin_id);
  wp_delete_post($page_asbc_choose_id);
  wp_delete_post($page_asbc_confirm_id);
  wp_delete_post($page_asbc_success_id);
}
