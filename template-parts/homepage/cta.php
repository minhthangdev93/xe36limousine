<?php
/**
 * Homepage section: Final CTA — book / call / Zalo.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$cta_title   = xe36_get_homepage_field( 'cta_title', 'Đặt xe limousine ngay hôm nay' );
$cta_text    = xe36_get_homepage_field( 'cta_subtitle', 'Tổng đài hỗ trợ 24/7 — phản hồi nhanh qua điện thoại và Zalo' );
$button_text = xe36_get_homepage_field( 'cta_button_text', 'Đặt vé ngay' );
$button_url  = xe36_get_homepage_field( 'cta_button_url', '#home-booking' );
$call_text   = xe36_get_homepage_field( 'cta_call_text', 'Gọi hotline' );
$zalo_text   = xe36_get_homepage_field( 'cta_zalo_text', 'Nhắn Zalo' );

$hotline_raw     = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_display = xe36_get_site_field( 'hotline_display', '' );
if ( ! is_string( $hotline_display ) || '' === trim( $hotline_display ) || '1900 xxxx' === trim( $hotline_display ) ) {
	$hotline_display = is_string( $hotline_raw ) && '' !== trim( $hotline_raw )
		? preg_replace( '/(\d{4})(\d{3})(\d{3})/', '$1 $2 $3', preg_replace( '/\D+/', '', $hotline_raw ) )
		: '1900 888 999';
}

$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';

$zalo_url = xe36_get_site_field( 'zalo_url', 'https://zalo.me/1jc92dlvfodg4' );
if ( ! is_string( $zalo_url ) || '' === trim( $zalo_url ) ) {
	$zalo_url = 'https://zalo.me/1jc92dlvfodg4';
}

if ( ! is_string( $button_url ) || '' === trim( $button_url ) ) {
	$button_url = '#home-booking';
}
?>
<section class="home-section home-cta xe36-surface-dark" id="home-cta" data-section="cta">
	<div class="home-cta__glow" aria-hidden="true"></div>
	<div class="home-section__inner home-cta__inner">
		<div class="home-cta__grid">
			<div class="home-cta__col home-cta__col--copy">
				<p class="home-cta__eyebrow">Sẵn sàng lên đường?</p>

				<?php if ( $cta_title ) : ?>
					<h2 class="home-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
				<?php endif; ?>

				<?php if ( $cta_text ) : ?>
					<p class="home-cta__text"><?php echo esc_html( $cta_text ); ?></p>
				<?php endif; ?>

				<ul class="home-cta__perks">
					<li>Không thanh toán trước</li>
					<li>Đón trả tận nơi</li>
					<li>Đúng giờ · đúng ghế</li>
				</ul>
			</div>

			<div class="home-cta__col home-cta__col--hotline">
				<a class="home-cta__hotline" href="<?php echo esc_url( $hotline_tel ); ?>">
					<span class="home-cta__hotline-label">Tổng đài 24/7</span>
					<span class="home-cta__hotline-number"><?php echo esc_html( $hotline_display ); ?></span>
				</a>
			</div>

			<div class="home-cta__col home-cta__col--actions">
				<div class="home-cta__actions">
					<?php if ( $button_text ) : ?>
						<a class="btn home-cta__btn home-cta__btn--book" href="<?php echo esc_url( $button_url ); ?>">
							<?php echo esc_html( $button_text ); ?>
						</a>
					<?php endif; ?>

					<a class="btn home-cta__btn home-cta__btn--call" href="<?php echo esc_url( $hotline_tel ); ?>">
						<?php echo esc_html( $call_text ); ?>
					</a>

					<a class="btn home-cta__btn home-cta__btn--zalo" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( $zalo_text ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
