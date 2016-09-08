<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/template/pages/archive.twig
 * /mytheme/template/pages/archive-{post-type}.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/archive-{post-type}.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

/*$args = array(
  'post_type' => $post->post_type,
  'posts_per_page' => -1,
);*/

global $paged;
if (!isset($paged) || !$paged){
    $paged = 1;
}

$context = Timber::get_context();
$count = 16;
$context['count'] = $count;
$context['paged'] = $paged;
$taxonomy = new TimberTerm();


$args = array(
  'post_type' => 'any',
  'tax_query' => array(
    array(
      'taxonomy' => $taxonomy->taxonomy,
      'field' => 'slug',
      'terms' => $taxonomy->slug,
    )
  ),
  'posts_per_page' => $count,
  'paged' => $paged
);

$context['title'] = 'Archive';
if ( is_day() ) {
  $context['title'] = 'Archive: '.get_the_date( 'D M Y' );
} else if ( is_month() ) {
  $context['title'] = 'Archive: '.get_the_date( 'M Y' );
} else if ( is_year() ) {
  $context['title'] = 'Archive: '.get_the_date( 'Y' );
} else if ( is_tag() ) {
  $context['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
  $context['title'] = single_cat_title( '', false );
} else if ( is_post_type_archive() ) {
  $context['title'] = post_type_archive_title( '', false );
}

query_posts($args);
$context['term'] = $taxonomy;
$context['pagination'] = Timber::get_pagination();
Timber::render( 'archive.twig', $context );
