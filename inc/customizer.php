<?php
/**
 * Site-wide options in Appearance → Customize → Site options.
 * Read them with starter_opt( 'key', 'fallback' ).
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

/** Option groups: section => [ key => [ label, type, default ] ]. */
function starter_options_schema() {
	return array(
		'Hero'    => array(
			'hero_eyebrow' => array( 'Eyebrow', 'text', 'Eyebrow text' ),
			'hero_title'   => array( 'Headline', 'text', 'A clear headline that says what you do' ),
			'hero_lead'    => array( 'Supporting text', 'textarea', 'Supporting copy in one or two sentences.' ),
			'hero_image'   => array( 'Background image', 'image', '' ),
		),
		'Contact' => array(
			'email'    => array( 'Email', 'email', 'hello@example.com' ),
			'phone'    => array( 'Phone', 'text', '+62 812 0000 0000' ),
			'whatsapp' => array( 'WhatsApp number (digits)', 'text', '6281200000000' ),
			'address'  => array( 'Address', 'textarea', 'Street 1, City' ),
		),
		'CTA'     => array(
			'cta_label' => array( 'Button label', 'text', 'Get in touch' ),
			'cta_url'   => array( 'Button link', 'url', '/contact/' ),
			'cta_title' => array( 'CTA section title', 'text', 'Ready to start?' ),
		),
		'Social'  => array(
			'instagram' => array( 'Instagram URL', 'url', '' ),
			'linkedin'  => array( 'LinkedIn URL', 'url', '' ),
			'facebook'  => array( 'Facebook URL', 'url', '' ),
		),
	);
}

add_action(
	'customize_register',
	function ( WP_Customize_Manager $wp_customize ) {
		$wp_customize->add_panel( 'starter_options', array( 'title' => __( 'Site options', 'starter' ), 'priority' => 30 ) );
		foreach ( starter_options_schema() as $section => $fields ) {
			$sid = 'starter_' . sanitize_key( $section );
			$wp_customize->add_section( $sid, array( 'title' => $section, 'panel' => 'starter_options' ) );
			foreach ( $fields as $key => list( $label, $type, $default ) ) {
				$setting = 'starter_' . $key;
				$wp_customize->add_setting(
					$setting,
					array(
						'default'           => $default,
						'sanitize_callback' => array( 'url' => 'esc_url_raw', 'email' => 'sanitize_email', 'textarea' => 'sanitize_textarea_field', 'image' => 'absint' )[ $type ] ?? 'sanitize_text_field',
						'transport'         => 'refresh',
					)
				);
				if ( 'image' === $type ) {
					$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $setting, array( 'label' => $label, 'section' => $sid, 'mime_type' => 'image' ) ) );
				} else {
					$wp_customize->add_control( $setting, array( 'label' => $label, 'section' => $sid, 'type' => 'textarea' === $type ? 'textarea' : ( 'email' === $type ? 'email' : ( 'url' === $type ? 'url' : 'text' ) ) ) );
				}
			}
		}
	}
);
