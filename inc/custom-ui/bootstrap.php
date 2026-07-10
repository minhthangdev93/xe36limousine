<?php
/**
 * Custom UI shell — isolate Xe 36 layouts from OceanWP parent constraints.
 *
 * Pages using this shell (homepage, UI Preview, future custom templates):
 * - Force full-width / no sidebar via OceanWP filters
 * - Hide page header / breadcrumbs
 * - Body class `xe36-custom-ui` for CSS isolation
 * - Own layout CSS (assets/css/custom-ui.css) beats parent #content-wrap padding
 *
 * Admin content still comes from ACF; this only controls chrome/layout.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the current view uses the custom UI shell.
 *
 * @return bool
 */
function xe36_is_custom_ui() {
	if ( is_front_page() ) {
		return true;
	}

	if ( is_page() ) {
		$slug = get_page_template_slug( get_queried_object_id() );

		if ( in_array(
			$slug,
			array(
				'page-templates/ui-preview.php',
			),
			true
		) ) {
			return true;
		}
	}

	/**
	 * Allow other templates to opt into the custom UI shell.
	 *
	 * @param bool $is_custom Whether custom UI applies.
	 */
	return (bool) apply_filters( 'xe36_is_custom_ui', false );
}

/**
 * Body class for CSS isolation from OceanWP layout.
 *
 * @param array $classes Body classes.
 * @return array
 */
function xe36_custom_ui_body_class( $classes ) {
	if ( xe36_is_custom_ui() ) {
		$classes[] = 'xe36-custom-ui';
		$classes[] = 'content-full-screen';
		$classes[] = 'no-margins';
	}

	return $classes;
}
add_filter( 'body_class', 'xe36_custom_ui_body_class', 20 );

/**
 * Force OceanWP layout class to full-screen (no sidebar column).
 *
 * @param string $class Layout class.
 * @return string
 */
function xe36_custom_ui_layout_class( $class ) {
	if ( xe36_is_custom_ui() ) {
		return 'full-screen';
	}

	return $class;
}
add_filter( 'ocean_post_layout_class', 'xe36_custom_ui_layout_class', 20 );

/**
 * Hide OceanWP page header on custom UI views.
 *
 * @param bool $display Whether to show page header.
 * @return bool
 */
function xe36_custom_ui_hide_page_header( $display ) {
	if ( xe36_is_custom_ui() ) {
		return false;
	}

	return $display;
}
add_filter( 'ocean_display_page_header', 'xe36_custom_ui_hide_page_header', 20 );

/**
 * Enqueue custom UI isolation stylesheet.
 */
function xe36_enqueue_custom_ui_assets() {
	if ( ! xe36_is_custom_ui() ) {
		return;
	}

	wp_enqueue_style(
		'xe36-custom-ui',
		xe36_theme_uri( 'assets/css/custom-ui.css' ),
		array( 'xe36-variables', 'xe36-components' ),
		xe36_theme_version()
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_custom_ui_assets', 25 );

/**
 * Open custom UI shell markup (call from templates after get_header).
 */
function xe36_custom_ui_shell_open() {
	echo '<div id="content-wrap" class="clr xe36-shell">';
	echo '<div id="primary" class="xe36-shell__primary">';
	echo '<div id="content" class="xe36-shell__content">';
}

/**
 * Close custom UI shell markup.
 */
function xe36_custom_ui_shell_close() {
	echo '</div><!-- .xe36-shell__content -->';
	echo '</div><!-- .xe36-shell__primary -->';
	echo '</div><!-- .xe36-shell -->';
}
