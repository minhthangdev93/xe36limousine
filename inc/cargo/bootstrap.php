<?php
/**
 * Cargo service page helpers and assets.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether current request is the cargo service page.
 *
 * @return bool
 */
function xe36_is_cargo_page() {
	if ( ! is_singular() ) {
		return false;
	}

	$page_id = (int) get_queried_object_id();
	if ( $page_id <= 0 ) {
		return false;
	}

	$slug = get_page_template_slug( $page_id );
	if ( 'page-templates/cargo.php' === $slug ) {
		return true;
	}

	$post = get_post( $page_id );
	return $post && 'van-chuyen-hang-hoa' === $post->post_name;
}

/**
 * Opt cargo page into custom UI shell.
 *
 * @param bool $is_custom Current flag.
 * @return bool
 */
function xe36_cargo_is_custom_ui( $is_custom ) {
	return $is_custom || xe36_is_cargo_page();
}
add_filter( 'xe36_is_custom_ui', 'xe36_cargo_is_custom_ui' );

/**
 * Default cargo page content.
 *
 * @return array<string, mixed>
 */
function xe36_cargo_defaults() {
	$uploads = content_url( 'uploads' );

	return array(
		'cargo_hero_eyebrow'   => 'Dịch vụ',
		'cargo_hero_title'     => 'Vận chuyển hàng hóa',
		'cargo_hero_text'      => 'Chuyến phát nhanh siêu tốc bằng xe Limousine cao cấp — nhận hàng sau 3 giờ, bảo quản cẩn thận, giá ưu đãi tới 50%.',
		'cargo_hero_cta_text'  => 'Gửi hàng ngay',
		'cargo_hero_cta_url'   => home_url( '/lien-he/' ),
		'cargo_hero_image'     => $uploads . '/2022/12/van-chuyen-hang-hoa-thanh-hoa.jpg',
		'cargo_pricing_title'  => 'Bảng giá vận chuyển hàng hóa',
		'cargo_pricing_images' => $uploads . "/2022/12/gui-hang-hoa-2.jpg\n" . $uploads . '/2022/12/gui-hang-hoa-1.jpg',
		'cargo_intro_title'    => 'Chuyến phát nhanh siêu tốc — siêu rẻ',
		'cargo_intro_text'     => "Để đáp ứng nhu cầu vận chuyển hàng hóa, 36 Travel cung cấp dịch vụ chuyển phát nhanh siêu tốc bằng xe Limousine cao cấp. Cam kết bưu kiện được bảo quản và xếp ngay ngắn trong suốt quá trình vận chuyển.\n\nGiảm tới 50% chi phí vận chuyển cho tất cả mặt hàng. Giao hàng nhanh chóng, chuyển phát tận nơi, nhận thu COD, hỗ trợ tư vấn 24/7.",
		'cargo_intro_image'    => $uploads . '/2022/12/van-chuyen-hang-hoa-thanh-hoa.jpg',
		'cargo_features_title' => 'Cam kết dịch vụ gửi hàng',
		'cargo_features_lead'  => 'Đừng bỏ lỡ cơ hội trải nghiệm dịch vụ gửi hàng chất lượng:',
		'cargo_features'       => "Siêu tốc 3 giờ|Dịch vụ vận chuyển nhanh siêu tốc — nhận hàng sau 3 giờ gửi\nAn toàn hàng hóa|Hàng hóa không bị bóp méo, rơi vỡ trong quá trình vận chuyển\nKhông chuyển tuyến|Vận chuyển siêu tốc không cần làm thủ tục hay chuyển tuyến khác\nGiao tận nơi|Giao hàng nhanh chóng, chuyển phát tận nơi\nKhông thất lạc|Hàng vận chuyển không lo mất, hư hỏng, thất lạc\nCước phí tiết kiệm|Cước phí tiết kiệm nhất — ưu đãi giảm tới 50%\nCSKH 24/7|Chăm sóc tư vấn 24/7 qua hotline 1900 888 999\nNhận thu COD|Hỗ trợ nhận thu COD theo yêu cầu khách hàng",
		'cargo_offices_title'  => 'Hệ thống văn phòng nhận và trả hàng',
		'cargo_cta_title'      => 'Gửi hàng Hà Nội – Thanh Hóa ngay hôm nay',
		'cargo_cta_text'       => 'Liên hệ tổng đài 24/7 để được tư vấn bảng giá và lịch nhận hàng.',
		'cargo_cta_btn_text'   => 'Liên hệ gửi hàng',
		'cargo_cta_btn_url'    => home_url( '/lien-he/' ),
	);
}

