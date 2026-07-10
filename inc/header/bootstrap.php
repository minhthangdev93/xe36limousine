<?php
/**
 * Custom site header — design-system synced.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue header assets.
 */
function xe36_enqueue_header_assets() {
	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-header',
		xe36_theme_uri( 'assets/css/header.css' ),
		array( 'xe36-variables', 'xe36-components' ),
		$version
	);

	wp_enqueue_script(
		'xe36-header',
		xe36_theme_uri( 'assets/js/header.js' ),
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_header_assets', 28 );

/**
 * Remove tel: items from the custom header nav (hotline is rendered separately).
 *
 * @param array    $items Menu items.
 * @param stdClass $args  Menu args.
 * @return array
 */
function xe36_header_filter_menu_items( $items, $args ) {
	if ( empty( $args->xe36_header_nav ) ) {
		return $items;
	}

	$filtered = array();
	foreach ( $items as $item ) {
		$url = isset( $item->url ) ? (string) $item->url : '';
		if ( 0 === stripos( $url, 'tel:' ) ) {
			continue;
		}
		// Skip bare phone-number labels.
		$title = isset( $item->title ) ? preg_replace( '/\D+/', '', wp_strip_all_tags( $item->title ) ) : '';
		if ( $title && strlen( $title ) >= 9 && strlen( $title ) <= 12 && ctype_digit( $title ) ) {
			continue;
		}
		$filtered[] = $item;
	}

	return $filtered;
}
add_filter( 'wp_nav_menu_objects', 'xe36_header_filter_menu_items', 10, 2 );
