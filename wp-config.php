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
define('DB_NAME', 'heroku_924db80973fcda1');

/** MySQL database username */
define('DB_USER', 'bb9beed86bf593');

/** MySQL database password */
define('DB_PASSWORD', 'f1dccee7');

/** MySQL hostname */
define('DB_HOST', 'eu-cdbr-west-01.cleardb.com');

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
define('AUTH_KEY',         'Y[HzD89;Sb]C~-HYEm{ -Oz}dis8R|H1Puw?^<L%BjXg8U(Y=RUU=*$NB4#ebJRM');
define('SECURE_AUTH_KEY',  '/TkmV|t#-<peZG}|Pf1P1ZW9mBC+t{a(rq*|n+u6e&TKEaAZsn,;ShG+w5|-ojM[');
define('LOGGED_IN_KEY',    'cmZ+rT3-d1-;QoCB%oZc22 U-pKd=.fT0.>*&XcC(7ns0r{bZyphp5e5-B>z$GSv');
define('NONCE_KEY',        '@Y8M3/-^Lj+)siJZ9OZbUsjHZHe`TY2(<o+K7pqiV^O}``?P|iW:?q*ihx{^bD F');
define('AUTH_SALT',        '4+cChem0iwOZqvYblnl7x]0k]Vgd|V{hA}Jor4y%O#x%mu9(C+Cwg?7<%uq?Gspx');
define('SECURE_AUTH_SALT', '`i7Rb?9Qz6$]}r3>A-0d-`LaO]CqTpzgFDe$>N/9oG(Sxf|R0I+E-b}P!]qM-r<u');
define('LOGGED_IN_SALT',   'H py0m)*hP|]#<}OhTVbQ`XUJ9JdAPf3;OUJ=}2<E7X+vT+rTBBh60au*mopQ)H1');
define('NONCE_SALT',       '.%Mem(j]U~ob@-jDmrv.E#z/ W>~[cGqP,/etlS WjY[}(#.@Nr*ns4F9tVwV/ip');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
