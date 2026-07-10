<?php
/**
 * ACF Pro integration — admin-safe content layer.
 *
 * Architecture:
 * - Field STRUCTURE: PHP (inc/acf/field-groups/) + optional acf-json/ sync in git.
 * - Field VALUES: WordPress options DB (xe36_homepage, xe36_site) — survives code deploys.
 * - defaults.php: fallback copy only; xe36_seed_acf_defaults() fills EMPTY fields once.
 * - Templates: always xe36_get_homepage_field() / xe36_get_site_field(), never hardcode.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

xe36_require_inc( 'acf/defaults.php' );
xe36_require_inc( 'acf/helpers.php' );

/**
 * Configure ACF JSON sync inside child theme.
 *
 * @param string $path Save path.
 * @return string
 */
function xe36_acf_json_save_path( $path ) {
	return xe36_theme_path( 'acf-json' );
}
add_filter( 'acf/settings/save_json', 'xe36_acf_json_save_path' );

/**
 * Load ACF JSON from child theme.
 *
 * @param array $paths Load paths.
 * @return array
 */
function xe36_acf_json_load_paths( $paths ) {
	$paths[] = xe36_theme_path( 'acf-json' );

	return $paths;
}
add_filter( 'acf/settings/load_json', 'xe36_acf_json_load_paths' );

/**
 * Register ACF options pages.
 */
function xe36_acf_register_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title'      => 'Xe 36 — Trang chủ',
			'menu_title'      => 'Trang chủ',
			'menu_slug'       => 'xe36-homepage',
			'capability'      => 'edit_posts',
			'post_id'         => xe36_acf_homepage_id(),
			'redirect'        => false,
			'icon_url'        => 'dashicons-admin-home',
			'position'        => 58,
			'update_button'   => 'Lưu trang chủ',
			'updated_message' => 'Đã lưu nội dung trang chủ.',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'      => 'Xe 36 — Liên hệ',
			'menu_title'      => 'Liên hệ',
			'menu_slug'       => 'xe36-site',
			'parent_slug'     => 'xe36-homepage',
			'post_id'         => xe36_acf_site_id(),
			'capability'      => 'edit_posts',
			'update_button'   => 'Lưu liên hệ',
			'updated_message' => 'Đã lưu thông tin liên hệ.',
		)
	);
}
add_action( 'acf/init', 'xe36_acf_register_options_pages' );

/**
 * Register local field groups from PHP.
 */
function xe36_acf_register_field_groups() {
	require_once xe36_theme_path( 'inc/acf/field-groups/homepage.php' );
	require_once xe36_theme_path( 'inc/acf/field-groups/site.php' );
	require_once xe36_theme_path( 'inc/acf/field-groups/about.php' );
	require_once xe36_theme_path( 'inc/acf/field-groups/passenger.php' );
	require_once xe36_theme_path( 'inc/acf/field-groups/cargo.php' );
	require_once xe36_theme_path( 'inc/acf/field-groups/contact.php' );

	xe36_acf_register_homepage_fields();
	xe36_acf_register_site_fields();
	xe36_acf_register_about_fields();
	xe36_acf_register_passenger_fields();
	xe36_acf_register_cargo_fields();
	xe36_acf_register_contact_fields();
}
add_action( 'acf/init', 'xe36_acf_register_field_groups' );

/**
 * Seed empty fields after groups are registered.
 */
function xe36_acf_run_default_seed() {
	xe36_seed_acf_defaults();
}
add_action( 'acf/init', 'xe36_acf_run_default_seed', 20 );

/**
 * Whether ACF Pro is available.
 *
 * @return bool
 */
function xe36_acf_is_active() {
	return function_exists( 'get_field' );
}
