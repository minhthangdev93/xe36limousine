<?php
/**
 * Homepage template helpers.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get registered homepage sections.
 *
 * @return array<string, array{label: string, enabled: bool}>
 */
function xe36_get_homepage_sections() {
	$sections = require xe36_theme_path( 'inc/homepage/config.php' );

	/**
	 * Filter homepage section registry.
	 *
	 * @param array $sections Section config.
	 */
	return apply_filters( 'xe36_homepage_sections', $sections );
}

/**
 * Render a homepage section template part.
 *
 * @param string $slug Section slug.
 * @param array  $args Optional arguments passed to the template.
 */
function xe36_render_homepage_section( $slug, $args = array() ) {
	$sections = xe36_get_homepage_sections();

	if ( empty( $sections[ $slug ]['enabled'] ) ) {
		return;
	}

	$template = 'template-parts/homepage/' . $slug;

	if ( ! locate_template( $template . '.php', false, false ) ) {
		return;
	}

	get_template_part( 'template-parts/homepage/' . $slug, null, $args );
}

/**
 * Enqueue homepage-only assets.
 */
function xe36_enqueue_homepage_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$version  = xe36_theme_version();
	$sections = xe36_get_homepage_sections();

	wp_enqueue_style(
		'xe36-homepage',
		xe36_theme_uri( 'assets/css/homepage.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		$version
	);

	$gallery_on = ! empty( $sections['gallery']['enabled'] );
	if ( $gallery_on && function_exists( 'xe36_get_homepage_field' ) ) {
		$images = xe36_get_homepage_field( 'gallery_images', array() );
		if ( is_array( $images ) && ! empty( $images ) ) {
			wp_enqueue_script(
				'xe36-gallery-carousel',
				xe36_theme_uri( 'assets/js/gallery-carousel.js' ),
				array(),
				$version,
				true
			);
		}
	}

	if ( ! empty( $sections['content']['enabled'] ) && function_exists( 'xe36_enqueue_readmore_assets' ) ) {
		xe36_enqueue_readmore_assets();
	}

	if ( ! empty( $sections['offers']['enabled'] ) ) {
		wp_enqueue_script(
			'xe36-youtube-facade',
			xe36_theme_uri( 'assets/js/youtube-facade.js' ),
			array(),
			$version,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_homepage_assets', 30 );

/**
 * Use PHP homepage template instead of Elementor on front page.
 */
function xe36_homepage_disable_elementor_canvas() {
	if ( ! is_front_page() ) {
		return;
	}

	add_filter( 'elementor/theme/do_location', 'xe36_skip_elementor_theme_locations_on_home', 10, 2 );
	add_filter( 'elementor/frontend/builder_content_data', 'xe36_strip_elementor_builder_on_home', 10, 2 );
}
add_action( 'wp', 'xe36_homepage_disable_elementor_canvas' );

/**
 * Prevent Elementor builder output on the PHP homepage.
 *
 * @param array $data    Elementor builder data.
 * @param int   $post_id Post ID.
 * @return array
 */
function xe36_strip_elementor_builder_on_home( $data, $post_id ) {
	if ( is_front_page() && (int) $post_id === (int) get_queried_object_id() ) {
		return array();
	}

	return $data;
}

/**
 * Skip Elementor theme locations on the PHP homepage.
 *
 * @param bool   $do_location Whether Elementor should render the location.
 * @param string $location    Theme location name.
 * @return bool
 */
function xe36_skip_elementor_theme_locations_on_home( $do_location, $location ) {
	if ( is_front_page() ) {
		return false;
	}

	return $do_location;
}
