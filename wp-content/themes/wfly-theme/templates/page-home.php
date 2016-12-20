<?php
echo 'ok';

//require_once('vendor/autoload.php');

$acuity = new AcuitySchedulingOAuth(array(
  'clientId' => 'uLwNV6dh6WNn6Q1K',
  'clientSecret' => 'caG8oOT8hxk3SmY1i6vlCjCeLVM8zdqHpKQhZcF1',
  'redirectUri' => 'http://localhost/demowp/gloss-cartel/scuity-scheduling/'
));

$acuity->authorizeRedirect(array('scope' => 'api-v1'));
