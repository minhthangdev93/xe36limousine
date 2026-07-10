<?php
/**
 * Theme setup: paths, asset enqueue, OceanWP parent hooks.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Absolute path inside child theme.
 *
 * @param string $file Relative file path.
 * @return string
 */
function xe36_theme_path( $file = '' ) {
	return get_stylesheet_directory() . '/' . ltrim( $file, '/' );
}

/**
 * Public URI inside child theme.
 *
 * @param string $file Relative file path.
 * @return string
 */
function xe36_theme_uri( $file = '' ) {
	return get_stylesheet_directory_uri() . '/' . ltrim( $file, '/' );
}

/**
 * Require a file from inc/.
 *
 * @param string $file Path relative to inc/.
 */
function xe36_require_inc( $file ) {
	require_once xe36_theme_path( 'inc/' . ltrim( $file, '/' ) );
}

/**
 * Child theme version for cache busting.
 *
 * @return string
 */
function xe36_theme_version() {
	$theme = wp_get_theme();
	return $theme->get( 'Version' ) ?: '1.0.0';
}

/**
 * Load parent RTL stylesheet when the site locale is RTL.
 *
 * @param string $uri Stylesheet URI.
 * @return string
 */
function xe36_locale_stylesheet_uri( $uri ) {
	if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
		$uri = get_template_directory_uri() . '/rtl.css';
	}

	return $uri;
}
add_filter( 'locale_stylesheet_uri', 'xe36_locale_stylesheet_uri' );

/**
 * Global design tokens and shared components.
 */
function xe36_enqueue_global_assets() {
	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-variables',
		xe36_theme_uri( 'assets/css/variables.css' ),
		array(),
		$version
	);

	wp_enqueue_style(
		'xe36-components',
		xe36_theme_uri( 'assets/css/components.css' ),
		array( 'xe36-variables' ),
		$version
	);

	wp_enqueue_style(
		'xe36-elementor-sync',
		xe36_theme_uri( 'assets/css/elementor-sync.css' ),
		array( 'xe36-variables', 'xe36-components' ),
		$version
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_global_assets', 20 );
