<?php
/**
 * Contact page helpers, assets, and AJAX.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether current request is the contact page.
 *
 * @return bool
 */
function xe36_is_contact_page() {
	if ( ! is_singular() ) {
		return false;
	}

	$page_id = (int) get_queried_object_id();
	if ( $page_id <= 0 ) {
		return false;
	}

	$slug = get_page_template_slug( $page_id );
	if ( 'page-templates/contact.php' === $slug ) {
		return true;
	}

	$post = get_post( $page_id );
	return $post && 'lien-he' === $post->post_name;
}

/**
 * Opt contact page into custom UI shell.
 *
 * @param bool $is_custom Current flag.
 * @return bool
 */
function xe36_contact_is_custom_ui( $is_custom ) {
	return $is_custom || xe36_is_contact_page();
}
add_filter( 'xe36_is_custom_ui', 'xe36_contact_is_custom_ui' );

/**
 * Default contact page content.
 *
 * @return array<string, mixed>
 */
function xe36_contact_defaults() {
	return array(
		'contact_hero_eyebrow'  => 'Liên hệ',
		'contact_hero_title'    => 'Liên hệ Xe 36 Limousine',
		'contact_hero_text'     => 'Gửi yêu cầu đặt vé, gửi hàng hoặc thuê xe — chúng tôi phản hồi nhanh qua điện thoại, Zalo hoặc email.',
		'contact_form_title'    => 'Gửi tin nhắn',
		'contact_form_lead'     => 'Điền thông tin bên dưới, bộ phận CSKH sẽ liên hệ lại sớm nhất.',
		'contact_info_title'    => 'Thông tin liên hệ',
		'contact_success_text'  => 'Cảm ơn bạn! Tin nhắn đã được gửi thành công. Chúng tôi sẽ liên hệ lại sớm.',
		'contact_offices_title' => 'Hệ thống văn phòng',
		'contact_cta_btn_text'  => 'Gửi liên hệ',
	);
}

/**
 * Get contact field with ACF fallback.
 *
 * @param string $name    Field name.
 * @param mixed  $default Default override.
 * @return mixed
 */
function xe36_get_contact_field( $name, $default = null ) {
	$defaults = xe36_contact_defaults();
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
 * Enqueue contact page assets.
 */
function xe36_enqueue_contact_assets() {
	if ( ! xe36_is_contact_page() ) {
		return;
	}

	if ( function_exists( 'xe36_enqueue_vanphong_assets' ) ) {
		xe36_enqueue_vanphong_assets();
	}

	$version = xe36_theme_version();

	wp_enqueue_style(
		'xe36-contact',
		xe36_theme_uri( 'assets/css/contact.css' ),
		array( 'xe36-variables', 'xe36-components', 'xe36-custom-ui' ),
		$version
	);

	wp_enqueue_script(
		'xe36-contact',
		xe36_theme_uri( 'assets/js/contact.js' ),
		array(),
		$version,
		true
	);

	wp_localize_script(
		'xe36-contact',
		'xe36Contact',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'xe36_contact_form' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'xe36_enqueue_contact_assets', 30 );

/**
 * Disable Elementor on contact page.
 */
function xe36_contact_disable_elementor() {
	if ( ! xe36_is_contact_page() ) {
		return;
	}

	add_filter( 'elementor/frontend/builder_content_data', 'xe36_contact_strip_elementor', 10, 2 );
	add_filter( 'elementor/theme/do_location', 'xe36_contact_skip_elementor_locations', 10, 2 );
	add_action( 'wp_enqueue_scripts', 'xe36_contact_dequeue_elementor_assets', 100 );
}
add_action( 'wp', 'xe36_contact_disable_elementor' );

/**
 * Strip Elementor builder output.
 *
 * @param array $data    Builder data.
 * @param int   $post_id Post ID.
 * @return array
 */
function xe36_contact_strip_elementor( $data, $post_id ) {
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
function xe36_contact_skip_elementor_locations( $do_location, $location ) {
	unset( $location );
	return false;
}

/**
 * Dequeue Elementor assets.
 */
function xe36_contact_dequeue_elementor_assets() {
	if ( ! xe36_is_contact_page() ) {
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
 * Force contact template for lien-he slug.
 *
 * @param string $template Template path.
 * @return string
 */
function xe36_contact_template_include( $template ) {
	if ( ! is_singular() ) {
		return $template;
	}

	$post = get_queried_object();
	if ( ! $post || 'lien-he' !== $post->post_name ) {
		return $template;
	}

	$custom = locate_template( 'page-templates/contact.php' );
	return $custom ? $custom : $template;
}
add_filter( 'template_include', 'xe36_contact_template_include', 99 );

/**
 * Handle contact form AJAX submission.
 */
function xe36_handle_ajax_contact_form() {
	check_ajax_referer( 'xe36_contact_form', 'nonce' );

	// Honeypot.
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success(
			array(
				'message' => xe36_contact_defaults()['contact_success_text'],
			)
		);
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['subject'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( '' === $name || '' === $phone || '' === $message ) {
		wp_send_json_error(
			array(
				'message' => 'Vui lòng điền họ tên, số điện thoại và nội dung tin nhắn.',
			)
		);
	}

	if ( '' !== $email && ! is_email( $email ) ) {
		wp_send_json_error(
			array(
				'message' => 'Email không hợp lệ.',
			)
		);
	}

	$to = xe36_get_site_field( 'booking_email', 'booking.36limousine@gmail.com' );
	if ( ! is_string( $to ) || '' === trim( $to ) ) {
		$to = 'booking.36limousine@gmail.com';
	}

	$mail_subject = sprintf(
		'[Liên hệ website] %s%s',
		$name,
		'' !== $subject ? ' — ' . $subject : ''
	);

	$body_lines = array(
		'Họ tên: ' . $name,
		'Số điện thoại: ' . $phone,
		'Email: ' . ( '' !== $email ? $email : '(không có)' ),
		'Chủ đề: ' . ( '' !== $subject ? $subject : '(không có)' ),
		'',
		'Nội dung:',
		$message,
	);

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( '' !== $email ) {
		$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	}

	$success = xe36_contact_defaults()['contact_success_text'];
	if ( function_exists( 'get_field' ) ) {
		$saved = get_field( 'contact_success_text', 135 );
		if ( is_string( $saved ) && '' !== trim( $saved ) ) {
			$success = $saved;
		}
	}

	if ( wp_mail( $to, $mail_subject, implode( "\n", $body_lines ), $headers ) ) {
		wp_send_json_success(
			array(
				'message' => $success,
			)
		);
	}

	wp_send_json_error(
		array(
			'message' => 'Không gửi được tin nhắn. Vui lòng gọi hotline hoặc thử lại sau.',
		)
	);
}
add_action( 'wp_ajax_submit_contact_form', 'xe36_handle_ajax_contact_form' );
add_action( 'wp_ajax_nopriv_submit_contact_form', 'xe36_handle_ajax_contact_form' );
