<?php
/**
 * Homepage section: Customer reviews (Trustindex shortcode).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title     = xe36_get_homepage_field( 'reviews_title', 'Khách hàng nói gì về chúng tôi' );
$shortcode = xe36_get_homepage_field( 'reviews_shortcode', '[trustindex no-registration=google]' );

if ( ! is_string( $shortcode ) || '' === trim( $shortcode ) ) {
	$shortcode = '[trustindex no-registration=google]';
}

$shortcode = trim( $shortcode );
?>
<section class="home-section home-reviews" id="home-reviews" data-section="reviews">
	<div class="home-section__inner home-reviews__inner">
		<?php if ( $title ) : ?>
			<header class="home-reviews__header">
				<p class="home-reviews__eyebrow">Đánh giá</p>
				<h2 class="home-reviews__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="home-reviews__widget">
			<?php echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>
</section>
