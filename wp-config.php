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
define('WP_HOME','http://company.sandinh.com');
define('WP_SITEURL','http://company.sandinh.com');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sd');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'matkhauSandinh');

/** MySQL hostname */
define('DB_HOST', 'company.sandinh.com');

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
define('AUTH_KEY',         'UShi5l,rfV#i#S(WS=PMv*R6Sl6La;E7~[YfNDsr]S#@tuWi>Bq{m)sb>vtnt=l`');
define('SECURE_AUTH_KEY',  'dSz~H(qPc6Er:&:]tfn#oY`%N-Z6<=V?Fc<?K-]q>%F^-9%K*=H5Ovbx1Or[pFG(');
define('LOGGED_IN_KEY',    '5)/lzBkGe[by<ZAdg-]GMG/ao4.ZlXT5s@](CcUR,gQ5K=OT5&XXMs-h{Do$j=?Y');
define('NONCE_KEY',        'T.r y>`8*p J`wdoyyzp5^/ni1=7qDW7o2:5oZ0*.:?*QVT@+ZURa%OX+h>eq*;c');
define('AUTH_SALT',        'Sqa2[j.IZ:$8tpu)bbE]TvLIcXCzbu&8K]Gfb|dA0$IJJR6>Z[[p4o?KuB~)%BQs');
define('SECURE_AUTH_SALT', 'j8}bp<[dLBMu!A1UcDsE$3g]o8+eAM7aSH7wk-[),UBQu&HAK *51(%h1g#.@p6/');
define('LOGGED_IN_SALT',   'wgx<3y/STB`@be[[F<{M7AUi_w#?]*<ks4@IHa#jS/4Yh$CL=+OsG^ZfXA>ePMBm');
define('NONCE_SALT',       'i]+!cPZ7>!Ku}q4g*^YXzGtlNUXsCV w,|KpMvM9}}e5y93rggmx.dU<NwObM-i ');

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
