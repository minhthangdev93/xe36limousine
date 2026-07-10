<?php
/**
 * About: Services.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_about_field( 'about_services_title' );
$sub   = xe36_get_about_field( 'about_services_sub' );
$items = xe36_about_parse_services( (string) xe36_get_about_field( 'about_services' ) );

if ( ! $items ) {
	return;
}
?>
<section class="about-section about-services" id="about-services">
	<div class="about-section__inner">
		<?php if ( $title || $sub ) : ?>
			<header class="about-section__header">
				<?php if ( $title ) : ?>
					<p class="about-section__eyebrow"><?php echo esc_html( $title ); ?></p>
				<?php endif; ?>
				<?php if ( $sub ) : ?>
					<h2 class="about-section__title"><?php echo esc_html( $sub ); ?></h2>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<ul class="about-services__grid">
			<?php foreach ( $items as $item ) : ?>
				<li class="about-services__card">
					<?php if ( $item['image'] ) : ?>
						<a class="about-services__media" href="<?php echo esc_url( $item['url'] ); ?>">
							<img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" decoding="async" />
						</a>
					<?php endif; ?>
					<div class="about-services__body">
						<h3 class="about-services__card-title">
							<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
						</h3>
						<?php if ( $item['text'] ) : ?>
							<p class="about-services__card-text"><?php echo esc_html( $item['text'] ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
