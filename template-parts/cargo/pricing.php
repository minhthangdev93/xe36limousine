<?php
/**
 * Cargo: Intro (left) + pricing images (right).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$intro_title   = xe36_get_cargo_field( 'cargo_intro_title' );
$intro_text    = xe36_get_cargo_field( 'cargo_intro_text' );
$intro_image   = xe36_cargo_image_url( xe36_get_cargo_field( 'cargo_intro_image' ) );
$price_title   = xe36_get_cargo_field( 'cargo_pricing_title' );
$price_images  = xe36_cargo_parse_images( (string) xe36_get_cargo_field( 'cargo_pricing_images' ) );
$cta_text      = xe36_get_cargo_field( 'cargo_cta_btn_text' );
$cta_url       = xe36_get_cargo_field( 'cargo_cta_btn_url' );

if ( ! $intro_text && ! $price_images ) {
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
	$cta_text = 'Liên hệ gửi hàng';
}
if ( ! is_string( $cta_url ) || '' === trim( $cta_url ) ) {
	$cta_url = home_url( '/lien-he/' );
}
?>
<section class="cargo-section cargo-pricing" id="cargo-pricing">
	<div class="cargo-section__inner cargo-pricing__inner">
		<div class="cargo-pricing__copy" id="cargo-intro">
			<header class="cargo-pricing__header">
				<p class="cargo-section__eyebrow">Giới thiệu</p>
				<?php if ( $intro_title ) : ?>
					<h2 class="cargo-section__title cargo-pricing__title"><?php echo esc_html( $intro_title ); ?></h2>
				<?php endif; ?>
			</header>

			<?php if ( $intro_text ) : ?>
				<div class="cargo-pricing__body">
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
				<figure class="cargo-pricing__side-media">
					<img
						src="<?php echo esc_url( $intro_image ); ?>"
						alt="<?php echo esc_attr( is_string( $intro_title ) ? $intro_title : 'Vận chuyển hàng hóa' ); ?>"
						loading="lazy"
						decoding="async"
					/>
				</figure>
			<?php endif; ?>

			<div class="cargo-pricing__actions">
				<a class="btn cargo-pricing__btn cargo-pricing__btn--book" href="<?php echo esc_url( $cta_url ); ?>">
					<?php echo esc_html( $cta_text ); ?>
				</a>
				<a class="btn cargo-pricing__btn cargo-pricing__btn--call" href="<?php echo esc_url( $hotline_tel ); ?>">
					Gọi <?php echo esc_html( $hotline_display ); ?>
				</a>
				<a class="btn cargo-pricing__btn cargo-pricing__btn--zalo" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer">
					Nhắn Zalo
				</a>
			</div>
		</div>

		<?php if ( $price_images ) : ?>
			<div class="cargo-pricing__media-stack">
				<?php if ( $price_title ) : ?>
					<p class="cargo-pricing__caption"><?php echo esc_html( $price_title ); ?></p>
				<?php endif; ?>
				<?php foreach ( $price_images as $index => $price_image ) : ?>
					<figure class="cargo-pricing__media">
						<a href="<?php echo esc_url( $price_image ); ?>" target="_blank" rel="noopener noreferrer">
							<img
								src="<?php echo esc_url( $price_image ); ?>"
								alt="<?php echo esc_attr( sprintf( 'Bảng giá vận chuyển hàng hóa %d', $index + 1 ) ); ?>"
								loading="lazy"
								decoding="async"
							/>
						</a>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
