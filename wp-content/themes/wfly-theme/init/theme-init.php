<?php
// load the theme's framework
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
require_once dirname( __FILE__ ) . '/plugin-install.php';
require_once dirname( __FILE__ ) . '/theme-support.php';

// Timber function value
if ( ! class_exists( 'Timber' ) ) {
  add_action( 'admin_notices', function() {
      echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
  return;
}

// Get custom function template with Timber
Timber::$dirname = array('templates', 'templates/blocks', 'templates/pages', 'templates/layouts', 'templates/views');

// Disable Related post
function related($custom_cat, $showpost = -1) {
  global $post;
  $argss = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'ids');
  $terms = wp_get_post_terms( $post->ID, $custom_cat, $argss );
  $myposts = array(
    'showposts' => $showpost,
    'post_type' => 'any',
    'post__not_in' => array($post->ID),
    'tax_query' => array(
      array(
      'taxonomy' => $custom_cat,
      'field' => 'term_id',
      'terms' => $terms
      )
    )
  );
  $loop_custom = Timber::get_posts($myposts);
  return $loop_custom;
}

// Disable sidebar
function sidebar($name) {
  dynamic_sidebar($name);
  return;
}

// Disable shortcode
function shortcode($name) {
  echo do_shortcode($name);
  return;
}

// Disable ACF plugin function
function acfwidget($name, $widgetid) {
  if (get_field($name, 'widget_'.$widgetid)) {
    $afcfield = get_field($name, 'widget_'.$widgetid);
    if (is_array($afcfield)) {
      return $afcfield;
    } else {
      echo do_shortcode($afcfield);
    }
  }
  return;
}
// --> Get object in ACF. Ex: label, slug...
function acfobject($name, $object) {
  $field = get_field_object($name);
  $field_object = $field[$object];
  if (is_array($field_object)) {
    return $field_object;
  } else {
    echo $field_object;
  }
  return;
}

// Disable term in custom taxonomy
function taxvalue($tax) {
  $args = array(
    'parent' => 0,
    'orderby' => 'slug',
    'hide_empty' => false
  );

  $terms = get_terms( $tax, $args);
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    echo '<ul class="listcat listcat-'.$tax.'">';
    foreach ( $terms as $term ) {
      $subterms1 = get_terms($tax, array('parent' => $term->term_id, 'orderby' => 'slug', 'hide_empty' => false));

      if (sizeof($subterms1) > 0) {
        echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a>';

        // sub term 1
        echo '<ul class="subterm">';
          foreach ($subterms1 as $term) {
            $subterms2 = get_terms($tax, array('parent' => $term->term_id, 'orderby' => 'slug', 'hide_empty' => false));

            if (sizeof($subterms2) > 0) {
              echo '<li class="listcat-item has-subterm"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a>';

              // sub term 2
              echo '<ul class="subterm">';
              foreach ($subterms2 as $term) {
                echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
              }
              echo '</ul></li>';
            } else {
              echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
            }
          }
        echo '</ul></li>';
      } else {
        echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
      }
    }
    echo '</ul>';
  }
}
// --> Disable term format function
function customtax($customtax) {
  ob_start();

  taxvalue($tax = $customtax);

  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
// --> Disable term format shortcode
add_shortcode( 'customtax', 'create_customtax' );
function create_customtax($attrs) {
  extract(shortcode_atts (array(
    'tax_name' => ''
  ), $attrs));
  ob_start();
    taxvalue($tax = $tax_name);
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

// Get term name in custom taxonomy
function get_term_name($slug, $tax){
  $term = get_term_by('slug', $slug, $tax);
  $term_name = array(
    array(
      'name' => $term->name,
      'slug' => $term->slug,
      'link' => esc_url( get_term_link( $term ) ),
    )
  );
  return $term_name;
}

// Get avatar author
function avatar_author($size = '') {
  $avatar = get_avatar( get_the_author_meta( 'ID' ), $size );
  return $avatar;
}

// Flexible content field
function flexible_content($name) {
  $fc_type = array();

  global $post;
  $fc = get_field( $name, $post->ID );
  $fc_ob = get_field_object( $name, $post->ID );

  if ( !empty( $fc ) ) {
    foreach ($fc as $field) {
      $layout = $field['acf_fc_layout'];
      $fc_type[$layout] = array();

      switch ($layout) {
        case 'feature_banners':
          $ob_postid = $field['feature_banner']->ID;
          $posts = Timber::get_posts($ob_postid);
          $field['feature_banner'] = $posts;
          break;
      }

      //print_r($field);
      try {
        Timber::render($layout . '.twig', $field);
      } catch (Exception $e) {
        echo 'Could not find a twig file for layout type: ' . $layout;
      }
    }
  }

  /*if (!empty($fc_ob)) {
    $layout_ob = $fc_ob['layouts'];
    foreach ($layout_ob as $field_ob) {
      //print_r($field_ob);

      $fc_name = $field_ob['name'];
      $fc_type[$field_ob['name']] = $field_ob['sub_fields'];

    }
  }

  foreach ($fc_type as $fc_fields) {
    //print_r($fc_fields);

    foreach ($fc_fields as $fc_field) {
      //echo $fc_field['name'] . '<br>';
      $ob_type = $fc_field['name'];
    }
  }*/

  return;
}

// Add Timber value
add_filter('timber_context', 'wf_twig_data');
function wf_twig_data($data){
  // Theme setting
  $logo = get_template_directory_uri().'/images/logo.png';
  $favicon = get_template_directory_uri().'/images/favicon.ico';

  $data['site_logo'] = new TimberImage($logo);
  $data['site_favicon'] = new TimberImage($favicon);
  $data['menu']['main'] = new TimberMenu('main');
  $data['menu']['footer'] = new TimberMenu('footer');

  $data['flexible_content'] = TimberHelper::function_wrapper( 'flexible_content' );
  $data['related'] = TimberHelper::function_wrapper( 'related' );
  $data['sidebar'] = TimberHelper::function_wrapper( 'sidebar' );
  $data['shortcode'] = TimberHelper::function_wrapper( 'shortcode' );
  $data['acfwidget'] = TimberHelper::function_wrapper( 'acfwidget' );
  $data['acfobject'] = TimberHelper::function_wrapper( 'acfobject' );
  $data['customtax'] = TimberHelper::function_wrapper( 'customtax' );
  $data['get_term_name'] = TimberHelper::function_wrapper( 'get_term_name' );
  $data['avatar_author'] = TimberHelper::function_wrapper( 'avatar_author' );

  return $data;
}
?>
