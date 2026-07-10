<?php
/**
 * About: Why choose us.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_about_field( 'about_benefits_title' );
$items = xe36_about_parse_pairs( (string) xe36_get_about_field( 'about_benefits' ) );

if ( ! $items ) {
	return;
}
?>
<section class="about-section about-benefits" id="about-benefits">
	<div class="about-section__inner">
		<?php if ( $title ) : ?>
			<header class="about-section__header">
				<p class="about-section__eyebrow">Ưu điểm</p>
				<h2 class="about-section__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<ul class="about-benefits__grid">
			<?php foreach ( $items as $index => $item ) : ?>
				<li class="about-benefits__card">
					<span class="about-benefits__num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
					<div class="about-benefits__body">
						<h3 class="about-benefits__card-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<?php if ( $item['text'] ) : ?>
							<p class="about-benefits__card-text"><?php echo esc_html( $item['text'] ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
