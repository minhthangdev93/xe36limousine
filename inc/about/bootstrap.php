<?php
/**
 * About page helpers and assets.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether current request is the About page.
 *
 * @return bool
 */
function xe36_is_about_page() {
	if ( ! is_page() ) {
		return false;
	}

	$page_id = (int) get_queried_object_id();
	if ( $page_id <= 0 ) {
		return false;
	}

	$slug = get_page_template_slug( $page_id );
	if ( 'page-templates/about.php' === $slug ) {
		return true;
	}

	$post = get_post( $page_id );
	return $post && 'gioi-thieu' === $post->post_name;
}

/**
 * Opt About page into custom UI shell.
 *
 * @param bool $is_custom Current flag.
 * @return bool
 */
function xe36_about_is_custom_ui( $is_custom ) {
	return $is_custom || xe36_is_about_page();
}
add_filter( 'xe36_is_custom_ui', 'xe36_about_is_custom_ui' );

/**
 * Default About content (fallback when ACF empty).
 *
 * @return array<string, mixed>
 */
function xe36_about_defaults() {
	$uploads = content_url( 'uploads' );

	return array(
		'about_hero_eyebrow'   => 'Về chúng tôi',
		'about_hero_title'     => 'Giới thiệu 36 Limousine',
		'about_hero_text'      => 'Vận chuyển hành khách và hàng hóa bằng xe Limousine Dcar Solati đời mới tuyến Hà Nội – Thanh Hóa – Sầm Sơn – Hải Tiến đưa đón tận nơi.',
		'about_hero_cta_text'  => 'Đặt vé ngay',
		'about_hero_cta_url'   => home_url( '/#home-booking' ),
		'about_hero_image'     => $uploads . '/2022/12/limousine-thanh-hoa-ha-noi.jpg',
		'about_benefits_title' => 'Tại sao chọn 36 Limousine',
		'about_benefits'       => "Limousine Vip|Xe Limousine VIP 11 chỗ nội thất sang trọng\nLinh hoạt|Tần suất 1 tiếng 1 chuyến, hoạt động từ 5h sáng đến 20h tối\nTiết kiệm|Đưa đón tận nơi, tiết kiệm thời gian di chuyển\nNhanh chóng|Đặt vé nhanh chóng trong 20 giây, hỗ trợ 24/7",
		'about_services_title' => 'Dịch vụ',
		'about_services_sub'   => 'Dịch vụ nổi bật xe 36 Limousine',
		'about_services'       => "Đưa đón hành khách|Đưa đón hành khách tuyến Hà Nội - Thanh Hóa tận nơi|/van-chuyen-hanh-khach/|" . $uploads . "/2022/12/xe-limousine-ha-noi-thanh-hoa.jpg\nVận chuyển hàng hóa|Vận chuyển hàng hóa siêu tốc, nhận hàng sau 3 tiếng|/van-chuyen-hang-hoa/|" . $uploads . "/2022/12/xe-limousine-ha-noi-thanh-hoa.jpg\nThuê xe có lái|Hợp đồng cho thuê xe có lái đi công việc, đi du lịch giá tốt|/lien-he/|" . $uploads . "/2022/12/noi-that-xe-36-limousine-vip-1.jpg",
		'about_gallery_title'  => 'Hình ảnh nội thất',
		'about_gallery_text'   => 'Nội thất tiện nghi sang trọng, chỉ có tại 36 Limousine',
		'about_gallery_images' => implode(
			"\n",
			array(
				$uploads . '/2022/12/noi-that-xe-36-limousine-vip-1.jpg',
				$uploads . '/2022/12/noi-that-xe-36-limousine-vip-2.jpg',
				$uploads . '/2022/12/noi-that-xe-36-limousine-vip-3.jpg',
				$uploads . '/2022/12/noi-that-xe-36-limousine-vip-4.jpg',
				$uploads . '/2022/12/noi-that-xe-36-limousine-vip-5.jpg',
			)
		),
		'about_cta_title'      => 'Liên hệ với chúng tôi',
		'about_cta_text'       => 'Tổng đài hỗ trợ 24/7 — đặt vé nhanh qua điện thoại, Zalo hoặc form trên website.',
		'about_cta_btn_text'   => 'Gửi liên hệ',
		'about_cta_btn_url'    => home_url( '/lien-he/' ),
		'about_offices_title'  => 'Hệ thống văn phòng',
	);
}

