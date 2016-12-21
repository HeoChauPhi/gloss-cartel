<?php
/*
Plugin Name: Appointment Scheduling Custom Booking (ASCB)
Plugin URI: http://AcuityScheduling.com
Description:
Version: 1.0.0
Author: Acuity Scheduling
Author URI: http://AcuityScheduling.com
*/

$dir = plugin_dir_path( __FILE__ );
require_once dirname( __FILE__ ) . '/init/acuityschedule/AcuitySchedulingOAuth.php';
include_once('init/ascb.admin.php');
include_once('init/functions.php');
include_once('init/options/option.php');
include_once('init/shortcodes.php');
include_once('init/plugin-init.php');

// Admin settings.
if(is_admin()) {
  $settings = new ASCBSettingsPage();
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'asbc_add_form_page');

/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'asbc_remove_form_page');

// Email Register
function ascb_create_post_types() {
  register_post_type( 'ascb_user',
    array(
      'labels' => array(
        'name' => __( 'Acuity Scheduling User', 'ascb' ),
        'singular_name' => __( 'Acuity Scheduling User', 'ascb' )
      ),
      'supports' => array(
        'title'
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'ascb_create_post_types' );

add_action('init', 'ascb_plugin_scripts');
function ascb_plugin_scripts() {
  wp_register_script('ascb-libs-jqueryui', plugin_dir_url( __FILE__ ) . 'dist/js/libs/jquery-ui.js', array('jquery'), FALSE, '1.12.1', TRUE);
  wp_enqueue_script('ascb-libs-jqueryui'); // Enqueue it!

  wp_register_script('ascb-libs-cookie', plugin_dir_url( __FILE__ ) . 'dist/js/libs/js.cookie.js', array('jquery'), FALSE, '2.1.3', TRUE);
  wp_enqueue_script('ascb-libs-cookie'); // Enqueue it!

  wp_register_script('ascb-script', plugin_dir_url( __FILE__ ) . 'dist/js/scripts.js', array('jquery'), FALSE, '1.0.0', TRUE);
  wp_localize_script( 'ascb-script', 'ascbAjax', array( 'ajaxurl' => admin_url('admin-ajax.php' )));
  wp_enqueue_script('ascb-script'); // Enqueue it!
}

add_action('wp_enqueue_scripts', 'ascb_styles');
function ascb_styles() {
  wp_register_style('jqueryui-css', plugin_dir_url( __FILE__ ). 'dist/css/jquery-ui.css', array(), '1.12.1', 'all');
  wp_enqueue_style('jqueryui-css');
}
