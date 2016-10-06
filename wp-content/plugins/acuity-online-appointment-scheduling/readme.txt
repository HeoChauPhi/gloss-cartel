=== Acuity Scheduling ===
Tags: Acuity Scheduling, scheduling, booking, reservation plugin, booking plugin, booking system, booking calendar, appointment, online scheduling
Requires at least: 2.5
Tested up to: 4.6
Stable tag: trunk

Embed online appointment scheduling from Acuity Scheduling directly into your site.

== Description ==

Acuity Scheduling is online appointment scheduling software. This plugin allows users with paid accounts on Acuity Scheduling
(https://AcuityScheduling.com) to embed scheduling directly into their site. Use the [scheduling] short tag on any page
with the options described in the documentation to embed your scheduling site.

== Installation ==

The plugin is simple to install:

1. Download `acuityscheduling.zip`
1. Unzip
1. Upload `acuityscheduling` directory to your `/wp-content/plugins` directory
1. Go to the plugin management page and enable the plugin

For more help on installing a Wordpress plugin see http://codex.wordpress.org/Managing_Plugins

== Documentation ==

This creates the [scheduling] tag to embed Acuity Scheduling into the page. Usage:
[scheduling site="https://mysite.acuityscheduling.com"]

Options:
site: your scheduling site (required)
width: defaults to 100% (optional)
height: defaults to 600px (optional)
border: defaults to 0 (optional)

We recommend adding the tag in text mode instead of visual to prevent other formatting of the URL being
inadvertently added. Support is available at http://AcuityScheduling.com/help.php

== Changelog ==

= 1.1.0 =
* Adding companion Javascript for more seamless embedding into your website with easier scrolling and seamless size adjustment in modern browsers.

= 1.0.1 =
* Updated default width from 775px to 100%

= 1.0.0 =
* Initial release
