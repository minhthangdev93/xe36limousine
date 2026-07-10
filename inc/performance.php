<?php
/**
 * Frontend performance — Core Web Vitals helpers (LCP / INP / CLS).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Dequeue Elementor frontend CSS/JS (safe on PHP-rendered templates).
 */
function xe36_dequeue_elementor_assets() {
	global $wp_styles, $wp_scripts;

	if ( $wp_styles instanceof WP_Styles ) {
		foreach ( array_keys( $wp_styles->registered ) as $handle ) {
			$src = (string) ( $wp_styles->registered[ $handle ]->src ?? '' );
			if (
				false !== stripos( $handle, 'elementor' )
				|| false !== stripos( $src, '/elementor/' )
				|| false !== stripos( $src, 'elementor/assets' )
			) {
				wp_dequeue_style( $handle );
				wp_deregister_style( $handle );
			}
		}
	}

	if ( $wp_scripts instanceof WP_Scripts ) {
		foreach ( array_keys( $wp_scripts->registered ) as $handle ) {
			$src = (string) ( $wp_scripts->registered[ $handle ]->src ?? '' );
			if (
				false !== stripos( $handle, 'elementor' )
				|| false !== stripos( $src, '/elementor/' )
				|| false !== stripos( $src, 'elementor/assets' )
			) {
				wp_dequeue_script( $handle );
				wp_deregister_script( $handle );
			}
		}
	}

	foreach ( array( 'elementor-icons-shared-0', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular', 'elementor-icons-fa-brands', 'swiper', 'e-swiper' ) as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
		wp_dequeue_script( $handle );
		wp_deregister_script( $handle );
	}
}

/**
 * Whether current view is a PHP custom-UI page that should not load Elementor.
 *
 * @return bool
 */
function xe36_should_strip_elementor_assets() {
	if ( function_exists( 'xe36_is_custom_ui' ) && xe36_is_custom_ui() ) {
		return true;
	}
	return false;
}

/**
 * Strip Elementor assets on custom UI views (homepage + landings).
 */
function xe36_performance_dequeue_elementor() {
	if ( ! xe36_should_strip_elementor_assets() ) {
		return;
	}
	xe36_dequeue_elementor_assets();
}
add_action( 'wp_enqueue_scripts', 'xe36_performance_dequeue_elementor', 100 );

/**
 * Prefer defer for theme scripts (WP 6.3+ strategy).
 */
function xe36_performance_defer_scripts() {
	$handles = array(
		'xe36-header',
		'xe36-gallery-carousel',
		'xe36-readmore',
		'xe36-contact',
		'xe36-booking',
		'xe36-youtube-facade',
	);

	foreach ( $handles as $handle ) {
		if ( wp_script_is( $handle, 'registered' ) || wp_script_is( $handle, 'enqueued' ) ) {
			wp_script_add_data( $handle, 'strategy', 'defer' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'xe36_performance_defer_scripts', 999 );

/**
 * Resolve homepage hero attachment ID for LCP preload.
 *
 * @return int
 */
function xe36_homepage_hero_image_id() {
	if ( ! function_exists( 'xe36_get_homepage_field' ) ) {
		return 0;
	}

	$hero = xe36_get_homepage_field( 'hero_image', null );
	if ( is_array( $hero ) && ! empty( $hero['ID'] ) ) {
		return (int) $hero['ID'];
	}
	if ( is_array( $hero ) && ! empty( $hero['id'] ) ) {
		return (int) $hero['id'];
	}
	if ( is_numeric( $hero ) ) {
		return (int) $hero;
	}
	return 0;
}

/**
 * Preload LCP hero — smaller file for mobile, larger for desktop.
 */
function xe36_performance_preload_hero() {
	if ( ! is_front_page() ) {
		return;
	}

	$id = xe36_homepage_hero_image_id();
	if ( $id <= 0 ) {
		return;
	}

	$mobile = wp_get_attachment_image_src( $id, 'medium_large' );
	if ( ! is_array( $mobile ) || empty( $mobile[0] ) ) {
		$mobile = wp_get_attachment_image_src( $id, 'large' );
	}
	$desktop = wp_get_attachment_image_src( $id, 'large' );
	if ( ! is_array( $desktop ) || empty( $desktop[0] ) ) {
		$desktop = wp_get_attachment_image_src( $id, 'full' );
	}

	if ( is_array( $mobile ) && ! empty( $mobile[0] ) ) {
		echo '<link rel="preload" as="image" href="' . esc_url( $mobile[0] ) . '" media="(max-width: 768px)" fetchpriority="high">' . "\n";
	}
	if ( is_array( $desktop ) && ! empty( $desktop[0] ) ) {
		$srcset = wp_get_attachment_image_srcset( $id, 'large' );
		echo '<link rel="preload" as="image" href="' . esc_url( $desktop[0] ) . '" media="(min-width: 769px)"';
		if ( $srcset ) {
			echo ' imagesrcset="' . esc_attr( $srcset ) . '" imagesizes="100vw"';
		}
		echo ' fetchpriority="high">' . "\n";
	}
}
add_action( 'wp_head', 'xe36_performance_preload_hero', 2 );

/**
 * Load non-critical CSS without blocking first paint (mobile FCP).
 *
 * @param string $html   Link tag.
 * @param string $handle Style handle.
 * @return string
 */
function xe36_performance_async_styles( $html, $handle ) {
	$async = array(
		'xe36-homepage',
		'xe36-footer',
		'xe36-floating-bar',
		'xe36-booking',
		'xe36-readmore',
		'xe36-vanphong',
	);

	if ( ! in_array( $handle, $async, true ) || false !== strpos( $html, 'onload=' ) ) {
		return $html;
	}

	$async_html = preg_replace(
		'/\smedia=(["\'])all\1/i',
		' media="print" onload="this.media=\'all\'"',
		$html,
		1
	);

	if ( $async_html === $html ) {
		$async_html = str_replace( '/>', ' media="print" onload="this.media=\'all\'" />', $html );
	}

	$noscript = preg_replace( '/\smedia="print" onload="this\.media=\'all\'"/', '', $async_html );
	return $async_html . '<noscript>' . $noscript . '</noscript>';
}
add_filter( 'style_loader_tag', 'xe36_performance_async_styles', 10, 2 );

/**
 * Strip emoji / embed / unused block CSS on custom UI (mobile main-thread).
 */
function xe36_performance_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'xe36_performance_disable_emoji', 20 );

/**
 * Dequeue bloat assets on front-end custom UI pages.
 */
function xe36_performance_dequeue_bloat() {
	wp_deregister_script( 'wp-embed' );

	if ( function_exists( 'xe36_is_custom_ui' ) && xe36_is_custom_ui() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'xe36_performance_dequeue_bloat', 100 );

/**
 * Resource hints for third parties loaded after idle.
 */
function xe36_performance_resource_hints( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = '//www.googletagmanager.com';
		$urls[] = '//www.youtube.com';
		$urls[] = '//i.ytimg.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'xe36_performance_resource_hints', 10, 2 );
