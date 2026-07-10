<?php
/**
 * Homepage section: Interior / exterior gallery carousel.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title  = xe36_get_homepage_field( 'gallery_title', 'Nội thất, ngoại thất xe Limousine 11 chỗ' );
$images = xe36_get_homepage_field( 'gallery_images', array() );

if ( ! is_array( $images ) ) {
	$images = array();
}

$slides = array();
foreach ( $images as $image ) {
	if ( ! is_array( $image ) || empty( $image['ID'] ) ) {
		continue;
	}

	$id  = (int) $image['ID'];
	$url = wp_get_attachment_image_url( $id, 'large' );
	if ( ! $url ) {
		continue;
	}

	$slides[] = array(
		'id'      => $id,
		'url'     => $url,
		'alt'     => ! empty( $image['alt'] ) ? (string) $image['alt'] : (string) ( $image['title'] ?? $title ),
		'caption' => ! empty( $image['caption'] ) ? (string) $image['caption'] : '',
	);
}

if ( ! $slides ) {
	return;
}

$slide_count = count( $slides );
?>
<section class="home-section home-gallery" id="home-gallery" data-section="gallery">
	<div class="home-section__inner home-gallery__inner">
		<?php if ( $title ) : ?>
			<header class="home-gallery__header">
				<p class="home-gallery__eyebrow">Hình ảnh xe</p>
				<h2 class="home-gallery__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div
			class="home-gallery__carousel"
			data-gallery-carousel
			data-interval="3000"
			aria-roledescription="carousel"
			aria-label="<?php echo esc_attr( $title ? $title : 'Thư viện ảnh xe' ); ?>"
		>
			<div class="home-gallery__viewport" data-gallery-viewport tabindex="0">
				<ul class="home-gallery__track" data-gallery-track>
					<?php foreach ( $slides as $index => $slide ) : ?>
						<li
							class="home-gallery__slide"
							data-gallery-slide
							aria-label="<?php echo esc_attr( sprintf( 'Ảnh %d / %d', $index + 1, $slide_count ) ); ?>"
						>
							<figure class="home-gallery__figure">
								<?php
								echo wp_get_attachment_image(
									$slide['id'],
									'large',
									false,
									array(
										'class'    => 'home-gallery__img',
										'alt'      => $slide['alt'],
										'loading'  => 0 === $index ? 'eager' : 'lazy',
										'decoding' => 'async',
										'draggable' => 'false',
									)
								);
								?>
								<?php if ( $slide['caption'] ) : ?>
									<figcaption class="home-gallery__caption"><?php echo esc_html( $slide['caption'] ); ?></figcaption>
								<?php endif; ?>
							</figure>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<?php if ( $slide_count > 1 ) : ?>
				<div class="home-gallery__controls">
					<button type="button" class="home-gallery__nav home-gallery__nav--prev" data-gallery-prev aria-label="Ảnh trước">
						<span aria-hidden="true">‹</span>
					</button>
					<div class="home-gallery__dots" data-gallery-dots role="tablist" aria-label="Chọn ảnh">
						<?php for ( $i = 0; $i < $slide_count; $i++ ) : ?>
							<button
								type="button"
								class="home-gallery__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
								data-gallery-dot="<?php echo esc_attr( (string) $i ); ?>"
								aria-label="<?php echo esc_attr( sprintf( 'Chuyển tới ảnh %d', $i + 1 ) ); ?>"
								aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
							></button>
						<?php endfor; ?>
					</div>
					<button type="button" class="home-gallery__nav home-gallery__nav--next" data-gallery-next aria-label="Ảnh sau">
						<span aria-hidden="true">›</span>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
