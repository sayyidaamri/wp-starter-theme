<?php
/**
 * Front page: an ordered list of sections. Reorder, remove or add sections here;
 * each one lives in template-parts/sections/ and reads its data from the Customizer or a CPT.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
get_header();

starter_section( 'hero' );
starter_section(
	'cpt-grid',
	array(
		'post_type' => 'service',
		'eyebrow'   => __( 'What we do', 'starter' ),
		'title'     => __( 'Services', 'starter' ),
		'limit'     => 6,
	)
);
starter_section( 'testimonials' );

// Content written in the editor for the Home page, if any.
while ( have_posts() ) :
	the_post();
	if ( get_the_content() ) :
		?>
		<section class="section"><div class="container prose"><?php the_content(); ?></div></section>
		<?php
	endif;
endwhile;

starter_section( 'cta' );
get_footer();
