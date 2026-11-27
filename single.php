<?php
/**
 * Single post and single CPT entry. Custom fields from config.php are listed under the content.
 * For a CPT-specific layout, add single-{post_type}.php.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	$starter_fields = starter_config()[ get_post_type() ]['fields'] ?? array();
	?>
	<article <?php post_class( 'section page' ); ?>>
		<div class="container">
			<header class="section__head">
				<h1><?php the_title(); ?></h1>
				<?php if ( 'post' === get_post_type() ) : ?>
					<p class="muted"><?php echo esc_html( get_the_date() ); ?></p>
				<?php endif; ?>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'starter-hero', array( 'class' => 'single__img' ) ); ?>
			<?php endif; ?>
			<div class="prose"><?php the_content(); ?></div>

			<?php if ( $starter_fields ) : ?>
				<dl class="details">
					<?php foreach ( $starter_fields as $starter_key => $starter_f ) : ?>
						<?php
						$starter_val = starter_field( $starter_key );
						if ( '' === $starter_val || 'image' === ( $starter_f['type'] ?? '' ) ) {
							continue;
						}
						?>
						<dt><?php echo esc_html( $starter_f['label'] ); ?></dt>
						<dd>
							<?php if ( 'url' === ( $starter_f['type'] ?? '' ) ) : ?>
								<a class="btn btn--small" href="<?php echo esc_url( $starter_val ); ?>"><?php esc_html_e( 'Open', 'starter' ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $starter_val ); ?>
							<?php endif; ?>
						</dd>
					<?php endforeach; ?>
				</dl>
			<?php endif; ?>
		</div>
	</article>
	<?php
endwhile;

starter_section( 'cta' );
get_footer();
