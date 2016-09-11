<?php
/*
**
** Enable Function
**
*/

// menu
add_theme_support( 'menus' );
function wf_menu() {
  register_nav_menus(array (
    'main' => 'Main Menu',
    'footer' => 'Footer Menu'
  ));
}
add_action('init', 'wf_menu');

// Theme support custom logo
function wf_setup() {
  add_theme_support( 'custom-logo', array(
    'flex-width' => true,
  ) );
}
add_action( 'after_setup_theme', 'wf_setup' );

// Theme support custom logo
add_theme_support( 'post-thumbnails' );

// Unset URL from comment form
function wf_move_comment_form_below( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'wf_move_comment_form_below' );

// Set per page on each page
add_action( 'pre_get_posts',  'set_posts_per_page'  );
function set_posts_per_page( $query ) {

  global $wp_the_query;

  if ( (!is_admin()) && ( $query === $wp_the_query ) && ( $query->is_archive() ) ) {
    $query->set( 'posts_per_page', 1 );
  }

  return $query;
}


/*
**
** Support Widget Layout
**
*/


/* Add Dynamic Siderbar */
if (function_exists('register_sidebar')) {
  // Define Sidebar
  register_sidebar(array(
    'name' => __('Sidebar one'),
    'description' => __('Description for this widget-area...'),
    'id' => 'sidebar-1',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  // Define Header block
  register_sidebar(array(
    'name' => __('Header'),
    'description' => __('Description for this widget-area...'),
    'id' => 'header-block',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  // Define Footer
  register_sidebar(array(
    'name' => __('Footer block'),
    'description' => __('Description for this widget-area...'),
    'id' => 'footer-block',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

// Theme support get widget ID
function spice_get_widget_id($widget_instance) {
  if ($widget_instance->number=="__i__"){
    echo "<p><strong>Widget ID is</strong>: Pls save the widget first!</p>"   ;
  } else {
    echo "<p><strong>Widget ID is: </strong>" .$widget_instance->id. "</p>";
  }
}
add_action('in_widget_form', 'spice_get_widget_id');

// Sidebar widget arena
add_action( 'widgets_init', 'create_sidebar_Widget' );
function create_sidebar_Widget() {
  register_widget('sidebar_Widget');
}

class sidebar_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'sidebar_widget',
      'description' => __( 'Sidebar widget.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'sidebar_widget', __( 'Sidebar Widget' ), $widget_ops, $control_ops );
  }
  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }
  function form( $instance ) {
    $title      = esc_attr( $instance['title'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

// Header widget arena
add_action( 'widgets_init', 'create_header_Widget' );
function create_header_Widget() {
  register_widget('header_Widget');
}

class header_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'header_widget',
      'description' => __( 'Custom widget.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'header_widget', __( 'Header Widget' ), $widget_ops, $control_ops );
  }
  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }
  function form( $instance ) {
    $title      = esc_attr( $instance['title'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

// Footer widget arena
add_action( 'widgets_init', 'create_footer_Widget' );
function create_footer_Widget() {
  register_widget('footer_Widget');
}

class footer_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'footer_Widget',
      'description' => __( 'Custom widget.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'footer_Widget', __( 'Footer Widget' ), $widget_ops, $control_ops );
  }
  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }
  function form( $instance ) {
    $title      = esc_attr( $instance['title'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

add_filter('acf/settings/save_json', 'wf_acf_json_save_point');
function wf_acf_json_save_point( $path ) {
  $path = get_stylesheet_directory() . '/templates/acf-setting';
  return $path;
}

add_filter('acf/settings/load_json', 'wf_acf_json_load_point');
function wf_acf_json_load_point( $paths ) {
  unset($paths[0]);
  $paths[] = get_stylesheet_directory() . '/templates/acf-setting';
  return $paths;
}

?>
