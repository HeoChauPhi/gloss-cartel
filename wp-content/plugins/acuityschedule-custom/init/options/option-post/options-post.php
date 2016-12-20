<?php
add_action( 'cmb2_admin_init', 'ascb_option_metaboxes' );
function ascb_option_metaboxes() {

  $prefix = '_cmb2_';

  $cmb = new_cmb2_box( array(
    'id'            => 'ascb_user_option',
    'title'         => __( 'Acuity Scheduling User Options', 'cmb2' ),
    'object_types'  => array( 'ascb_user', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ) );

  // Field First Name
  $cmb->add_field( array(
    'name' => __('First Name', 'cmb2'),
    'id'   => $prefix . 'ascb_first_name',
    'type' => 'text',
  ) );

  // Field Last Name
  $cmb->add_field( array(
    'name' => __('Last Name', 'cmb2'),
    'id'   => $prefix . 'ascb_last_name',
    'type' => 'text',
  ) );

  // Field Email
  $cmb->add_field( array(
    'name' => __('Email', 'cmb2'),
    'id'   => $prefix . 'ascb_email',
    'type' => 'text',
  ) );

  // Field Password
  $cmb->add_field( array(
    'name' => __('Password', 'cmb2'),
    'id'   => $prefix . 'ascb_pass',
    'type' => 'text',
  ) );
}

function ascb_post_meta($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb2_' . $name, true );
  return $value;
}
