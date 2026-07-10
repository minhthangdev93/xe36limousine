<?php
/**
 * Archive: Post card.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$permalink = get_permalink();
$title     = get_the_title();
$excerpt   = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content( null, false ) ), 28, '…' );
$date      = get_the_date();
$cats      = get_the_category();
$thumb     = get_the_post_thumbnail_url( get_the_ID(), 'large' );
?>
<li <?php post_class( 'archive-card' ); ?>>
	<a class="archive-card__media" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( $thumb ) : ?>
			<img src="<?php echo esc_url( $thumb ); ?>" alt="" loading="lazy" decoding="async" />
		<?php else : ?>
			<span class="archive-card__placeholder" aria-hidden="true"></span>
		<?php endif; ?>
	</a>

	<div class="archive-card__body">
		<?php if ( ! empty( $cats ) ) : ?>
			<p class="archive-card__cats">
				<?php echo esc_html( $cats[0]->name ); ?>
			</p>
		<?php endif; ?>

		<h2 class="archive-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
		</h2>

		<?php if ( $excerpt ) : ?>
			<p class="archive-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
		<?php endif; ?>

		<div class="archive-card__footer">
			<time class="archive-card__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( $date ); ?></time>
			<a class="archive-card__more" href="<?php echo esc_url( $permalink ); ?>">Đọc tiếp</a>
		</div>
	</div>
</li>