/**
 * Get About field from page ACF with fallback.
 *
 * @param string $name    Field name.
 * @param mixed  $default Default override.
 * @return mixed
 */
function xe36_get_about_field( $name, $default = null ) {
	$defaults = xe36_about_defaults();
	if ( null === $default ) {
		$default = $defaults[ $name ] ?? null;
	}

	$page_id = (int) get_queried_object_id();
	if ( $page_id > 0 && function_exists( 'get_field' ) ) {
		$value = get_field( $name, $page_id );
		if ( ! xe36_acf_value_is_empty( $value ) ) {
			return $value;
		}
	}

	return $default;
}

/**
 * Parse Title|Text lines.
 *
 * @param string $raw Raw textarea.
 * @return array<int, array{title: string, text: string}>
 */
function xe36_about_parse_pairs( $raw ) {
	$items = array();
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $items;
	}

	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts   = array_map( 'trim', explode( '|', $line, 2 ) );
		$items[] = array(
			'title' => $parts[0],
			'text'  => $parts[1] ?? '',
		);
	}

	return $items;
}

/**
 * Parse Title|Text|URL|Image lines.
 *
 * @param string $raw Raw textarea.
 * @return array<int, array{title: string, text: string, url: string, image: string}>
 */
function xe36_about_parse_services( $raw ) {
	$items = array();
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $items;
	}

	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts   = array_map( 'trim', explode( '|', $line, 4 ) );
		$items[] = array(
			'title' => $parts[0],
			'text'  => $parts[1] ?? '',
			'url'   => $parts[2] ?? '#',
			'image' => $parts[3] ?? '',
		);
	}

	return $items;
}

/**
 * Parse image URL lines.
 *
 * @param string $raw Raw textarea.
 * @return array<int, string>
 */
function xe36_about_parse_images( $raw ) {
	$images = array();
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $images;
	}

	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$images[] = $line;
		}
	}

	return $images;
}

/**
 * Enqueue About page assets.
 */
function xe36_enqueue_about_assets() {
	if ( ! xe36_is_about_page() ) {
		return;
	}

	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-about',
		xe36_theme_uri( 'assets/css/about.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		$version
	);

	wp_enqueue_script(
		'xe36-gallery-carousel',
		xe36_theme_uri( 'assets/js/gallery-carousel.js' ),
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_about_assets', 30 );

/**
 * Disable Elementor canvas/output on About page.
 */
function xe36_about_disable_elementor() {
	if ( ! xe36_is_about_page() ) {
		return;
	}

	add_filter( 'elementor/frontend/builder_content_data', 'xe36_about_strip_elementor', 10, 2 );
	add_filter( 'elementor/theme/do_location', 'xe36_about_skip_elementor_locations', 10, 2 );
	add_action( 'wp_enqueue_scripts', 'xe36_about_dequeue_elementor_assets', 100 );
}
add_action( 'wp', 'xe36_about_disable_elementor' );

/**
 * Strip Elementor builder output on About page.
 *
 * @param array $data    Builder data.
 * @param int   $post_id Post ID.
 * @return array
 */
function xe36_about_strip_elementor( $data, $post_id ) {
	if ( (int) $post_id === (int) get_queried_object_id() ) {
		return array();
	}

	return $data;
}

/**
 * Skip Elementor theme locations on About page.
 *
 * @param bool   $do_location Whether to render.
 * @param string $location    Location name.
 * @return bool
 */
function xe36_about_skip_elementor_locations( $do_location, $location ) {
	unset( $location );
	return false;
}

/**
 * Dequeue Elementor frontend assets on About page.
 */
function xe36_about_dequeue_elementor_assets() {
	if ( ! xe36_is_about_page() ) {
		return;
	}

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

	// Elementor FA icon packs (handles may not include "elementor" in name).
	foreach ( array( 'elementor-icons-shared-0', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular', 'elementor-icons-fa-brands', 'swiper', 'e-swiper' ) as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
		wp_dequeue_script( $handle );
		wp_deregister_script( $handle );
	}
}

/**
 * Force About template for gioi-thieu slug if still on default.
 *
 * @param string $template Template path.
 * @return string
 */
function xe36_about_template_include( $template ) {
	if ( ! is_page() ) {
		return $template;
	}

	$post = get_queried_object();
	if ( ! $post || 'gioi-thieu' !== $post->post_name ) {
		return $template;
	}

	$custom = locate_template( 'page-templates/about.php' );
	return $custom ? $custom : $template;
}
add_filter( 'template_include', 'xe36_about_template_include', 99 );
