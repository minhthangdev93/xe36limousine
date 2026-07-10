<?php
/**
 * Brand name sync for Rank Math and JSON-LD schema.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Primary site brand name.
 *
 * @return string
 */
function xe36_brand_site_name() {
	return 'Xe 36 Limousine';
}

/**
 * Alternate names for WebSite schema.
 *
 * @return string[]
 */
function xe36_brand_alternate_names() {
	return array( '36 Travel Limousine', 'xe36limousine.vn' );
}

/**
 * Sync Rank Math title settings with unified brand.
 *
 * @param array|false $settings Rank Math titles option.
 * @return array
 */
function xe36_sync_rank_math_brand_settings( $settings ) {
	if ( ! is_array( $settings ) ) {
		$settings = array();
	}

	$settings['website_name']           = xe36_brand_site_name();
	$settings['knowledgegraph_name']    = xe36_brand_site_name();
	$settings['website_alternate_name'] = implode( ', ', xe36_brand_alternate_names() );

	return $settings;
}
add_filter( 'option_rank-math-options-titles', 'xe36_sync_rank_math_brand_settings' );

/**
 * Normalize WebSite / Organization names in Rank Math JSON-LD.
 *
 * @param array $data Schema data.
 * @return array
 */
function xe36_sync_rank_math_schema_brand( $data ) {
	if ( ! is_array( $data ) ) {
		return $data;
	}

	$site_name = xe36_brand_site_name();

	if ( ! empty( $data['WebSite'] ) && is_array( $data['WebSite'] ) ) {
		$data['WebSite']['name']          = $site_name;
		$data['WebSite']['alternateName'] = xe36_brand_alternate_names();
	}

	if ( ! empty( $data['publisher'] ) && is_array( $data['publisher'] ) ) {
		$data['publisher']['name'] = $site_name;
		if ( ! empty( $data['publisher']['logo']['caption'] ) ) {
			$data['publisher']['logo']['caption'] = $site_name;
		}
	}

	foreach ( $data as $key => $entity ) {
		if ( ! is_array( $entity ) || empty( $entity['@type'] ) ) {
			continue;
		}

		$types = array_map( 'strtolower', (array) $entity['@type'] );
		if ( ! array_intersect( $types, array( 'person' ) ) || empty( $entity['worksFor'] ) ) {
			continue;
		}

		$data[ $key ]['name'] = $site_name;
	}

	return $data;
}
add_filter( 'rank_math/json_ld', 'xe36_sync_rank_math_schema_brand', 100 );

/**
 * Normalize ACF / attachment / URL image value to a full URL.
 *
 * @param mixed $value Image field value.
 * @return string
 */
function xe36_normalize_share_image_url( $value ) {
	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return (string) $value['url'];
	}

	if ( is_numeric( $value ) ) {
		$url = wp_get_attachment_image_url( (int) $value, 'full' );
		return $url ? (string) $url : '';
	}

	if ( is_string( $value ) && '' !== trim( $value ) ) {
		return esc_url_raw( trim( $value ) );
	}

	return '';
}

/**
 * Banner / hero image used when sharing on social networks.
 *
 * Priority: page hero → featured image → homepage banner.
 *
 * @return string Absolute image URL or empty.
 */
function xe36_get_share_banner_url() {
	$url = '';

	if ( is_front_page() && function_exists( 'xe36_get_homepage_field' ) ) {
		$url = xe36_normalize_share_image_url( xe36_get_homepage_field( 'hero_image', null ) );
	} elseif ( function_exists( 'xe36_is_about_page' ) && xe36_is_about_page() && function_exists( 'xe36_get_about_field' ) ) {
		$url = xe36_normalize_share_image_url( xe36_get_about_field( 'about_hero_image' ) );
	} elseif ( function_exists( 'xe36_is_passenger_page' ) && xe36_is_passenger_page() && function_exists( 'xe36_get_passenger_field' ) ) {
		$raw = xe36_get_passenger_field( 'pax_hero_image' );
		$url = function_exists( 'xe36_passenger_image_url' )
			? (string) xe36_passenger_image_url( $raw )
			: xe36_normalize_share_image_url( $raw );
	} elseif ( function_exists( 'xe36_is_cargo_page' ) && xe36_is_cargo_page() && function_exists( 'xe36_get_cargo_field' ) ) {
		$raw = xe36_get_cargo_field( 'cargo_hero_image' );
		$url = function_exists( 'xe36_cargo_image_url' )
			? (string) xe36_cargo_image_url( $raw )
			: xe36_normalize_share_image_url( $raw );
	} elseif ( is_singular() && has_post_thumbnail() ) {
		$thumb = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
		$url   = $thumb ? (string) $thumb : '';
	}

	if ( '' === $url && function_exists( 'xe36_get_homepage_field' ) ) {
		$url = xe36_normalize_share_image_url( xe36_get_homepage_field( 'hero_image', null ) );
	}

	/**
	 * Filter social share banner URL.
	 *
	 * @param string $url Image URL.
	 */
	return (string) apply_filters( 'xe36_share_banner_url', $url );
}

/**
 * Force Rank Math Open Graph / Twitter image to page banner.
 *
 * @param string $image Current image URL.
 * @return string
 */
function xe36_filter_rank_math_og_image( $image ) {
	$banner = xe36_get_share_banner_url();
	return $banner ? $banner : $image;
}
add_filter( 'rank_math/opengraph/facebook/image', 'xe36_filter_rank_math_og_image', 20 );
add_filter( 'rank_math/opengraph/twitter/image', 'xe36_filter_rank_math_og_image', 20 );

/**
 * Fallback og:image tags when Rank Math is not active.
 */
function xe36_print_share_og_image_fallback() {
	if ( defined( 'RANK_MATH_VERSION' ) ) {
		return;
	}

	$url = xe36_get_share_banner_url();
	if ( '' === $url ) {
		return;
	}

	echo '<meta property="og:image" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $url ) . '" />' . "\n";
}
add_action( 'wp_head', 'xe36_print_share_og_image_fallback', 5 );
