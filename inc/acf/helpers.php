<?php
/**
 * ACF read helpers — DB first, PHP defaults as fallback only.
 *
 * Rules:
 * - Never call update_field() except xe36_seed_acf_defaults() for empty fields.
 * - Field names are a stable API; rename only with a migration.
 * - Templates must use these helpers, not hardcoded copy.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * ACF options post_id for homepage fields.
 */
function xe36_acf_homepage_id() {
	return 'xe36_homepage';
}

/**
 * ACF options post_id for site-wide fields.
 */
function xe36_acf_site_id() {
	return 'xe36_site';
}

/**
 * Whether an ACF value should be treated as empty.
 *
 * @param mixed $value Field value.
 * @return bool
 */
function xe36_acf_value_is_empty( $value ) {
	if ( $value === null || $value === false || $value === '' ) {
		return true;
	}

	if ( is_array( $value ) && array() === $value ) {
		return true;
	}

	return false;
}

/**
 * Get a homepage option field with fallback.
 *
 * @param string     $name    ACF field name.
 * @param mixed|null $default Explicit default; uses defaults.php when null.
 * @return mixed
 */
function xe36_get_homepage_field( $name, $default = null ) {
	if ( null === $default ) {
		$defaults = xe36_acf_defaults();
		$default  = $defaults['homepage'][ $name ] ?? null;
	}

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, xe36_acf_homepage_id() );
		if ( ! xe36_acf_value_is_empty( $value ) ) {
			return $value;
		}
	}

	return $default;
}

/**
 * Get a site-wide option field with fallback.
 *
 * @param string     $name    ACF field name.
 * @param mixed|null $default Explicit default; uses defaults.php when null.
 * @return mixed
 */
function xe36_get_site_field( $name, $default = null ) {
	if ( null === $default ) {
		$defaults = xe36_acf_defaults();
		$default  = $defaults['site'][ $name ] ?? null;
	}

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, xe36_acf_site_id() );
		if ( ! xe36_acf_value_is_empty( $value ) ) {
			return $value;
		}
	}

	return $default;
}

/**
 * Resolve an ACF image field to a URL.
 *
 * @param string $name    Field name.
 * @param string $context homepage|site.
 * @param string $default Fallback URL.
 * @return string
 */
function xe36_get_acf_image_url( $name, $context = 'homepage', $default = '' ) {
	$value = 'site' === $context
		? xe36_get_site_field( $name, null )
		: xe36_get_homepage_field( $name, null );

	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return (string) $value['url'];
	}

	if ( is_numeric( $value ) ) {
		$url = wp_get_attachment_image_url( (int) $value, 'full' );
		return $url ? $url : $default;
	}

	if ( is_string( $value ) && '' !== $value ) {
		return $value;
	}

	return $default;
}

/**
 * Seed empty ACF option fields from defaults.php (never overwrites admin data).
 *
 * Runs on acf/init — safe on every deploy when new default keys are added.
 */
function xe36_seed_acf_defaults() {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$map = array(
		xe36_acf_homepage_id() => xe36_acf_defaults()['homepage'],
		xe36_acf_site_id()     => xe36_acf_defaults()['site'],
	);

	foreach ( $map as $post_id => $fields ) {
		foreach ( $fields as $key => $default_value ) {
			$existing = get_field( $key, $post_id );

			if ( ! xe36_acf_value_is_empty( $existing ) ) {
				continue;
			}

			if ( xe36_acf_value_is_empty( $default_value ) ) {
				continue;
			}

			update_field( $key, $default_value, $post_id );
		}
	}
}

/**
 * Merge ACF section toggles into homepage section registry.
 *
 * @param array<string, array{label: string, enabled: bool}> $sections Sections.
 * @return array<string, array{label: string, enabled: bool}>
 */
function xe36_acf_homepage_section_toggles( $sections ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $sections;
	}

	foreach ( $sections as $slug => $config ) {
		$field_name = 'section_' . $slug . '_enabled';
		$value      = get_field( $field_name, xe36_acf_homepage_id() );

		if ( null !== $value && false !== $value && '' !== $value ) {
			$sections[ $slug ]['enabled'] = (bool) $value;
		} elseif ( 0 === $value || '0' === $value ) {
			$sections[ $slug ]['enabled'] = false;
		}
	}

	return $sections;
}
add_filter( 'xe36_homepage_sections', 'xe36_acf_homepage_section_toggles' );
