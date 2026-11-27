<?php
/**
 * WP-CLI: `wp starter seed` creates demo pages, the primary menu and seed posts from config.php.
 * Safe to run more than once: existing items with the same title are skipped.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::add_command(
	'starter seed',
	function () {
		$pages = array(
			'Home'    => '',
			'About'   => 'Write about the brand here.',
			'Contact' => 'Contact details are managed in Appearance → Customize → Site options.',
		);
		$ids   = array();
		foreach ( $pages as $title => $content ) {
			$existing = get_posts( array( 'post_type' => 'page', 'title' => $title, 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) );
			$ids[ $title ] = $existing ? $existing[0] : wp_insert_post( array( 'post_type' => 'page', 'post_title' => $title, 'post_content' => $content, 'post_status' => 'publish' ) );
		}
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['Home'] );
		WP_CLI::log( 'Pages ready, Home set as front page.' );

		foreach ( starter_config() as $type => $c ) {
			foreach ( $c['seed'] ?? array() as $item ) {
				if ( get_posts( array( 'post_type' => $type, 'title' => $item['title'], 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
					continue;
				}
				$id = wp_insert_post(
					array(
						'post_type'    => $type,
						'post_title'   => $item['title'],
						'post_excerpt' => $item['excerpt'] ?? '',
						'post_content' => $item['content'] ?? '',
						'post_status'  => 'publish',
					)
				);
				foreach ( $item['meta'] ?? array() as $k => $v ) {
					update_post_meta( $id, $k, $v );
				}
			}
			WP_CLI::log( sprintf( 'Seeded %s.', $c['plural'] ) );
		}

		$menu_name = 'Primary';
		$menu      = wp_get_nav_menu_object( $menu_name );
		$menu_id   = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
		if ( ! $menu ) {
			foreach ( $ids as $page_id ) {
				wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-object-id' => $page_id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
			}
		}
		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
		flush_rewrite_rules();
		WP_CLI::success( 'Demo content ready.' );
	}
);
