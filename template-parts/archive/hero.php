<?php
/**
 * Archive: Hero title (compact).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$eyebrow = xe36_archive_eyebrow();
$title   = xe36_archive_title();
$text    = xe36_archive_description();
$count   = (int) $GLOBALS['wp_query']->found_posts;
?>
<section class="archive-section archive-hero" id="archive-hero">
	<div class="archive-section__inner">
		<?php xe36_the_breadcrumb(); ?>
		<div class="archive-hero__inner">
			<div class="archive-hero__row">
				<?php if ( $eyebrow ) : ?>
					<span class="archive-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h1 class="archive-hero__title"><?php echo esc_html( $title ); ?></h1>
				<?php endif; ?>
				<?php if ( $count > 0 ) : ?>
					<span class="archive-hero__meta"><?php echo esc_html( sprintf( _n( '%s bài', '%s bài', $count, 'oceanwp-child' ), number_format_i18n( $count ) ) ); ?></span>
				<?php endif; ?>
			</div>
			<?php if ( $text ) : ?>
				<p class="archive-hero__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
