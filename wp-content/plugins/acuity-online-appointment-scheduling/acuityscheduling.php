<?php
/*
Plugin Name: Acuity Online Appointment Scheduling
Plugin URI: http://AcuityScheduling.com
Description: Embed <a href="https://acuityscheduling.com">Acuity Online Appointment Scheduling</a> into your site.  The tag to embed is: <code>[scheduling site="https://mysite.acuityscheduling.com"]</code>
Version: 1.1.0
Author: Acuity Scheduling
Author URI: http://AcuityScheduling.com
*/

/**
 * Embed Acuity Scheduling iframe like:
 * <iframe src="https://acuityscheduling.com/schedule.php?owner=1234567890" width="100%" height="600"></iframe>
 */
function embed_acuityscheduling( $atts ) {
	extract( shortcode_atts( array(
		'site' => 'http://AcuityScheduling.com/',
		'width' => '100%',
		'height' => 600,
		'border' => 0
	), $atts ) );

	return "<iframe src=\"$site\" width=\"$width\" height=\"$height\" frameBorder=\"$border\"></iframe><script src=\"https://d3gxy7nm8y4yjr.cloudfront.net/js/embed.js\" type=\"text/javascript\"></script>";
}
add_shortcode( 'scheduling', 'embed_acuityscheduling' );
