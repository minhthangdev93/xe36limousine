<?php
/**
 * Cargo: Hero.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$eyebrow  = xe36_get_cargo_field( 'cargo_hero_eyebrow' );
$title    = xe36_get_cargo_field( 'cargo_hero_title' );
$text     = xe36_get_cargo_field( 'cargo_hero_text' );
$cta_text = xe36_get_cargo_field( 'cargo_hero_cta_text' );
$cta_url  = xe36_get_cargo_field( 'cargo_hero_cta_url' );
$image    = xe36_cargo_image_url( xe36_get_cargo_field( 'cargo_hero_image' ) );
?>
<section class="cargo-section cargo-hero" id="cargo-hero">
	<div class="cargo-section__inner">
		<?php xe36_the_breadcrumb(); ?>
		<div class="cargo-hero__inner">
			<div class="cargo-hero__copy">
				<?php if ( $eyebrow ) : ?>
					<p class="cargo-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h1 class="cargo-hero__title"><?php echo esc_html( $title ); ?></h1>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<p class="cargo-hero__text"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
				<?php if ( $cta_text && $cta_url ) : ?>
					<a class="btn cargo-hero__cta" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
				<?php endif; ?>
			</div>
			<?php if ( $image ) : ?>
				<figure class="cargo-hero__media">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( is_string( $title ) ? $title : '' ); ?>" loading="eager" decoding="async" />
				</figure>
			<?php endif; ?>
		</div>
	</div>
</section>
