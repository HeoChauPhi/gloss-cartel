<?php
add_action( 'init', 'customform_meta_boxes', 9999 );
function customform_meta_boxes() {
  if ( !class_exists( 'cmb_Meta_Box' ) ) {
    require_once( dirname(__FILE__) . '/metabox/init.php' );
  }
}
require_once dirname(__FILE__) . '/option-page/options-page.php';
?>