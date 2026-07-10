<?php
/**
 * Single: Hero.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$cats = get_the_category();
$cat  = ! empty( $cats ) ? $cats[0] : null;
?>
<section class="single-section single-hero" id="single-hero">
	<div class="single-section__inner single-hero__inner">
		<div class="single-hero__meta">
			<?php if ( $cat ) : ?>
				<a class="single-hero__cat" href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
					<?php echo esc_html( $cat->name ); ?>
				</a>
			<?php endif; ?>
			<time class="single-hero__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
		</div>

		<h1 class="single-hero__title"><?php the_title(); ?></h1>

		<?php if ( has_excerpt() ) : ?>
			<p class="single-hero__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</div>
</section>
