<?php
/**
 * Passenger: Hero.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$eyebrow  = xe36_get_passenger_field( 'pax_hero_eyebrow' );
$title    = xe36_get_passenger_field( 'pax_hero_title' );
$text     = xe36_get_passenger_field( 'pax_hero_text' );
$cta_text = xe36_get_passenger_field( 'pax_hero_cta_text' );
$cta_url  = xe36_get_passenger_field( 'pax_hero_cta_url' );
$image    = xe36_passenger_image_url( xe36_get_passenger_field( 'pax_hero_image' ) );
?>
<section class="pax-section pax-hero" id="pax-hero">
	<div class="pax-section__inner pax-hero__inner">
		<div class="pax-hero__copy">
			<?php if ( $eyebrow ) : ?>
				<p class="pax-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<?php if ( $title ) : ?>
				<h1 class="pax-hero__title"><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>
			<?php if ( $text ) : ?>
				<p class="pax-hero__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
			<?php if ( $cta_text && $cta_url ) : ?>
				<a class="btn pax-hero__cta" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( $image ) : ?>
			<figure class="pax-hero__media">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( is_string( $title ) ? $title : '' ); ?>" loading="eager" decoding="async" />
			</figure>
		<?php endif; ?>
	</div>
</section>
