<?php
/**
 * About: Contact CTA.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title    = xe36_get_about_field( 'about_cta_title' );
$text     = xe36_get_about_field( 'about_cta_text' );
$btn_text = xe36_get_about_field( 'about_cta_btn_text' );
$btn_url  = xe36_get_about_field( 'about_cta_btn_url' );

$hotline_raw     = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_display = xe36_get_site_field( 'hotline_display', '1900 888 999' );
if ( ! is_string( $hotline_display ) || '' === trim( $hotline_display ) || '1900 xxxx' === trim( $hotline_display ) ) {
	$hotline_display = '1900 888 999';
}
$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';
?>
<section class="about-section about-cta" id="about-cta">
	<div class="about-section__inner about-cta__inner">
		<?php if ( $title ) : ?>
			<h2 class="about-cta__title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
		<?php if ( $text ) : ?>
			<p class="about-cta__text"><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
		<div class="about-cta__actions">
			<?php if ( $btn_text && $btn_url ) : ?>
				<a class="btn about-cta__btn about-cta__btn--primary" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
			<?php endif; ?>
			<a class="btn about-cta__btn about-cta__btn--call" href="<?php echo esc_url( $hotline_tel ); ?>">Gọi <?php echo esc_html( $hotline_display ); ?></a>
		</div>
	</div>
</section>
