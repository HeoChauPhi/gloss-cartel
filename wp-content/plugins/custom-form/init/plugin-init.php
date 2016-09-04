<?php
// load the theme's framework
require_once dirname( __FILE__ ) . '/plugins/class-tgm-plugin-activation.php';
require_once dirname( __FILE__ ) . '/plugins/plugin-install.php';
require_once dirname( __FILE__ ) . '/plugins/plugin-action.php';
require_once dirname( __FILE__ ) . '/options/option.php';

// Timber function value
if ( ! class_exists( 'Timber' ) ) {
  return;
}

// Get custom function template with Timber
Timber::$dirname = array('templates');
?>