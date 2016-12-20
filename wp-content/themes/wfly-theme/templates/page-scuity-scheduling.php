<?php
$acuity = new AcuitySchedulingOAuth(array(
  'clientId' => 'uLwNV6dh6WNn6Q1K',
  'clientSecret' => 'caG8oOT8hxk3SmY1i6vlCjCeLVM8zdqHpKQhZcF1',
  'redirectUri' => 'http://localhost/demowp/gloss-cartel/scuity-scheduling/'
));

$tokenResponse = $acuity->requestAccessToken($_GET['code']);
print_r($tokenResponse);

echo '<br>';

$acuity = new AcuitySchedulingOAuth(array(
  'accessToken' => 'XIIxrsF64Ziq0q1o8WdnESzaOrts6sq1FeU4W9N4'
));

$me = $acuity->request('me');
print_r($me);
