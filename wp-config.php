<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'demowp_gloss-cartel');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'r/z]YU7[CbIKdZTsO@OpMnyR6AB1r&r#J?,d!KZM8K:Nn_=coR~lD?F=i4lA%Y>w');
define('SECURE_AUTH_KEY',  'ggtSMuqUm-^-)zu^jznc.Gw#c1{n- BN|Nhw2>V9L]5}^S*qc*1,3TTt,YQ^dU1|');
define('LOGGED_IN_KEY',    'gHI@]YAQjVpjC!^&NG*NAq/XSExpY#CE^)?,x]G=z6w4/hV2K;C|(f[c8o5A+94b');
define('NONCE_KEY',        ',tsE=}y/[?1FXv(f,0%LIX{U:Q+~OP5.z(%83,N+j~FBVFDlyWrL!R=2b!X L9gL');
define('AUTH_SALT',        '832>iU.*+J%o(,;NTv;op!Uy)&lH#c@u}N}>Q50!_SESBt=8d4?2pL/9*{b/d|)C');
define('SECURE_AUTH_SALT', ' +p&oXaS$sU5{V^C$tfP3JC(6gBn7Rb`gJbyM2y%i_x#5dvi~Tb5wiE1ZMYcEzyr');
define('LOGGED_IN_SALT',   '>BE~9V>>bii.?M=@TMV-,Q,7_/B321PLCo|tzQ17rZ%UU0NYNn0>PH&h)1n^P:gL');
define('NONCE_SALT',       '4.H3!<VIAl7`[)uqxNC6B?/H,]|N<y&v%Q{5;2V1iRC94%oyqMMP#CE|,//Lw*I#');
define("WP_HOME", "http://localhost/demowp/gloss-cartel/");
define("WP_SITEURL", "http://localhost/demowp/gloss-cartel/");

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
