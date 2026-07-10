<?php
/**
 * Single: Bottom CTA.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$hotline_raw     = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_display = xe36_get_site_field( 'hotline_display', '1900 888 999' );
if ( ! is_string( $hotline_display ) || '' === trim( $hotline_display ) || '1900 xxxx' === trim( $hotline_display ) ) {
	$hotline_display = '1900 888 999';
}
$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';

$cats = get_the_category();
$back = ! empty( $cats ) ? get_category_link( $cats[0]->term_id ) : home_url( '/tin-tuc/' );
?>
<section class="single-section single-cta" id="single-cta">
	<div class="single-section__inner single-cta__inner">
		<h2 class="single-cta__title">Cần đặt xe hoặc gửi hàng?</h2>
		<p class="single-cta__text">Liên hệ tổng đài 24/7 hoặc gửi form — Xe 36 Limousine hỗ trợ nhanh.</p>
		<div class="single-cta__actions">
			<a class="btn single-cta__btn single-cta__btn--primary" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a>
			<a class="btn single-cta__btn single-cta__btn--call" href="<?php echo esc_url( $hotline_tel ); ?>">Gọi <?php echo esc_html( $hotline_display ); ?></a>
			<a class="btn single-cta__btn single-cta__btn--ghost" href="<?php echo esc_url( $back ); ?>">← Quay lại chuyên mục</a>
		</div>
	</div>
</section>
