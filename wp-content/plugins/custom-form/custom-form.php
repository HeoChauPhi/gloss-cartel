<?php
/**
 * Plugin Name: Custom Form
 * Plugin URI: http://heochaua.tk
 * Description: Custom Form require important Timber plugin
 * Version: 1.0
 * Author: HeoChauA
 * Author URI: http://heochaua.tk
 * License: GPLv2
 */
$dir = plugin_dir_path( __FILE__ );
require_once($dir . 'init/plugin-init.php');
require_once($dir . 'init/shortcodes.php');

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'add_form_page');

/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'remove_form_page');

function create_my_post_types() {
  register_post_type( 'postcode',
    array(
      'labels' => array(
        'name' => __( 'Post Code' ),
        'singular_name' => __( 'Post Code' )
      ),
      'supports' => array(
        'title',
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_my_post_types' );
?>