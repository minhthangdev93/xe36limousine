<?php
/**
 * [booking_form] shortcode.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue booking form assets once per request.
 */
function xe36_enqueue_booking_assets() {
	static $enqueued = false;

	if ( $enqueued ) {
		return;
	}

	$enqueued = true;
	$version  = xe36_theme_version();

	require_once xe36_theme_path( 'inc/booking/countries.php' );
	require_once xe36_theme_path( 'inc/booking/routes.php' );

	wp_enqueue_style(
		'xe36-booking',
		xe36_theme_uri( 'assets/css/booking.css' ),
		array( 'xe36-variables', 'xe36-components' ),
		$version
	);

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script(
		'xe36-booking',
		xe36_theme_uri( 'assets/js/booking.js' ),
		array( 'jquery' ),
		$version,
		true
	);

	$seat_types = xe36_booking_seat_types();
	$seat_meta  = array();
	foreach ( $seat_types as $key => $label ) {
		$seat_meta[ $key ] = array(
			'label'     => $label,
			'basePrice' => xe36_booking_seat_base_prices()[ $key ],
		);
	}

	wp_localize_script(
		'xe36-booking',
		'xe36Booking',
		array(
			'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
			'countries'     => xe36_booking_countries(),
			'seats'         => $seat_meta,
			'surchargeRoutes' => array( 'hn-ss', 'ss-hn', 'hn-ht', 'ht-hn' ),
			'surcharge'     => xe36_booking_seat_surcharge(),
			'i18n'          => array(
				'sending'       => 'Đang gửi yêu cầu...',
				'phoneInvalid'  => 'Số điện thoại không hợp lệ. Vui lòng nhập 9–15 chữ số.',
				'routeRequired' => 'Vui lòng chọn tuyến.',
				'seatRequired'  => 'Vui lòng chọn ghế muốn ngồi.',
				'error'         => 'Đã xảy ra lỗi khi gửi yêu cầu. Vui lòng thử lại.',
			),
		)
	);
}

/**
 * Render booking form shortcode.
 *
 * @return string
 */
function xe36_booking_form_shortcode() {
	xe36_enqueue_booking_assets();

	ob_start();
	require xe36_theme_path( 'inc/booking/partials/form.php' );
	return ob_get_clean();
}
add_shortcode( 'booking_form', 'xe36_booking_form_shortcode' );
