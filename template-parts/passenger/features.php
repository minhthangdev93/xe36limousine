<?php
/**
 * Passenger: Service standards.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_passenger_field( 'pax_features_title' );
$lead  = xe36_get_passenger_field( 'pax_features_lead' );
$items = xe36_passenger_parse_pairs( (string) xe36_get_passenger_field( 'pax_features' ) );

if ( ! $items ) {
	return;
}
?>
<section class="pax-section pax-features" id="pax-features">
	<div class="pax-section__inner">
		<?php if ( $title || $lead ) : ?>
			<header class="pax-section__header">
				<p class="pax-section__eyebrow">Cam kết</p>
				<?php if ( $title ) : ?>
					<h2 class="pax-section__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $lead ) : ?>
					<p class="pax-features__lead"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<ul class="pax-features__grid">
			<?php foreach ( $items as $index => $item ) : ?>
				<li class="pax-features__card">
					<span class="pax-features__num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
					<div class="pax-features__body">
						<h3 class="pax-features__card-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<?php if ( $item['text'] ) : ?>
							<p class="pax-features__card-text"><?php echo esc_html( $item['text'] ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
