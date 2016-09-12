<?php
/**
 * Plugin Name: Custom ShortCode
 * Plugin URI: http://heochaua.tk
 * Description: Custom ShortCode Require Timber and ACF Plugin
 * Version: 1.0
 * Author: HeoChauA
 * Author URI: http://heochaua.tk
 * License: GPLv2
 */

/* add_shortcode( 'custom_shortcode', 'create_custom_shortcode' );
function create_custom_shortcode($attrs) {
  extract(shortcode_atts (array(
    'per_page' => -1
  ), $attrs));

  ob_start();
    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
} */

$dir = plugin_dir_path( __FILE__ );

/*function app_output_buffer() {
  ob_start();
}
add_action('init', 'app_output_buffer');*/

function array_fill_keystest($target, $value = '') {
  if(is_array($target)) {
    foreach($target as $key => $val) {
      $filledArray[$val] = is_array($value) ? $value[$key] : $value;
    }
  }
  return $filledArray;
}

// Short code for cat
add_shortcode( 'cs_tax', 'cs_create_get_tax' );
function cs_create_get_tax($attrs) {
  extract(shortcode_atts (array(
    'tax_name' => ''
  ), $attrs));

  ob_start();
    $args = array(
      'parent' => 0,
      'hide_empty' => false
    );

    $context = Timber::get_context();
    $context['categories'] = Timber::get_terms($tax_name, $args);
    Timber::render( array( 'cat-' . $tax_name . '.twig', 'cs-categories.twig'), $context );

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}
