<?php
/**
 * Passenger: Intro (left) + pricing image (right).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$intro_title = xe36_get_passenger_field( 'pax_intro_title' );
$intro_text  = xe36_get_passenger_field( 'pax_intro_text' );
$intro_image = xe36_passenger_image_url( xe36_get_passenger_field( 'pax_intro_image' ) );
$price_title = xe36_get_passenger_field( 'pax_pricing_title' );
$price_image = xe36_passenger_image_url( xe36_get_passenger_field( 'pax_pricing_image' ) );
$cta_text    = xe36_get_passenger_field( 'pax_cta_btn_text' );
$cta_url     = xe36_get_passenger_field( 'pax_cta_btn_url' );

if ( ! $intro_text && ! $price_image ) {
	return;
}

$paragraphs = preg_split( '/\r\n\r\n|\n\n/', (string) $intro_text );

$hotline_raw     = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_display = xe36_get_site_field( 'hotline_display', '1900 888 999' );
if ( ! is_string( $hotline_display ) || '' === trim( $hotline_display ) || '1900 xxxx' === trim( $hotline_display ) ) {
	$hotline_display = '1900 888 999';
}
$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';

$zalo_url = xe36_get_site_field( 'zalo_url', 'https://zalo.me/1jc92dlvfodg4' );
if ( ! is_string( $zalo_url ) || '' === trim( $zalo_url ) ) {
	$zalo_url = 'https://zalo.me/1jc92dlvfodg4';
}

if ( ! is_string( $cta_text ) || '' === trim( $cta_text ) ) {
	$cta_text = 'Đặt vé ngay';
}
if ( ! is_string( $cta_url ) || '' === trim( $cta_url ) ) {
	$cta_url = home_url( '/#home-booking' );
}
?>
<section class="pax-section pax-pricing" id="pax-pricing">
	<div class="pax-section__inner pax-pricing__inner">
		<div class="pax-pricing__copy" id="pax-intro">
			<header class="pax-pricing__header">
				<p class="pax-section__eyebrow">Giới thiệu</p>
				<?php if ( $intro_title ) : ?>
					<h2 class="pax-section__title pax-pricing__title"><?php echo esc_html( $intro_title ); ?></h2>
				<?php endif; ?>
			</header>

			<?php if ( $intro_text ) : ?>
				<div class="pax-pricing__body">
					<?php foreach ( $paragraphs as $paragraph ) : ?>
						<?php
						$paragraph = trim( $paragraph );
						if ( '' === $paragraph ) {
							continue;
						}
						?>
						<p><?php echo esc_html( $paragraph ); ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $intro_image ) : ?>
				<figure class="pax-pricing__side-media">
					<img
						src="<?php echo esc_url( $intro_image ); ?>"
						alt="<?php echo esc_attr( is_string( $intro_title ) ? $intro_title : 'Xe 36 Limousine' ); ?>"
						loading="lazy"
						decoding="async"
					/>
				</figure>
			<?php endif; ?>

			<div class="pax-pricing__actions">
				<a class="btn pax-pricing__btn pax-pricing__btn--book" href="<?php echo esc_url( $cta_url ); ?>">
					<?php echo esc_html( $cta_text ); ?>
				</a>
				<a class="btn pax-pricing__btn pax-pricing__btn--call" href="<?php echo esc_url( $hotline_tel ); ?>">
					Gọi <?php echo esc_html( $hotline_display ); ?>
				</a>
				<a class="btn pax-pricing__btn pax-pricing__btn--zalo" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer">
					Nhắn Zalo
				</a>
			</div>
		</div>

		<?php if ( $price_image ) : ?>
			<figure class="pax-pricing__media">
				<?php if ( $price_title ) : ?>
					<figcaption class="pax-pricing__caption"><?php echo esc_html( $price_title ); ?></figcaption>
				<?php endif; ?>
				<a href="<?php echo esc_url( $price_image ); ?>" target="_blank" rel="noopener noreferrer">
					<img
						src="<?php echo esc_url( $price_image ); ?>"
						alt="<?php echo esc_attr( is_string( $price_title ) ? $price_title : 'Bảng giá Limousine' ); ?>"
						loading="lazy"
						decoding="async"
					/>
				</a>
			</figure>
		<?php endif; ?>
	</div>
</section>
