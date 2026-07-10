<?php
/**
 * About: Offices (vanphong shortcode).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_about_field( 'about_offices_title' );
?>
<section class="about-section about-offices" id="about-offices">
	<div class="about-section__inner">
		<?php if ( $title ) : ?>
			<header class="about-section__header">
				<p class="about-section__eyebrow">Địa điểm</p>
				<h2 class="about-section__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="about-offices__content">
			<?php echo do_shortcode( '[vanphong_xe36]' ); ?>
		</div>
	</div>
</section>
