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

    wp_register_style('custom-css', get_template_directory_uri() . '/css/custom-css.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-css');
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
function wf_create_custom_post_types() {
  register_post_type( 'wf_product',
    array(
      'labels' => array(
        'name' => __( 'Product' ),
        'singular_name' => __( 'Product' )
      ),
      'supports' => array(
        'title'
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  register_post_type( 'wf_package',
    array(
      'labels' => array(
        'name' => __( 'Packages' ),
        'singular_name' => __( 'Packages' )
      ),
      'supports' => array(
        'title'
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  register_post_type( 'slideshow',
    array(
      'labels' => array(
        'name' => __( 'Slideshow' ),
        'singular_name' => __( 'Slideshow' )
      ),
      'supports' => array(
        'title'
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'wf_create_custom_post_types' );

function wf_create_custom_taxonomy() {
  $labels_product = array(
    'name' => 'Service',
    'singular' => 'Service',
    'menu_name' => 'Service'
  );
  $args_product = array(
    'labels'                     => $labels_product,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy('service_product', array('wf_product', 'wf_package'), $args_product);
}
add_action( 'init', 'wf_create_custom_taxonomy', 0 );
