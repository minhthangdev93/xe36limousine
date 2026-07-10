<?php
/**
 * [vanphong_xe36] shortcode — office locations list.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue vanphong shortcode assets once per request.
 */
function xe36_enqueue_vanphong_assets() {
	static $enqueued = false;

	if ( $enqueued ) {
		return;
	}

	$enqueued = true;

	wp_enqueue_style(
		'xe36-vanphong',
		xe36_theme_uri( 'assets/css/vanphong.css' ),
		array( 'xe36-variables' ),
		xe36_theme_version()
	);
}

/**
 * Render office list shortcode.
 *
 * @return string
 */
function xe36_vanphong_shortcode() {
	xe36_enqueue_vanphong_assets();

	ob_start();
	require xe36_theme_path( 'inc/shortcodes/partials/vanphong.php' );
	return ob_get_clean();
}
add_shortcode( 'vanphong_xe36', 'xe36_vanphong_shortcode' );
