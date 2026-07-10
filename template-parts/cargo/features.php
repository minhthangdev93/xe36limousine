<?php
/**
 * Cargo: Service commitments.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_cargo_field( 'cargo_features_title' );
$lead  = xe36_get_cargo_field( 'cargo_features_lead' );
$items = xe36_cargo_parse_pairs( (string) xe36_get_cargo_field( 'cargo_features' ) );

if ( ! $items ) {
	return;
}
?>
<section class="cargo-section cargo-features" id="cargo-features">
	<div class="cargo-section__inner">
		<?php if ( $title || $lead ) : ?>
			<header class="cargo-section__header">
				<p class="cargo-section__eyebrow">Cam kết</p>
				<?php if ( $title ) : ?>
					<h2 class="cargo-section__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $lead ) : ?>
					<p class="cargo-features__lead"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<ul class="cargo-features__grid">
			<?php foreach ( $items as $index => $item ) : ?>
				<li class="cargo-features__card">
					<span class="cargo-features__num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
					<div class="cargo-features__body">
						<h3 class="cargo-features__card-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<?php if ( $item['text'] ) : ?>
							<p class="cargo-features__card-text"><?php echo esc_html( $item['text'] ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
