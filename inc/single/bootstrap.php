<?php
/**
 * Single post helpers and assets.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether current view is a single blog post.
 *
 * @return bool
 */
function xe36_is_single_post() {
	return is_singular( 'post' );
}

/**
 * Opt single posts into custom UI shell.
 *
 * @param bool $is_custom Current flag.
 * @return bool
 */
function xe36_single_is_custom_ui( $is_custom ) {
	return $is_custom || xe36_is_single_post();
}
add_filter( 'xe36_is_custom_ui', 'xe36_single_is_custom_ui' );

/**
 * Disable OceanWP single post title banner (cover + author).
 *
 * @param array $types Allowed post types.
 * @return array
 */
function xe36_single_disable_ocean_header( $types ) {
	if ( xe36_is_single_post() ) {
		return array();
	}
	return $types;
}
add_filter( 'oceanwp_single_post_header_allowed_post_types', 'xe36_single_disable_ocean_header' );

/**
 * Enqueue single post assets.
 */
function xe36_enqueue_single_assets() {
	if ( ! xe36_is_single_post() ) {
		return;
	}

	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-archive',
		xe36_theme_uri( 'assets/css/archive.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		$version
	);

	wp_enqueue_style(
		'xe36-single',
		xe36_theme_uri( 'assets/css/single.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui', 'xe36-archive' ),
		$version
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_single_assets', 30 );

/**
 * Related posts in same primary category.
 *
 * @param int $limit Max posts.
 * @return WP_Post[]
 */
function xe36_single_related_posts( $limit = 3 ) {
	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return array();
	}

	$cats = get_the_category( $post_id );
	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => (int) $limit,
		'post__not_in'        => array( (int) $post_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( ! empty( $cats ) ) {
		$args['category__in'] = array( (int) $cats[0]->term_id );
	}

	$query = new WP_Query( $args );
	return $query->posts;
}
