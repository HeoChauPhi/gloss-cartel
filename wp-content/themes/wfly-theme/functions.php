<?php
/*
 *  Author: Framework | @Framework
 *  URL: wordfly.com | @wordfly
 *  Custom functions, support, custom post types and more.
 */

// Theme setting
require_once('init/theme-init.php');
require_once('init/options/option.php');

//echo $_SERVER['HTTP_HOST']);

// Custom for theme
if(!is_admin()) {
  function wf_conditional_scripts() {
    wp_register_script('lib-matchHeight', get_template_directory_uri() . '/js/libs/jquery.matchHeight-min.js', array('jquery'), '0.7.0');
    wp_enqueue_script('lib-matchHeight');

    wp_register_script('lib-colorbox', get_template_directory_uri() . '/js/libs/jquery.colorbox.js', array('jquery'), '1.6.4');
    wp_enqueue_script('lib-colorbox');

    wp_register_script('lib-slickslider', get_template_directory_uri() . '/js/libs/slick.min.js', array('jquery'), '1.6.0');
    wp_enqueue_script('lib-slickslider');

    wp_register_script('lib-acf', get_template_directory_uri() . '/js/libs/acf.js', array('jquery'), '1.0.0');
    wp_enqueue_script('lib-acf');

    wp_register_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0');
    wp_enqueue_script('script');
  }
  add_action('wp_print_scripts', 'wf_conditional_scripts');

  function wf_styles() {
    wp_register_style('custom-style', get_template_directory_uri() . '/css/styles.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-style');
  }
  add_action('wp_enqueue_scripts', 'wf_styles');
}

function wf_admin_scripts() {
  wp_register_script('lib-moment', get_template_directory_uri() . '/js/admin-libs/moment.js', array('jquery'), '2.13.0');
  wp_enqueue_script('lib-moment');

  wp_register_script('lib-datetimepicker', get_template_directory_uri() . '/js/admin-libs/bootstrap-datetimepicker.min.js', array('jquery'), '4.17.37');
  wp_enqueue_script('lib-datetimepicker');

  wp_register_script('admin-script', get_template_directory_uri() . '/js/admin-script.js', array('jquery'), '1.0.0');
  wp_enqueue_script('admin-script');
}
add_action('admin_init', 'wf_admin_scripts');

function wf_admin_styles() {
  wp_register_style('admin-style', get_template_directory_uri() . '/stylesheet/css/admin.css', array(), '1.0', 'all');
  wp_enqueue_style('admin-style');
}
add_action('admin_init', 'wf_admin_styles');

/* Add custom post type */
/*function create_my_post_types() {
  register_post_type( 'postcode',
    array(
      'labels' => array(
        'name' => __( 'Post Code' ),
        'singular_name' => __( 'Post Code' )
      ),
      'supports' => array(
        'title',
        'editor',
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_my_post_types' );*/
?>
