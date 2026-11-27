<?php
/**
 * Organization JSON-LD on the front page, built from Customizer options.
 * Skipped when an SEO plugin (Yoast, Rank Math) already outputs schema.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_head',
	function () {
		if ( ! is_front_page() || defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
			return;
		}
		$same_as = array_values( array_filter( array( starter_opt( 'instagram' ), starter_opt( 'linkedin' ), starter_opt( 'facebook' ) ) ) );
		$data    = array_filter(
			array(
				'@context'  => 'https://schema.org',
				'@type'     => 'Organization',
				'name'      => get_bloginfo( 'name' ),
				'url'       => home_url( '/' ),
				'email'     => starter_opt( 'email' ),
				'telephone' => starter_opt( 'phone' ),
				'sameAs'    => $same_as,
			)
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES ) . "</script>\n";
	}
);
