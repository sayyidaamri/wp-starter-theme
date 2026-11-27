<?php
/**
 * Testimonials from the testimonial CPT.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
$starter_t = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => 6, 'no_found_rows' => true ) );
if ( ! $starter_t->have_posts() ) {
	return;
}
?>
<section class="section section--dark">
	<div class="container">
		<header class="section__head" data-reveal><h2><?php esc_html_e( 'What clients say', 'starter' ); ?></h2></header>
		<div class="grid grid--3">
			<?php
			while ( $starter_t->have_posts() ) :
				$starter_t->the_post();
				?>
				<figure class="quote" data-reveal>
					<blockquote><?php the_content(); ?></blockquote>
					<figcaption><strong><?php the_title(); ?></strong><?php echo starter_field( 'role' ) ? '<br><span class="muted">' . esc_html( starter_field( 'role' ) ) . '</span>' : ''; ?></figcaption>
				</figure>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
