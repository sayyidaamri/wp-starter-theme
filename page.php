<?php
/**
 * Default page template.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'section page' ); ?>>
		<div class="container">
			<header class="section__head"><h1><?php the_title(); ?></h1></header>
			<div class="prose"><?php the_content(); ?></div>
		</div>
	</article>
	<?php
endwhile;

if ( is_page( 'contact' ) ) {
	starter_section( 'cta' );
}
get_footer();