/**
 * Get cargo field with ACF fallback.
 *
 * @param string $name    Field name.
 * @param mixed  $default Default override.
 * @return mixed
 */
function xe36_get_cargo_field( $name, $default = null ) {
	$defaults = xe36_cargo_defaults();
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
function xe36_cargo_parse_pairs( $raw ) {
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
 * Parse image URL lines.
 *
 * @param string $raw Raw textarea.
 * @return array<int, string>
 */
function xe36_cargo_parse_images( $raw ) {
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
 * Resolve ACF image field to URL.
 *
 * @param mixed $image Field value.
 * @return string
 */
function xe36_cargo_image_url( $image ) {
	if ( is_array( $image ) && ! empty( $image['url'] ) ) {
		return (string) $image['url'];
	}
	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, 'large' );
		return $url ? $url : '';
	}
	return is_string( $image ) ? $image : '';
}

/**
 * Enqueue cargo page assets.
 */
function xe36_enqueue_cargo_assets() {
	if ( ! xe36_is_cargo_page() ) {
		return;
	}

	if ( function_exists( 'xe36_enqueue_vanphong_assets' ) ) {
		xe36_enqueue_vanphong_assets();
	}

	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-cargo',
		xe36_theme_uri( 'assets/css/cargo.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		$version
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_cargo_assets', 30 );

/**
 * Disable Elementor on cargo page.
 */
function xe36_cargo_disable_elementor() {
	if ( ! xe36_is_cargo_page() ) {
		return;
	}

	add_filter( 'elementor/frontend/builder_content_data', 'xe36_cargo_strip_elementor', 10, 2 );
	add_filter( 'elementor/theme/do_location', 'xe36_cargo_skip_elementor_locations', 10, 2 );
	add_action( 'wp_enqueue_scripts', 'xe36_cargo_dequeue_elementor_assets', 100 );
}
add_action( 'wp', 'xe36_cargo_disable_elementor' );

/**
 * Strip Elementor builder output.
 *
 * @param array $data    Builder data.
 * @param int   $post_id Post ID.
 * @return array
 */
function xe36_cargo_strip_elementor( $data, $post_id ) {
	if ( (int) $post_id === (int) get_queried_object_id() ) {
		return array();
	}
	return $data;
}

/**
 * Skip Elementor theme locations.
 *
 * @param bool   $do_location Whether to render.
 * @param string $location    Location name.
 * @return bool
 */
function xe36_cargo_skip_elementor_locations( $do_location, $location ) {
	unset( $location );
	return false;
}

/**
 * Dequeue Elementor assets.
 */
function xe36_cargo_dequeue_elementor_assets() {
	if ( ! xe36_is_cargo_page() ) {
		return;
	}

	global $wp_styles, $wp_scripts;

	if ( $wp_styles instanceof WP_Styles ) {
		foreach ( array_keys( $wp_styles->registered ) as $handle ) {
			$src = (string) ( $wp_styles->registered[ $handle ]->src ?? '' );
			if ( false !== stripos( $handle, 'elementor' ) || false !== stripos( $src, '/elementor/' ) ) {
				wp_dequeue_style( $handle );
				wp_deregister_style( $handle );
			}
		}
	}

	if ( $wp_scripts instanceof WP_Scripts ) {
		foreach ( array_keys( $wp_scripts->registered ) as $handle ) {
			$src = (string) ( $wp_scripts->registered[ $handle ]->src ?? '' );
			if ( false !== stripos( $handle, 'elementor' ) || false !== stripos( $src, '/elementor/' ) ) {
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
 * Force cargo template for van-chuyen-hang-hoa slug.
 *
 * @param string $template Template path.
 * @return string
 */
function xe36_cargo_template_include( $template ) {
	if ( ! is_singular() ) {
		return $template;
	}

	$post = get_queried_object();
	if ( ! $post || 'van-chuyen-hang-hoa' !== $post->post_name ) {
		return $template;
	}

	$custom = locate_template( 'page-templates/cargo.php' );
	return $custom ? $custom : $template;
}
add_filter( 'template_include', 'xe36_cargo_template_include', 99 );
