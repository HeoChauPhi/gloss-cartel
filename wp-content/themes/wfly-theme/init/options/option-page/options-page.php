<?php
function be_sample_metaboxes( $meta_boxes ) {
  $prefix = '_cmb_'; // Prefix for all fields
  $meta_boxes['page_option'] = array(
    'id' => 'page_option',
    'title' => 'Page Options',
    'pages' => array('page'), // post type
    'context' => 'normal',
    'priority' => 'high',
    'show_names' => true, // Show field names on the left
    'fields' => array(
      array(
        'name' => 'Disable title',
        'desc' => 'Check this disable this page title',
        'id' => $prefix . 'title',
        'type'    => 'checkbox',
        'options' => array(
          'hide'       => __( 'Hide this page title', 'cmb' ),
        ),
      ),

      array(
        'name' => 'Layout page option',
        'desc' => 'Check to set this page layout',
        'id' => $prefix . 'layout_page',
        'type'    => 'radio',
        'options' => array(
          'full'       => __( 'Page full layout', 'cmb' ),
          'container'  => __( 'Page container layout', 'cmb' ),
        ),
        'default' => 'container'
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'be_sample_metaboxes' );

function framework_page($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb_' . $name, true );
  return $value;
}
?>
