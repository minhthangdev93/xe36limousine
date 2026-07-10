<?php
/**
 * Homepage section: Popular routes — cards that prefill booking form.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

require_once xe36_theme_path( 'inc/booking/routes.php' );

$title    = xe36_get_homepage_field( 'routes_title', 'Lộ trình phổ biến' );
$cta_text = xe36_get_homepage_field( 'routes_cta_text', 'Đặt vé ngay' );
$cards    = xe36_booking_route_cards();
$images   = xe36_get_homepage_field( 'routes_images', array() );

if ( ! is_array( $images ) ) {
	$images = array();
}

if ( ! $cards ) {
	return;
}

/**
 * Resolve card image from ACF group (hn_th) by route value (hn-th).
 *
 * @param string               $route_value Route key.
 * @param array<string, mixed> $images      ACF group.
 * @return array{id:int,url:string,alt:string}|null
 */
$resolve_image = static function ( $route_value, $images ) {
	$key = str_replace( '-', '_', (string) $route_value );
	$img = $images[ $key ] ?? null;

	if ( is_numeric( $img ) ) {
		$id  = (int) $img;
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( ! $url ) {
			return null;
		}
		return array(
			'id'  => $id,
			'url' => $url,
			'alt' => (string) get_post_meta( $id, '_wp_attachment_image_alt', true ),
		);
	}

	if ( ! is_array( $img ) || empty( $img['ID'] ) ) {
		return null;
	}

	$id  = (int) $img['ID'];
	$url = wp_get_attachment_image_url( $id, 'large' );
	if ( ! $url ) {
		return null;
	}

	return array(
		'id'  => $id,
		'url' => $url,
		'alt' => ! empty( $img['alt'] ) ? (string) $img['alt'] : (string) ( $img['title'] ?? '' ),
	);
};
?>
<section class="home-section home-routes" id="home-routes" data-section="routes">
	<div class="home-section__inner home-routes__inner">
		<?php if ( $title ) : ?>
			<header class="home-routes__header">
				<p class="home-routes__eyebrow">Tuyến xe</p>
				<h2 class="home-routes__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="home-routes__viewport">
			<ul class="home-routes__grid">
				<?php foreach ( $cards as $card ) : ?>
					<?php
					$image = $resolve_image( $card['value'], $images );
					$alt   = $image && $image['alt'] ? $image['alt'] : $card['label'];
					?>
					<li class="home-routes__card">
						<div class="home-routes__media<?php echo $image ? '' : ' home-routes__media--empty'; ?>">
							<?php if ( $image ) : ?>
								<?php
								echo wp_get_attachment_image(
									$image['id'],
									'large',
									false,
									array(
										'class'     => 'home-routes__img',
										'alt'       => $alt,
										'loading'   => 'lazy',
										'decoding'  => 'async',
										'draggable' => 'false',
									)
								);
								?>
							<?php endif; ?>
						</div>

						<div class="home-routes__body">
							<div class="home-routes__route" aria-label="<?php echo esc_attr( $card['label'] ); ?>">
								<span class="home-routes__endpoint"><?php echo esc_html( $card['from'] ); ?></span>
								<span class="home-routes__arrow" aria-hidden="true">→</span>
								<span class="home-routes__endpoint"><?php echo esc_html( $card['to'] ); ?></span>
							</div>

							<p class="home-routes__price"><?php echo esc_html( $card['price_label'] ); ?></p>

							<ul class="home-routes__meta">
								<li><?php echo esc_html( $card['duration'] ); ?></li>
								<li><?php echo esc_html( $card['frequency'] ); ?></li>
							</ul>

							<a
								class="btn btn--primary btn--block home-routes__cta"
								href="#home-booking"
								data-booking-route="<?php echo esc_attr( $card['value'] ); ?>"
							>
								<?php echo esc_html( $cta_text ); ?>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
