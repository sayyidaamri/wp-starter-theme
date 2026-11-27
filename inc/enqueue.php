<?php
/**
 * Front-end assets. Version strings use file modification time so caches bust on deploy.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_enqueue_scripts',
	function () {
		$css = '/assets/css/main.css';
		$js  = '/assets/js/main.js';

		wp_enqueue_style( 'starter-fonts', 'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;500;600&display=swap', array(), null );
		wp_enqueue_style( 'starter-main', STARTER_URI . $css, array( 'starter-fonts' ), (string) filemtime( STARTER_DIR . $css ) );
		wp_enqueue_script( 'starter-main', STARTER_URI . $js, array(), (string) filemtime( STARTER_DIR . $js ), array( 'strategy' => 'defer', 'in_footer' => true ) );
	}
);

/** Preconnect for Google Fonts. */
add_filter(
	'wp_resource_hints',
	function ( $urls, $relation ) {
		if ( 'preconnect' === $relation ) {
			$urls[] = 'https://fonts.googleapis.com';
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		}
		return $urls;
	},
	10,
	2
);
