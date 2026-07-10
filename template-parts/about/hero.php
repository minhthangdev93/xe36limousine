<?php
/**
 * About: Hero intro.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$eyebrow  = xe36_get_about_field( 'about_hero_eyebrow' );
$title    = xe36_get_about_field( 'about_hero_title' );
$text     = xe36_get_about_field( 'about_hero_text' );
$cta_text = xe36_get_about_field( 'about_hero_cta_text' );
$cta_url  = xe36_get_about_field( 'about_hero_cta_url' );
$image    = xe36_get_about_field( 'about_hero_image' );

if ( is_array( $image ) && ! empty( $image['url'] ) ) {
	$image = $image['url'];
} elseif ( is_numeric( $image ) ) {
	$image = wp_get_attachment_image_url( (int) $image, 'large' );
}
?>
<section class="about-section about-hero" id="about-hero">
	<div class="about-section__inner about-hero__inner">
		<div class="about-hero__copy">
			<?php if ( $eyebrow ) : ?>
				<p class="about-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<?php if ( $title ) : ?>
				<h1 class="about-hero__title"><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>
			<?php if ( $text ) : ?>
				<p class="about-hero__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
			<?php if ( $cta_text && $cta_url ) : ?>
				<a class="btn about-hero__cta" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( is_string( $image ) && '' !== $image ) : ?>
			<figure class="about-hero__media">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( is_string( $title ) ? $title : '' ); ?>" loading="eager" decoding="async" />
			</figure>
		<?php endif; ?>
	</div>
</section>
