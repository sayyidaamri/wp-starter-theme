<?php
/**
 * Registers custom post types and taxonomies from inc/config.php.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		foreach ( starter_config() as $type => $c ) {
			$public = $c['public'] ?? true;
			register_post_type(
				$type,
				array(
					'labels'        => array(
						'name'          => $c['plural'],
						'singular_name' => $c['singular'],
						/* translators: %s: singular post type name */
						'add_new_item'  => sprintf( __( 'Add %s', 'starter' ), $c['singular'] ),
						/* translators: %s: singular post type name */
						'edit_item'     => sprintf( __( 'Edit %s', 'starter' ), $c['singular'] ),
						'all_items'     => $c['plural'],
					),
					'public'        => $public,
					'show_ui'       => true,
					'show_in_rest'  => true,
					'has_archive'   => $public ? ( $c['slug'] ?? true ) : false,
					'rewrite'       => $public ? array( 'slug' => $c['slug'] ?? $type ) : false,
					'menu_icon'     => $c['icon'] ?? 'dashicons-admin-post',
					'supports'      => $c['supports'] ?? array( 'title', 'editor', 'thumbnail' ),
					'menu_position' => 20,
				)
			);

			foreach ( $c['taxonomies'] ?? array() as $tax => $t ) {
				register_taxonomy(
					$tax,
					$type,
					array(
						'labels'            => array( 'name' => $t['plural'], 'singular_name' => $t['singular'] ),
						'hierarchical'      => $t['hierarchical'] ?? true,
						'show_in_rest'      => true,
						'show_admin_column' => true,
						'rewrite'           => array( 'slug' => $t['slug'] ?? $tax ),
					)
				);
			}
		}
	}
);

/** Flush rewrite rules once after switching to the theme so CPT URLs work immediately. */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );
