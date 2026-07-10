<?php
/**
 * About: Interior gallery carousel.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title  = xe36_get_about_field( 'about_gallery_title' );
$text   = xe36_get_about_field( 'about_gallery_text' );
$images = xe36_about_parse_images( (string) xe36_get_about_field( 'about_gallery_images' ) );

if ( ! $images ) {
	return;
}

$slide_count = count( $images );
?>
<section class="about-section about-gallery" id="about-gallery">
	<div class="about-section__inner about-gallery__inner">
		<?php if ( $title || $text ) : ?>
			<header class="about-section__header about-gallery__header">
				<?php if ( $title ) : ?>
					<p class="about-section__eyebrow">Nội thất</p>
					<h2 class="about-section__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<p class="about-gallery__text"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<div
			class="about-gallery__carousel"
			data-gallery-carousel
			data-interval="3000"
			aria-roledescription="carousel"
			aria-label="<?php echo esc_attr( is_string( $title ) ? $title : 'Hình ảnh nội thất' ); ?>"
		>
			<div class="about-gallery__viewport" data-gallery-viewport tabindex="0">
				<ul class="about-gallery__track" data-gallery-track>
					<?php foreach ( $images as $index => $url ) : ?>
						<li class="about-gallery__slide" data-gallery-slide>
							<img
								src="<?php echo esc_url( $url ); ?>"
								alt="<?php echo esc_attr( sprintf( 'Nội thất 36 Limousine %d', $index + 1 ) ); ?>"
								loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
								decoding="async"
								draggable="false"
							/>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<?php if ( $slide_count > 1 ) : ?>
				<div class="about-gallery__controls">
					<button type="button" class="about-gallery__nav" data-gallery-prev aria-label="Ảnh trước"><span aria-hidden="true">‹</span></button>
					<div class="about-gallery__dots" role="tablist" aria-label="Chọn ảnh">
						<?php for ( $i = 0; $i < $slide_count; $i++ ) : ?>
							<button
								type="button"
								class="about-gallery__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
								data-gallery-dot="<?php echo esc_attr( (string) $i ); ?>"
								aria-label="<?php echo esc_attr( sprintf( 'Chuyển tới ảnh %d', $i + 1 ) ); ?>"
								aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
							></button>
						<?php endfor; ?>
					</div>
					<button type="button" class="about-gallery__nav" data-gallery-next aria-label="Ảnh sau"><span aria-hidden="true">›</span></button>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
