<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// // ** Database settings - You can get this info from your web host ** //
// /** The name of the database for WordPress */
// define( 'DB_NAME', 'u897223014_85C9E' );

// /** Database username */
// define( 'DB_USER', 'u897223014_0YLMG' );

// /** Database password */
// define( 'DB_PASSWORD', 'dH&NF/I|#8' );

// /** Database hostname */
// define( 'DB_HOST', 'localhost' );

// /** Database charset to use in creating database tables. */
// define( 'DB_CHARSET', 'utf8mb4' );

// /** The database collate type. Don't change this if in doubt. */
// define( 'DB_COLLATE', '' );

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'prashant_karulkar' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'QzRm2RX{?HSwvsNwbKMNJ`Fp9qg-ozBeraJn%y1gt!({{ -#bJ:&V3w4#f2%U 68' );
define( 'SECURE_AUTH_KEY',  '!Dr1+i`;wGtraRP}zk9tO?88CF>}|14-/[`x GXiYjx}u:AL4]%-_(459~Pw}G!g' );
define( 'LOGGED_IN_KEY',    'X(=lY/~^~mY)ibuTML.snB?{*7,.K5m~~9S~!t7seE8F&#z:b.jT2*R-q+xQSs?u' );
define( 'NONCE_KEY',        '%5afRauObl<xtVZ]J/|K2G45z%+h;F)6fn|vg4P.2P*o>@o%0J}ro<t0Y+8Yo1eP' );
define( 'AUTH_SALT',        'V.`1vcw|/5xi/yXQft]La8?4QuE!}IJBoNWPOki6)l!ns!^Eu=la3MLy~B-,z2do' );
define( 'SECURE_AUTH_SALT', 'MP@cn]5-sn:LY3,&*|yd62894PRtj|M#@:aUV7rN~r9K:?ZehGVWB|7kiTk&pyUE' );
define( 'LOGGED_IN_SALT',   'V5G`Wrl-2;;}_8V:[3(0O$iCJ?]IEhL@H9fcx%b>t23JlvZR6HJo=gzzO?l&ohrS' );
define( 'NONCE_SALT',       '77}$L=.MRXt1g YeSth9V#RP!4F;{i9IpZs&Lj#$9fVXN%y-xRXam%u@=M>_m(c]' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
