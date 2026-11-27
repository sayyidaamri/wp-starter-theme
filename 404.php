<?php
/**
 * 404 template.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="section page notfound">
	<div class="container">
		<h1>404</h1>
		<p class="lead"><?php esc_html_e( 'This page does not exist.', 'starter' ); ?></p>
		<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back home', 'starter' ); ?></a>
	</div>
</section>
<?php
get_footer();
