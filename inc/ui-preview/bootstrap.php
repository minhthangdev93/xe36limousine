<?php
/**
 * UI preview page assets.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the current request is the UI preview page.
 *
 * @return bool
 */
function xe36_is_ui_preview_page() {
	if ( ! is_page() ) {
		return false;
	}

	return 'page-templates/ui-preview.php' === get_page_template_slug( get_queried_object_id() );
}

/**
 * Enqueue preview-only styles.
 */
function xe36_enqueue_ui_preview_assets() {
	if ( ! xe36_is_ui_preview_page() ) {
		return;
	}

	wp_enqueue_style(
		'xe36-ui-preview',
		xe36_theme_uri( 'assets/css/ui-preview.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		xe36_theme_version()
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_ui_preview_assets', 35 );

/**
 * Keep preview pages out of search indexes.
 */
function xe36_ui_preview_noindex() {
	if ( xe36_is_ui_preview_page() ) {
		echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
	}
}
add_action( 'wp_head', 'xe36_ui_preview_noindex', 1 );
