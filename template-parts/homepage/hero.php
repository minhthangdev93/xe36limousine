<?php
/**
 * Homepage section: Hero — brand, route, facts, CTAs over banner image.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$hero_title     = xe36_get_homepage_field( 'hero_title', 'Xe 36 Limousine' );
$hero_subtitle  = xe36_get_homepage_field(
	'hero_subtitle',
	'Tuyến Hà Nội ⇌ TP Thanh Hóa / Sầm Sơn / Hải Tiến'
);
$hero_highlight = xe36_get_homepage_field( 'hero_highlight', 'Đưa đón tận nơi' );
$hero_facts_raw = xe36_get_homepage_field(
	'hero_facts',
	"Chạy cao tốc CT01 Hà Nội - Ninh Bình - Thanh Hóa\nTần suất: 60 phút/chuyến\nTừ 5h sáng đến 20 giờ tối\nThời gian di chuyển: 3 tiếng"
);
$hero_image     = xe36_get_homepage_field( 'hero_image', null );
$cta1_text      = xe36_get_homepage_field( 'hero_cta_text', 'Đặt vé ngay' );
$cta1_url       = xe36_get_homepage_field( 'hero_cta_url', '#home-booking' );
$cta2_text      = xe36_get_homepage_field( 'hero_cta2_text', 'Gọi hotline' );
$cta2_url       = xe36_get_homepage_field( 'hero_cta2_url' );
$cta3_text      = xe36_get_homepage_field( 'hero_cta3_text', 'Nhắn Zalo' );
$cta3_url       = xe36_get_homepage_field( 'hero_cta3_url' );

if ( xe36_acf_value_is_empty( $cta2_url ) ) {
	$hotline  = xe36_get_site_field( 'hotline', '' );
	$cta2_url = $hotline
		? 'tel:' . preg_replace( '/\D+/', '', (string) $hotline )
		: 'tel:19001234';
}

if ( xe36_acf_value_is_empty( $cta3_url ) ) {
	$cta3_url = xe36_get_site_field( 'zalo_url', 'https://zalo.me/1jc92dlvfodg4' );
}

$hero_facts = array();
if ( is_string( $hero_facts_raw ) && '' !== trim( $hero_facts_raw ) ) {
	$lines = preg_split( '/\r\n|\r|\n/', $hero_facts_raw );
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$hero_facts[] = $line;
		}
	}
}

$image_url = '';
$image_alt = $hero_title ? (string) $hero_title : 'Xe 36 Limousine';
$image_w   = 0;
$image_h   = 0;

if ( is_array( $hero_image ) && ! empty( $hero_image['url'] ) ) {
	$image_url = (string) $hero_image['url'];
	$image_alt = ! empty( $hero_image['alt'] ) ? (string) $hero_image['alt'] : $image_alt;
	$image_w   = isset( $hero_image['width'] ) ? (int) $hero_image['width'] : 0;
	$image_h   = isset( $hero_image['height'] ) ? (int) $hero_image['height'] : 0;
} elseif ( is_numeric( $hero_image ) ) {
	$image_url = (string) ( wp_get_attachment_image_url( (int) $hero_image, 'full' ) ?: '' );
	$meta_alt  = get_post_meta( (int) $hero_image, '_wp_attachment_image_alt', true );
	if ( $meta_alt ) {
		$image_alt = (string) $meta_alt;
	}
	$meta = wp_get_attachment_image_src( (int) $hero_image, 'full' );
	if ( is_array( $meta ) ) {
		$image_w = (int) ( $meta[1] ?? 0 );
		$image_h = (int) ( $meta[2] ?? 0 );
	}
} elseif ( is_string( $hero_image ) && '' !== $hero_image ) {
	$image_url = $hero_image;
}

$has_image  = '' !== $image_url;
$hero_class = 'home-section home-hero xe36-surface-dark' . ( $has_image ? ' home-hero--has-image' : ' home-hero--no-image' );
$has_cta    = ( $cta1_text && $cta1_url ) || ( $cta2_text && $cta2_url ) || ( $cta3_text && $cta3_url );
?>
<section class="<?php echo esc_attr( $hero_class ); ?>" id="home-hero" data-section="hero">
	<?php if ( $has_image ) : ?>
		<div class="home-hero__media" aria-hidden="true">
			<img
				class="home-hero__img"
				src="<?php echo esc_url( $image_url ); ?>"
				alt=""
				<?php if ( $image_w > 0 && $image_h > 0 ) : ?>
					width="<?php echo esc_attr( (string) $image_w ); ?>"
					height="<?php echo esc_attr( (string) $image_h ); ?>"
				<?php endif; ?>
				decoding="async"
				fetchpriority="high"
			>
		</div>
	<?php endif; ?>

	<div class="home-hero__overlay" aria-hidden="true"></div>

	<div class="home-section__inner home-hero__inner">
		<div class="home-hero__content">
			<?php if ( $hero_title ) : ?>
				<p class="home-hero__brand"><?php echo esc_html( $hero_title ); ?></p>
			<?php endif; ?>

			<?php if ( $hero_subtitle ) : ?>
				<h1 class="home-hero__title"><?php echo esc_html( $hero_subtitle ); ?></h1>
			<?php endif; ?>

			<?php if ( $hero_highlight ) : ?>
				<p class="home-hero__highlight"><?php echo esc_html( $hero_highlight ); ?></p>
			<?php endif; ?>

			<?php if ( $hero_facts ) : ?>
				<ul class="home-hero__facts">
					<?php foreach ( $hero_facts as $fact ) : ?>
						<li><span class="home-hero__fact-text"><?php echo esc_html( $fact ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( $has_cta ) : ?>
				<div class="home-hero__actions">
					<?php if ( $cta1_text && $cta1_url ) : ?>
						<a class="btn home-hero__btn home-hero__btn--book" href="<?php echo esc_url( $cta1_url ); ?>"><?php echo esc_html( $cta1_text ); ?></a>
					<?php endif; ?>

					<?php if ( $cta2_text && $cta2_url ) : ?>
						<a class="btn home-hero__btn home-hero__btn--call" href="<?php echo esc_url( $cta2_url ); ?>"><?php echo esc_html( $cta2_text ); ?></a>
					<?php endif; ?>

					<?php if ( $cta3_text && $cta3_url ) : ?>
						<a class="btn home-hero__btn home-hero__btn--zalo" href="<?php echo esc_url( $cta3_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $cta3_text ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
