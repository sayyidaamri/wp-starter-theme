<?php
/**
 * Small helpers used across templates.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

/** CPT config (cached). */
function starter_config() {
	static $config = null;
	if ( null === $config ) {
		$config = apply_filters( 'starter_config', require STARTER_DIR . '/inc/config.php' );
	}
	return $config;
}

/** Read a custom field registered in config.php. */
function starter_field( $key, $post_id = null ) {
	return get_post_meta( $post_id ? $post_id : get_the_ID(), $key, true );
}

/** Read a Customizer option with a fallback. */
function starter_opt( $key, $default = '' ) {
	$value = get_theme_mod( 'starter_' . $key, $default );
	return '' === $value ? $default : $value;
}

/** Render a section from template-parts/sections with arguments. */
function starter_section( $name, $args = array() ) {
	get_template_part( 'template-parts/sections/' . $name, null, $args );
}

/** WhatsApp link from the Customizer number. */
function starter_whatsapp_url( $text = '' ) {
	$number = preg_replace( '/\D+/', '', starter_opt( 'whatsapp' ) );
	if ( ! $number ) {
		return '';
	}
	return 'https://wa.me/' . $number . ( $text ? '?text=' . rawurlencode( $text ) : '' );
}
