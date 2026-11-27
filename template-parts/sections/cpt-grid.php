<?php
/**
 * Grid of any post type. Args: post_type, eyebrow, title, limit, taxonomy, term.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
$starter_args = wp_parse_args( $args ?? array(), array( 'post_type' => 'post', 'eyebrow' => '', 'title' => '', 'limit' => 6, 'taxonomy' => '', 'term' => '' ) );
$starter_q    = array(
	'post_type'      => $starter_args['post_type'],
	'posts_per_page' => (int) $starter_args['limit'],
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	'no_found_rows'  => true,
);
if ( $starter_args['taxonomy'] && $starter_args['term'] ) {
	$starter_q['tax_query'] = array( array( 'taxonomy' => $starter_args['taxonomy'], 'field' => 'slug', 'terms' => $starter_args['term'] ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
}
$starter_posts = new WP_Query( $starter_q );
if ( ! $starter_posts->have_posts() ) {
	return;
}
?>
<section class="section">
	<div class="container">
		<?php if ( $starter_args['title'] ) : ?>
			<header class="section__head" data-reveal>
				<?php if ( $starter_args['eyebrow'] ) : ?><p class="eyebrow"><?php echo esc_html( $starter_args['eyebrow'] ); ?></p><?php endif; ?>
				<h2><?php echo esc_html( $starter_args['title'] ); ?></h2>
			</header>
		<?php endif; ?>
		<div class="grid grid--3">
			<?php
			while ( $starter_posts->have_posts() ) :
				$starter_posts->the_post();
				get_template_part( 'template-parts/content/card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
