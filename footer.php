<?php
/**
 * Site footer.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
$starter_social = array_filter(
	array(
		'Instagram' => starter_opt( 'instagram' ),
		'LinkedIn'  => starter_opt( 'linkedin' ),
		'Facebook'  => starter_opt( 'facebook' ),
	)
);
?>
</main>

<footer class="footer">
	<div class="container footer__grid">
		<div>
			<p class="footer__logo"><?php bloginfo( 'name' ); ?></p>
			<p class="muted"><?php bloginfo( 'description' ); ?></p>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Footer', 'starter' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'menu', 'depth' => 1, 'fallback_cb' => false ) ); ?>
		</nav>
		<div class="footer__contact">
			<?php if ( starter_opt( 'email' ) ) : ?>
				<a href="mailto:<?php echo esc_attr( antispambot( starter_opt( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( starter_opt( 'email' ) ) ); ?></a>
			<?php endif; ?>
			<?php if ( starter_whatsapp_url() ) : ?>
				<a href="<?php echo esc_url( starter_whatsapp_url() ); ?>" target="_blank" rel="noopener">WhatsApp</a>
			<?php endif; ?>
			<?php foreach ( $starter_social as $starter_label => $starter_url ) : ?>
				<a href="<?php echo esc_url( $starter_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $starter_label ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="container footer__base muted">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
