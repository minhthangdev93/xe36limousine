<?php
/**
 * Homepage section: SEO content from the front page editor ([readmore] block).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$page_id = (int) get_queried_object_id();
if ( $page_id <= 0 ) {
	$page_id = (int) get_option( 'page_on_front' );
}

if ( $page_id <= 0 ) {
	return;
}

$raw = get_post_field( 'post_content', $page_id );
if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
	return;
}

$html = '';

if ( preg_match( '/\[readmore([^\]]*)\]([\s\S]*?)\[\/readmore\]/i', $raw, $matches ) ) {
	$attrs = isset( $matches[1] ) ? trim( $matches[1] ) : '';
	$inner = $matches[2];
	$html  = do_shortcode( '[readmore' . ( $attrs ? ' ' . $attrs : '' ) . ']' . $inner . '[/readmore]' );
} else {
	// Fallback: whole page content with the same expand UI.
	xe36_enqueue_readmore_assets();
	$html = do_shortcode( '[readmore]' . $raw . '[/readmore]' );
}

if ( '' === trim( wp_strip_all_tags( $html ) ) ) {
	return;
}
?>
<section class="home-section home-content" id="home-content" data-section="content">
	<div class="home-section__inner home-content__inner">
		<div class="home-content__body">
			<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- editor + shortcode HTML. ?>
		</div>
	</div>
</section>
