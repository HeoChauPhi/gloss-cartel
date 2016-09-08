<?php
function customform_metaboxes( $meta_boxes ) {
  $prefix = '_cmb_'; // Prefix for all fields
  $meta_boxes['cf_option'] = array(
    'id' => 'custom_fields',
    'title' => 'Custom Fields',
    'pages' =>  array('postcode'), // post type
    'context' => 'normal',
    'priority' => 'high',
    'show_names' => true, // Show field names on the left
    'fields' => array(
      array(
        'name' => 'Email',
        'desc' => 'Add post code to this email',
        'id' => $prefix . 'email',
        'type'    => 'text_email'
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'customform_metaboxes' );

function cf_option_page($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb_' . $name, true );
  return $value;
}
?>