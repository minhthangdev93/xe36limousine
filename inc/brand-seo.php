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
