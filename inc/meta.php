<?php
/**
 * Custom fields from inc/config.php: registered for REST and edited in a native meta box.
 * If ACF is active and a field group exists for the post type, ACF can be used instead
 * (field JSON is saved to /acf-json); the meta keys stay the same.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

/** Sanitizer per field type. */
function starter_sanitize_field( $value, $type ) {
	switch ( $type ) {
		case 'url':
			return esc_url_raw( $value );
		case 'email':
			return sanitize_email( $value );
		case 'number':
		case 'image':
			return '' === $value ? '' : absint( $value );
		case 'textarea':
			return sanitize_textarea_field( $value );
		default:
			return sanitize_text_field( $value );
	}
}

add_action(
	'init',
	function () {
		foreach ( starter_config() as $type => $c ) {
			foreach ( $c['fields'] ?? array() as $key => $f ) {
				$ftype = $f['type'] ?? 'text';
				register_post_meta(
					$type,
					$key,
					array(
						'type'              => in_array( $ftype, array( 'number', 'image' ), true ) ? 'integer' : 'string',
						'single'            => true,
						'show_in_rest'      => true,
						'sanitize_callback' => function ( $v ) use ( $ftype ) {
							return starter_sanitize_field( $v, $ftype );
						},
						'auth_callback'     => function () {
							return current_user_can( 'edit_posts' );
						},
					)
				);
			}
		}
	}
);

add_action(
	'add_meta_boxes',
	function () {
		foreach ( starter_config() as $type => $c ) {
			if ( empty( $c['fields'] ) ) {
				continue;
			}
			add_meta_box( 'starter_fields', __( 'Details', 'starter' ), 'starter_render_meta_box', $type, 'normal', 'high', array( 'fields' => $c['fields'] ) );
		}
	}
);

/** Meta box markup. */
function starter_render_meta_box( $post, $box ) {
	wp_nonce_field( 'starter_save_fields', 'starter_fields_nonce' );
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $box['args']['fields'] as $key => $f ) {
		$type  = $f['type'] ?? 'text';
		$value = get_post_meta( $post->ID, $key, true );
		$id    = 'starter_' . $key;
		echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $f['label'] ) . '</label></th><td>';
		if ( 'textarea' === $type ) {
			echo '<textarea class="large-text" rows="4" id="' . esc_attr( $id ) . '" name="starter_fields[' . esc_attr( $key ) . ']">' . esc_textarea( $value ) . '</textarea>';
		} elseif ( 'select' === $type ) {
			echo '<select id="' . esc_attr( $id ) . '" name="starter_fields[' . esc_attr( $key ) . ']">';
			foreach ( $f['options'] ?? array() as $ov => $ol ) {
				echo '<option value="' . esc_attr( $ov ) . '"' . selected( $value, $ov, false ) . '>' . esc_html( $ol ) . '</option>';
			}
			echo '</select>';
		} else {
			$input = array( 'url' => 'url', 'email' => 'email', 'number' => 'number', 'image' => 'number' )[ $type ] ?? 'text';
			echo '<input class="regular-text" type="' . esc_attr( $input ) . '" id="' . esc_attr( $id ) . '" name="starter_fields[' . esc_attr( $key ) . ']" value="' . esc_attr( $value ) . '">';
			if ( 'image' === $type ) {
				echo '<p class="description">' . esc_html__( 'Attachment ID from the Media Library.', 'starter' ) . '</p>';
			}
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

add_action(
	'save_post',
	function ( $post_id, $post ) {
		if ( ! isset( $_POST['starter_fields_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['starter_fields_nonce'] ) ), 'starter_save_fields' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$fields = starter_config()[ $post->post_type ]['fields'] ?? array();
		$input  = isset( $_POST['starter_fields'] ) ? (array) wp_unslash( $_POST['starter_fields'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized per field below.
		foreach ( $fields as $key => $f ) {
			if ( array_key_exists( $key, $input ) ) {
				update_post_meta( $post_id, $key, starter_sanitize_field( $input[ $key ], $f['type'] ?? 'text' ) );
			}
		}
	},
	10,
	2
);

/** Save ACF field groups as JSON inside the theme (version-controlled). */
add_filter(
	'acf/settings/save_json',
	function () {
		return STARTER_DIR . '/acf-json';
	}
);
add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = STARTER_DIR . '/acf-json';
		return $paths;
	}
);
