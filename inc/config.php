<?php
/**
 * Single source of truth for custom post types, taxonomies, fields and seed content.
 * Edit this file to add a CPT; registration, meta boxes, REST and seeding follow automatically.
 *
 * Field types: text, textarea, url, email, number, image (attachment ID), select (with 'options').
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

return array(
	'service'     => array(
		'singular'   => 'Service',
		'plural'     => 'Services',
		'slug'       => 'services',
		'icon'       => 'dashicons-hammer',
		'supports'   => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'taxonomies' => array(
			'service_category' => array(
				'singular' => 'Service Category',
				'plural'   => 'Service Categories',
				'slug'     => 'service-category',
			),
		),
		'fields'     => array(
			'price_from' => array( 'label' => 'Price from', 'type' => 'text' ),
			'cta_url'    => array( 'label' => 'Button link', 'type' => 'url' ),
		),
		'seed'       => array(
			array( 'title' => 'Service one', 'excerpt' => 'Short benefit of service one.', 'meta' => array( 'price_from' => 'From $99' ) ),
			array( 'title' => 'Service two', 'excerpt' => 'Short benefit of service two.', 'meta' => array( 'price_from' => 'From $149' ) ),
			array( 'title' => 'Service three', 'excerpt' => 'Short benefit of service three.', 'meta' => array( 'price_from' => 'From $199' ) ),
		),
	),
	'testimonial' => array(
		'singular' => 'Testimonial',
		'plural'   => 'Testimonials',
		'slug'     => 'testimonials',
		'icon'     => 'dashicons-format-quote',
		'public'   => false,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'fields'   => array(
			'role'   => array( 'label' => 'Role / company', 'type' => 'text' ),
			'rating' => array( 'label' => 'Rating', 'type' => 'select', 'options' => array( '5' => '5', '4' => '4', '3' => '3' ) ),
		),
		'seed'     => array(
			array( 'title' => 'Client name', 'content' => 'A short, honest quote placeholder. Replace with a real client quote.', 'meta' => array( 'role' => 'Role, Company', 'rating' => '5' ) ),
		),
	),
);
