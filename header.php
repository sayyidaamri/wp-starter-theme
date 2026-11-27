<?php
/**
 * Site header.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'starter' ); ?></a>

<header class="header" data-header>
	<div class="container header__inner">
		<a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
			if ( has_custom_logo() ) {
				echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'alt' => get_bloginfo( 'name' ) ) );
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>
		<button class="header__toggle" type="button" aria-expanded="false" aria-controls="primary-nav" data-nav-toggle><?php esc_html_e( 'Menu', 'starter' ); ?></button>
		<nav id="primary-nav" class="header__nav" aria-label="<?php esc_attr_e( 'Main', 'starter' ); ?>" data-nav>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
			<a class="btn btn--small" href="<?php echo esc_url( starter_opt( 'cta_url', '/contact/' ) ); ?>"><?php echo esc_html( starter_opt( 'cta_label', __( 'Get in touch', 'starter' ) ) ); ?></a>
		</nav>
	</div>
</header>

<main id="main">
