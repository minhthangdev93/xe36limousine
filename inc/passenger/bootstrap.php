<?php
/**
 * Passenger service page helpers and assets.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether current request is the passenger service page.
 *
 * @return bool
 */
function xe36_is_passenger_page() {
	if ( ! is_singular() ) {
		return false;
	}

	$page_id = (int) get_queried_object_id();
	if ( $page_id <= 0 ) {
		return false;
	}

	$slug = get_page_template_slug( $page_id );
	if ( 'page-templates/passenger.php' === $slug ) {
		return true;
	}

	$post = get_post( $page_id );
	return $post && 'van-chuyen-hanh-khach' === $post->post_name;
}

/**
 * Opt passenger page into custom UI shell.
 *
 * @param bool $is_custom Current flag.
 * @return bool
 */
function xe36_passenger_is_custom_ui( $is_custom ) {
	return $is_custom || xe36_is_passenger_page();
}
add_filter( 'xe36_is_custom_ui', 'xe36_passenger_is_custom_ui' );

/**
 * Default passenger page content.
 *
 * @return array<string, mixed>
 */
function xe36_passenger_defaults() {
	$uploads = content_url( 'uploads' );

	return array(
		'pax_hero_eyebrow'   => 'Dịch vụ',
		'pax_hero_title'     => 'Vận chuyển hành khách',
		'pax_hero_text'      => 'Xe Limousine VIP 11 chỗ tuyến Hà Nội – Thanh Hóa – Sầm Sơn – Hải Tiến. Đưa đón tận nơi, không bắt khách dọc đường.',
		'pax_hero_cta_text'  => 'Đặt vé ngay',
		'pax_hero_cta_url'   => home_url( '/#home-booking' ),
		'pax_hero_image'     => $uploads . '/2022/12/limousine-thanh-hoa-ha-noi.jpg',
		'pax_pricing_title'  => 'Bảng giá dịch vụ Xe 36 Limousine 11 chỗ tuyến Thanh Hóa - Hà Nội',
		'pax_pricing_image'  => $uploads . '/2026/07/bao-gia-limousine-ha-noi-thanh-hoa.jpg',
		'pax_intro_title'    => 'Tuyến trọng điểm Hà Nội ⇔ Thanh Hóa',
		'pax_intro_text'     => "Xe 36 Limousine tuyến Thanh Hóa - Hà Nội là tuyến trọng điểm Công ty đưa vào khai thác kết hợp phục vụ nhu cầu đi lại của người dân địa phương, khách đi công việc hay tham quan du lịch giữa Thanh Hóa và Hà Nội.\n\nVới dòng xe Limousine VIP 11 chỗ đẳng cấp bản thương gia trên tuyến Thanh Hóa - Hà Nội được đưa vào khai thác cùng với chất lượng phục vụ chuyên nghiệp, Xe 36 Limousine cam kết đem đến cho Khách hàng dịch vụ tốt nhất, mang đến sự tiện lợi và thoải mái cho chuyến đi của Quý khách.",
		'pax_intro_image'    => $uploads . '/2022/12/limousine-thanh-hoa-ha-noi.jpg',
		'pax_features_title' => 'Tiêu chuẩn vàng dịch vụ Limousine',
		'pax_features_lead'  => 'Lựa chọn đặt xe của chúng tôi, Quý khách hàng sẽ được trải nghiệm những dịch vụ tốt nhất:',
		'pax_features'       => "Limousine VIP 11 chỗ|Xe Limousine VIP 11 chỗ đẳng cấp 5 sao\nNội thất sang trọng|Nội thất tiện nghi, sang trọng\nĐưa đón tận nơi|Xe đưa đón khách tận nơi trong nội thành Hà Nội và Thanh Hóa\nĐúng số ghế|Không bắt khách dọc đường, ngồi đúng số ghế\nMiễn phí tiện ích|Miễn phí khăn lạnh, nước uống\nTiện nghi đầy đủ|Wifi 4G, ổ sạc, tivi màn hình LED, hệ thống âm thanh sống động\nGiá ổn định|Không đội giá, tăng giá ngày lễ tết\nCSKH chuyên nghiệp|Dịch vụ tư vấn và CSKH nhiệt tình, chuyên nghiệp\nTài xế giàu kinh nghiệm|Đội ngũ lái xe được đào tạo chuyên nghiệp, luôn đặt an toàn lên hàng đầu\nHành lý miễn phí|Miễn phí hành lý xách tay dưới 10kg, kích thước không quá 60×40×25cm",
		'pax_offices_title'  => 'Danh sách văn phòng & tổng đài đặt vé Limousine Hà Nội ⇔ Thanh Hóa',
		'pax_cta_title'      => 'Đặt vé Limousine Hà Nội – Thanh Hóa',
		'pax_cta_text'       => 'Tổng đài hỗ trợ 24/7 — đặt vé nhanh qua điện thoại, Zalo hoặc form trên website.',
		'pax_cta_btn_text'   => 'Đặt vé ngay',
		'pax_cta_btn_url'    => home_url( '/#home-booking' ),
	);
}

/**
 * Get passenger field with ACF fallback.
 *
 * @param string $name    Field name.
 * @param mixed  $default Default override.
 * @return mixed
 */
function xe36_get_passenger_field( $name, $default = null ) {
	$defaults = xe36_passenger_defaults();
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
function xe36_passenger_parse_pairs( $raw ) {
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
 * Resolve ACF image field to URL.
 *
 * @param mixed $image Field value.
 * @return string
 */
function xe36_passenger_image_url( $image ) {
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
 * Enqueue passenger page assets.
 */
function xe36_enqueue_passenger_assets() {
	if ( ! xe36_is_passenger_page() ) {
		return;
	}

	if ( function_exists( 'xe36_enqueue_vanphong_assets' ) ) {
		xe36_enqueue_vanphong_assets();
	}

	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-passenger',
		xe36_theme_uri( 'assets/css/passenger.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		$version
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_passenger_assets', 30 );

/**
 * Disable Elementor on passenger page.
 */
function xe36_passenger_disable_elementor() {
	if ( ! xe36_is_passenger_page() ) {
		return;
	}

	add_filter( 'elementor/frontend/builder_content_data', 'xe36_passenger_strip_elementor', 10, 2 );
	add_filter( 'elementor/theme/do_location', 'xe36_passenger_skip_elementor_locations', 10, 2 );
	add_action( 'wp_enqueue_scripts', 'xe36_passenger_dequeue_elementor_assets', 100 );
}
add_action( 'wp', 'xe36_passenger_disable_elementor' );

/**
 * Strip Elementor builder output.
 *
 * @param array $data    Builder data.
 * @param int   $post_id Post ID.
 * @return array
 */
function xe36_passenger_strip_elementor( $data, $post_id ) {
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
function xe36_passenger_skip_elementor_locations( $do_location, $location ) {
	unset( $location );
	return false;
}

/**
 * Dequeue Elementor assets.
 */
function xe36_passenger_dequeue_elementor_assets() {
	if ( ! xe36_is_passenger_page() ) {
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
 * Force passenger template for van-chuyen-hanh-khach slug.
 *
 * @param string $template Template path.
 * @return string
 */
function xe36_passenger_template_include( $template ) {
	if ( ! is_singular() ) {
		return $template;
	}

	$post = get_queried_object();
	if ( ! $post || 'van-chuyen-hanh-khach' !== $post->post_name ) {
		return $template;
	}

	$custom = locate_template( 'page-templates/passenger.php' );
	return $custom ? $custom : $template;
}
add_filter( 'template_include', 'xe36_passenger_template_include', 99 );
