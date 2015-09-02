<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bitnami_wordpress');

/** MySQL database username */
define('DB_USER', 'bn_wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'dcc50d4613');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY', 'a92e7494deae2dc3d158f3557dde33727fc0d02a243b6bdc4b171729563e4c52');
define('SECURE_AUTH_KEY', '6fa905293d816701cdb089a7bff0759d702fb453973dc1fbb05afb5abeba843e');
define('LOGGED_IN_KEY', '28159e6cee19a0175b62bc93d90fc04cdcd7cb94867cdea7f28fb389595042ca');
define('NONCE_KEY', '38c444b7c6af47a2753ce97ee3b82602a70130016a471015a7b68908ce731a83');
define('AUTH_SALT', 'b618704b9f086d709aa0e32cb07bbeb6eb3e4212e3c230801c1f9e6522120c5e');
define('SECURE_AUTH_SALT', '4223330f50407ea411348e980e106fef31ff426fda35caec7e25e88c6f3b9878');
define('LOGGED_IN_SALT', 'ada57d0336afb3fd2bf63ecf41ca7467634ccd81f0ad2f6c09cd51f76fdcc7af');
define('NONCE_SALT', '9f8e96c6cff3b354914b7e51ef1bb7fda627c6ed0b344f960125e17608c8a7d5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
*/

define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/');


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_TEMP_DIR', '/opt/bitnami/apps/wordpress/tmp');


define('FS_METHOD', 'ftpext');
define('FTP_BASE', '/opt/bitnami/apps/wordpress/htdocs/');
define('FTP_USER', 'bitnamiftp');
define('FTP_PASS', '3rS8PEwWr2XACzZ0mx2ZKUf8FEX4F1Rr1w4h2Q1OsMf10Tdqaj');
define('FTP_HOST', '127.0.0.1');
define('FTP_SSL', false);

