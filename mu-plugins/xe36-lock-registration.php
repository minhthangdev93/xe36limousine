<?php
/**
 * Plugin Name: Xe 36 — Lock registration & spam mail
 * Description: Must-use: tắt đăng ký công khai + chặn email “Thông tin đăng nhập” (bảo vệ SMTP Gmail).
 * Version: 1.0.0
 *
 * @package Xe36
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'pre_option_users_can_register', static function () {
	return '0';
} );

add_filter( 'option_users_can_register', '__return_false' );

add_filter( 'wp_send_new_user_notification_to_user', '__return_false' );
add_filter( 'wp_send_new_user_notification_to_admin', '__return_false' );

add_filter( 'pre_wp_mail', static function ( $return, $atts ) {
	if ( null !== $return ) {
		return $return;
	}
	$subject = isset( $atts['subject'] ) ? (string) $atts['subject'] : '';
	$body    = isset( $atts['message'] ) ? (string) $atts['message'] : '';
	$hay     = $subject . "\n" . $body;
	if ( preg_match( '/thông tin đăng nhập|login details|new user registration|mật khẩu của bạn|bank reject payment|\.craftum\.io/iu', $hay ) ) {
		return false;
	}
	return $return;
}, 1, 2 );

add_action(
	'login_init',
	static function () {
		$action = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'register' === $action ) {
			wp_safe_redirect( home_url( '/' ), 302 );
			exit;
		}
	},
	0
);

add_action(
	'init',
	static function () {
		if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
			status_header( 403 );
			exit;
		}
		remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
		remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications' );
	},
	0
);

add_filter(
	'wp_pre_insert_user_data',
	static function ( $data, $update ) {
		if ( $update ) {
			return $data;
		}
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			return $data;
		}
		if ( is_admin() && current_user_can( 'manage_options' ) ) {
			return $data;
		}
		$data['user_login'] = '';
		$data['user_email'] = '';
		$data['user_pass']  = '';
		return $data;
	},
	1,
	2
);
