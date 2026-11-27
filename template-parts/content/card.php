<?php
/**
 * Card for any post in a loop. Shows the first config field as a meta line when present.
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
$starter_fields = array_keys( starter_config()[ get_post_type() ]['fields'] ?? array() );
$starter_meta   = $starter_fields ? starter_field( $starter_fields[0] ) : '';
$starter_public = is_post_type_viewable( get_post_type() );
?>
<article <?php post_class( 'card' ); ?> data-reveal>
	<?php if ( has_post_thumbnail() ) : ?>
		<?php the_post_thumbnail( 'starter-card', array( 'class' => 'card__img', 'loading' => 'lazy' ) ); ?>
	<?php endif; ?>
	<h3 class="card__title">
		<?php if ( $starter_public ) : ?>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<?php else : ?>
			<?php the_title(); ?>
		<?php endif; ?>
	</h3>
	<?php if ( $starter_meta && is_string( $starter_meta ) && ! filter_var( $starter_meta, FILTER_VALIDATE_URL ) ) : ?>
		<p class="card__meta"><?php echo esc_html( $starter_meta ); ?></p>
	<?php endif; ?>
	<?php if ( has_excerpt() ) : ?>
		<p class="muted"><?php echo esc_html( get_the_excerpt() ); ?></p>
	<?php endif; ?>
</article>
