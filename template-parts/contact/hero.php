<?php
/**
 * Contact: Hero.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$eyebrow = xe36_get_contact_field( 'contact_hero_eyebrow' );
$title   = xe36_get_contact_field( 'contact_hero_title' );
$text    = xe36_get_contact_field( 'contact_hero_text' );
?>
<section class="contact-section contact-hero" id="contact-hero">
	<div class="contact-section__inner contact-hero__inner">
		<?php if ( $eyebrow ) : ?>
			<p class="contact-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>
		<?php if ( $title ) : ?>
			<h1 class="contact-hero__title"><?php echo esc_html( $title ); ?></h1>
		<?php endif; ?>
		<?php if ( $text ) : ?>
			<p class="contact-hero__text"><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
	</div>
</section>
