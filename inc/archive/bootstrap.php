<?php
/**
 * Blog / archive helpers and assets.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether current view is a post archive we restyle.
 *
 * @return bool
 */
function xe36_is_blog_archive() {
	if ( is_admin() ) {
		return false;
	}

	if ( is_home() && ! is_front_page() ) {
		return true;
	}

	if ( is_category() || is_tag() || is_author() || is_date() ) {
		return true;
	}

	if ( is_post_type_archive( 'post' ) ) {
		return true;
	}

	return false;
}

/**
 * Opt blog archives into custom UI shell.
 *
 * @param bool $is_custom Current flag.
 * @return bool
 */
function xe36_archive_is_custom_ui( $is_custom ) {
	return $is_custom || xe36_is_blog_archive();
}
add_filter( 'xe36_is_custom_ui', 'xe36_archive_is_custom_ui' );

/**
 * Archive hero eyebrow label.
 *
 * @return string
 */
function xe36_archive_eyebrow() {
	if ( is_category() ) {
		return 'Chuyên mục';
	}
	if ( is_tag() ) {
		return 'Thẻ';
	}
	if ( is_author() ) {
		return 'Tác giả';
	}
	if ( is_date() ) {
		return 'Theo thời gian';
	}
	if ( is_home() ) {
		return 'Blog';
	}
	return 'Lưu trữ';
}

/**
 * Archive page title.
 *
 * @return string
 */
function xe36_archive_title() {
	if ( is_home() && ! is_front_page() ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		if ( $posts_page_id > 0 ) {
			$title = get_the_title( $posts_page_id );
			if ( is_string( $title ) && '' !== trim( $title ) ) {
				return $title;
			}
		}
		return 'Tin tức';
	}

	if ( is_category() ) {
		return single_cat_title( '', false );
	}

	if ( is_tag() ) {
		return single_tag_title( '', false );
	}

	if ( is_author() ) {
		return get_the_author();
	}

	$title = get_the_archive_title();
	$title = preg_replace( '/^[^:]+:\s*/u', '', wp_strip_all_tags( (string) $title ) );
	return is_string( $title ) && '' !== trim( $title ) ? $title : 'Tin tức';
}

/**
 * Archive description / lead text.
 *
 * @return string
 */
function xe36_archive_description() {
	if ( is_home() && ! is_front_page() ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		if ( $posts_page_id > 0 ) {
			$excerpt = get_post_field( 'post_excerpt', $posts_page_id );
			if ( is_string( $excerpt ) && '' !== trim( $excerpt ) ) {
				return $excerpt;
			}
		}
		return 'Cập nhật tin tức, hướng dẫn và thông tin dịch vụ Xe 36 Limousine.';
	}

	$desc = get_the_archive_description();
	$desc = trim( wp_strip_all_tags( (string) $desc ) );
	if ( '' !== $desc ) {
		return $desc;
	}

	if ( is_category( 'tin-tuc' ) ) {
		return 'Tin tức mới nhất về tuyến Limousine Hà Nội – Thanh Hóa và dịch vụ Xe 36.';
	}

	if ( is_category( 'dich-vu' ) ) {
		return 'Các dịch vụ vận chuyển hành khách, hàng hóa và thuê xe của Xe 36 Limousine.';
	}

	return '';
}

/**
 * Enqueue archive assets.
 */
function xe36_enqueue_archive_assets() {
	if ( ! xe36_is_blog_archive() ) {
		return;
	}

	wp_enqueue_style(
		'xe36-archive',
		xe36_theme_uri( 'assets/css/archive.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		xe36_theme_version()
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_archive_assets', 30 );
