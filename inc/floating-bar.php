<?php
/**
 * Floating contact bar (WhatsApp, Zalo, phone, Messenger).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Resolve upload URL for local or production media.
 *
 * @param string $relative_path Path relative to wp-content/uploads/.
 * @return string
 */
function xe36_uploads_url( $relative_path ) {
	$relative_path = ltrim( $relative_path, '/' );
	$local_file    = WP_CONTENT_DIR . '/uploads/' . $relative_path;

	if ( file_exists( $local_file ) ) {
		return content_url( 'uploads/' . $relative_path );
	}

	return 'https://xe36limousine.vn/wp-content/uploads/' . $relative_path;
}

/**
 * Enqueue floating bar styles with icon variables.
 */
function xe36_enqueue_floating_bar_assets() {
	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-floating-bar',
		xe36_theme_uri( 'assets/css/floating-bar.css' ),
		array( 'xe36-variables' ),
		$version
	);

	$icon_vars = sprintf(
		':root {
			--xe36-icon-whatsapp: url("%s");
			--xe36-icon-zalo: url("%s");
			--xe36-icon-messenger: url("%s");
			--xe36-icon-phone: url("%s");
		}',
		esc_url( xe36_uploads_url( '2022/08/whatsapp.png' ) ),
		esc_url( xe36_uploads_url( '2022/08/icon_zalo.png' ) ),
		esc_url( xe36_uploads_url( '2022/08/icon_messenger.png' ) ),
		esc_url( xe36_uploads_url( '2022/08/phone.png' ) )
	);

	wp_add_inline_style( 'xe36-floating-bar', $icon_vars );
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_floating_bar_assets', 25 );

/**
 * Render floating contact bar before body closes.
 */
function xe36_render_floating_contact_bar() {
	get_template_part( 'template-parts/floating-contact-bar' );
}
add_action( 'wp_footer', 'xe36_render_floating_contact_bar', 50 );
