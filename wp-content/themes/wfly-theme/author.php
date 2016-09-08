<?php
/**
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

if(isset($_GET['author_name'])) {
  $curauth = get_userdatabylogin($author_name);
} else {
  $curauth = get_userdata(intval($author));
}

$context = Timber::get_context();
$context['author'] = $curauth;

Timber::render( 'author.twig', $context );
