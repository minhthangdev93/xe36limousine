<?php
/**
 * Contact: Offices.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_contact_field( 'contact_offices_title' );
?>
<section class="contact-section contact-offices" id="contact-offices">
	<div class="contact-section__inner">
		<?php if ( $title ) : ?>
			<header class="contact-section__header">
				<p class="contact-section__eyebrow">Địa điểm</p>
				<h2 class="contact-section__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="contact-offices__content">
			<?php echo do_shortcode( '[vanphong_xe36]' ); ?>
		</div>
	</div>
</section>
