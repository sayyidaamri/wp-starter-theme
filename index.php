<?php
/**
 * Fallback template: blog index, archives and search use this when no specific template exists.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="section page">
	<div class="container">
		<header class="section__head">
			<h1>
				<?php
				if ( is_search() ) {
					/* translators: %s: search query */
					printf( esc_html__( 'Results for “%s”', 'starter' ), esc_html( get_search_query() ) );
				} elseif ( is_archive() ) {
					echo esc_html( wp_strip_all_tags( get_the_archive_title() ) );
				} else {
					single_post_title();
				}
				?>
			</h1>
			<?php the_archive_description( '<div class="lead">', '</div>' ); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/card' );
				endwhile;
				?>
			</div>
			<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
		<?php else : ?>
			<p class="lead"><?php esc_html_e( 'Nothing here yet.', 'starter' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
