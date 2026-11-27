<?php
/**
 * Call-to-action band. Data: Customizer → Site options → CTA.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section cta">
	<div class="container cta__inner" data-reveal>
		<h2><?php echo esc_html( starter_opt( 'cta_title', __( 'Ready to start?', 'starter' ) ) ); ?></h2>
		<div class="row">
			<a class="btn" href="<?php echo esc_url( starter_opt( 'cta_url', '/contact/' ) ); ?>"><?php echo esc_html( starter_opt( 'cta_label', __( 'Get in touch', 'starter' ) ) ); ?></a>
			<?php if ( starter_whatsapp_url() ) : ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( starter_whatsapp_url() ); ?>" target="_blank" rel="noopener">WhatsApp</a>
			<?php endif; ?>
		</div>
	</div>
</section>
