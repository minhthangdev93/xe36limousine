<?php
/**
 * AJAX handler for [booking_form].
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

require_once xe36_theme_path( 'inc/booking/routes.php' );
require_once xe36_theme_path( 'inc/booking/partials/email.php' );

/**
 * Handle booking form submission.
 */
function xe36_handle_ajax_booking_form() {
	$route           = sanitize_text_field( wp_unslash( $_POST['route'] ?? '' ) );
	$date            = sanitize_text_field( wp_unslash( $_POST['date'] ?? '' ) );
	$time            = sanitize_text_field( wp_unslash( $_POST['time'] ?? '' ) );
	$seat            = sanitize_text_field( wp_unslash( $_POST['seat'] ?? '' ) );
	$ticket_quantity = intval( $_POST['ticket_quantity'] ?? 0 );
	$name            = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$country_code    = sanitize_text_field( wp_unslash( $_POST['country_code'] ?? '' ) );
	$phone           = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );

	$routes     = xe36_booking_routes();
	$seat_types = xe36_booking_seat_types();

	if ( '' === $route || ! isset( $routes[ $route ] ) ) {
		echo '<p class="xe36-booking-response xe36-booking-response--error">Vui lòng chọn tuyến hợp lệ.</p>';
		wp_die();
	}

	if ( '' === $seat || ! isset( $seat_types[ $seat ] ) ) {
		echo '<p class="xe36-booking-response xe36-booking-response--error">Vui lòng chọn ghế muốn ngồi.</p>';
		wp_die();
	}

	if ( '' === $name || '' === $phone || '' === $date || '' === $time || $ticket_quantity < 1 ) {
		echo '<p class="xe36-booking-response xe36-booking-response--error">Vui lòng điền đầy đủ thông tin.</p>';
		wp_die();
	}

	$route_label = xe36_booking_route_label( $route );
	$seat_label  = xe36_booking_seat_option_label( $seat, $route );
	// Form đặt vé / liên hệ chỉ gửi tới mailbox booking (không dùng footer_email).
	$to = 'booking.36limousine@gmail.com';
	$subject     = sprintf(
		'[Yêu cầu đặt vé] %s — %s — %s %s — %d vé',
		$name,
		$route_label,
		$date,
		$time,
		$ticket_quantity
	);

	$message = xe36_booking_email_html(
		array(
			'route'        => $route_label,
			'date'         => $date,
			'time'         => $time,
			'seat'         => $seat_label,
			'quantity'     => (string) $ticket_quantity,
			'name'         => $name,
			'country_code' => $country_code,
			'phone'        => $phone,
		)
	);

	$headers = array( 'Content-Type: text/html; charset=UTF-8' );

	$success_text = xe36_get_homepage_field(
		'booking_success_text',
		'Cảm ơn bạn đã đặt vé! Yêu cầu của bạn đã được gửi thành công.'
	);

	if ( wp_mail( $to, $subject, $message, $headers ) ) {
		echo '<p class="xe36-booking-response xe36-booking-response--success">' . esc_html( $success_text ) . '</p>';
	} else {
		echo '<p class="xe36-booking-response xe36-booking-response--error">Đã có lỗi xảy ra. Vui lòng thử lại.</p>';
	}

	wp_die();
}
add_action( 'wp_ajax_submit_booking_form', 'xe36_handle_ajax_booking_form' );
add_action( 'wp_ajax_nopriv_submit_booking_form', 'xe36_handle_ajax_booking_form' );
