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
define( 'DB_NAME', 'pabs-db-dt' );

/** MySQL database username */
define( 'DB_USER', 'pabs-db-dt' );

/** MySQL database password */
define( 'DB_PASSWORD', '*dj$)7L/!BXU' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '7Ox_RKpGXJgE;A{eqz7S*[4h~;^``!?L`)Nm>,V u^e-o]D/ $9#}I|CyyAEud~b' );
define( 'SECURE_AUTH_KEY',  '0)u5lXny^uIhKDM7mTXDW+usqriQz$0nrBFy}ad[<)PBMG; V(A0t%Z|Fj)2hY9}' );
define( 'LOGGED_IN_KEY',    'Buda)IXD+Xf6m4=*,<^cf*IZlBlMmtwh=eT7kX[f?Fx0dq#~mAOFz/hjd9YP(9zf' );
define( 'NONCE_KEY',        'i[>]2oRdkwZFa6eeZ}ADR%I~kVi.f;7g5q9RZfBAD|G~>l:F:;eB@Vj6FKj]z yc' );
define( 'AUTH_SALT',        'HW*%>CXl.G]/vkIMSt@n5WfHj2(yu3E`;Eoe}*qE.4C::hti7 JbFxBtdcT()2UE' );
define( 'SECURE_AUTH_SALT', 'ys:1[zaZ*SoMrtnwd$q^&%5gc@nj)^,t23*mT>$pf(=V4x,9+g^*ayxm4*U,w/6o' );
define( 'LOGGED_IN_SALT',   'Ai?Cn5DIlRcVg,D wtR&VWH4g#R$L?@3,5Bl7u+O6Q!;U/1;wBH/<G%(Z<eCw`fc' );
define( 'NONCE_SALT',       'jMSIWUx|~r(KE!*#;^dP-^-/wI*CZZ$5](SJZ%^ O&KJ`O;)<r7Ee*uch3LxS*O@' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_dt';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
