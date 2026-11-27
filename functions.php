<?php
/**
 * Starter Theme bootstrap.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

define( 'STARTER_VERSION', '1.0.0' );
define( 'STARTER_DIR', get_template_directory() );
define( 'STARTER_URI', get_template_directory_uri() );

foreach ( array( 'helpers', 'setup', 'enqueue', 'post-types', 'meta', 'customizer', 'schema' ) as $starter_file ) {
	require STARTER_DIR . '/inc/' . $starter_file . '.php';
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require STARTER_DIR . '/inc/cli.php';
}
