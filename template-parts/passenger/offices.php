<?php
/**
 * Passenger: Offices.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_passenger_field( 'pax_offices_title' );
?>
<section class="pax-section pax-offices" id="pax-offices">
	<div class="pax-section__inner">
		<?php if ( $title ) : ?>
			<header class="pax-section__header">
				<p class="pax-section__eyebrow">Địa điểm</p>
				<h2 class="pax-section__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="pax-offices__content">
			<?php echo do_shortcode( '[vanphong_xe36]' ); ?>
		</div>
	</div>
</section>
