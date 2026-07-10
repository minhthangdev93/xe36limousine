<?php
/**
 * Custom site footer — luxury dark band synced with CTA.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue footer stylesheet.
 */
function xe36_enqueue_footer_assets() {
	wp_enqueue_style(
		'xe36-footer',
		xe36_theme_uri( 'assets/css/footer.css' ),
		array( 'xe36-variables', 'xe36-components' ),
		xe36_theme_version()
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_footer_assets', 28 );

/**
 * Parse "Label|URL" lines into link arrays.
 *
 * @param string $raw Raw textarea.
 * @return array<int, array{label: string, url: string}>
 */
function xe36_footer_parse_links( $raw ) {
	$links = array();
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $links;
	}

	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		$links[] = array(
			'label' => $parts[0],
			'url'   => $parts[1] ?? '#',
		);
	}

	return $links;
}

/**
 * Parse plain address lines.
 *
 * @param string $raw Raw textarea.
 * @return array<int, string>
 */
function xe36_footer_parse_lines( $raw ) {
	$lines = array();
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $lines;
	}

	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$lines[] = $line;
		}
	}

	return $lines;
}
