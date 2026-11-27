<?php
/**
 * Theme supports, menus and image sizes.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'starter', STARTER_DIR . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-width' => true, 'flex-height' => true ) );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/main.css' );

		register_nav_menus(
			array(
				'primary' => __( 'Primary menu', 'starter' ),
				'footer'  => __( 'Footer menu', 'starter' ),
			)
		);

		add_image_size( 'starter-card', 800, 560, true );
		add_image_size( 'starter-hero', 1920, 1200, true );
	}
);

/** Remove emoji scripts for a lighter front end. */
add_action(
	'init',
	function () {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}
);
