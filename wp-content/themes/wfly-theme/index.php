<?php
/* Since you want a menu object available on every page, I added it to the universal Timber context
via the functions.php file. You could also this in each PHP file if you find that too confusing. */

$context = Timber::get_context();
$context['post'] = Timber::get_posts();
Timber::render('page.twig', $context);
