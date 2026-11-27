<?php
/**
 * Hero section. Data: Customizer → Site options → Hero / CTA.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
$starter_img = (int) starter_opt( 'hero_image' );
?>
<section class="hero">
	<?php
	if ( $starter_img ) {
		echo wp_get_attachment_image( $starter_img, 'starter-hero', false, array( 'class' => 'hero__img', 'fetchpriority' => 'high', 'loading' => 'eager' ) );
	}
	?>
	<div class="container hero__inner">
		<p class="eyebrow" data-reveal><?php echo esc_html( starter_opt( 'hero_eyebrow', 'Eyebrow text' ) ); ?></p>
		<h1 data-reveal><?php echo esc_html( starter_opt( 'hero_title', get_bloginfo( 'name' ) ) ); ?></h1>
		<p class="lead" data-reveal><?php echo esc_html( starter_opt( 'hero_lead', get_bloginfo( 'description' ) ) ); ?></p>
		<div class="row" data-reveal>
			<a class="btn" href="<?php echo esc_url( starter_opt( 'cta_url', '/contact/' ) ); ?>"><?php echo esc_html( starter_opt( 'cta_label', __( 'Get in touch', 'starter' ) ) ); ?></a>
		</div>
	</div>
</section>
