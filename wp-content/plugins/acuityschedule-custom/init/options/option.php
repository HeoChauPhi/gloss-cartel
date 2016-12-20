<?php
//require_once dirname(__FILE__) . '/function-options.php';

if ( file_exists(  dirname(__FILE__)  . '/cmb2/init.php' ) ) {
  require_once  dirname(__FILE__)  . '/cmb2/init.php';
} elseif ( file_exists(  dirname(__FILE__)  . '/CMB2/init.php' ) ) {
  require_once  dirname(__FILE__)  . '/CMB2/init.php';
}

//require_once dirname(__FILE__) . '/option-page/options-page.php';
require_once dirname(__FILE__) . '/option-post/options-post.php';
