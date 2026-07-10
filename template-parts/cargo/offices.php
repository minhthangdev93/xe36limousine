<?php
/**
 * Cargo: Offices.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_cargo_field( 'cargo_offices_title' );
?>
<section class="cargo-section cargo-offices" id="cargo-offices">
	<div class="cargo-section__inner">
		<?php if ( $title ) : ?>
			<header class="cargo-section__header">
				<p class="cargo-section__eyebrow">Địa điểm</p>
				<h2 class="cargo-section__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="cargo-offices__content">
			<?php echo do_shortcode( '[vanphong_xe36]' ); ?>
		</div>
	</div>
</section>
