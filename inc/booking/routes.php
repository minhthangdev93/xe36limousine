<?php
/**
 * Fixed booking routes (Hà Nội ↔ Thanh Hóa / Sầm Sơn / Hải Tiến).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Route value => label map.
 *
 * @return array<string, string>
 */
function xe36_booking_routes() {
	$routes = array(
		'hn-th' => 'Hà Nội → TP Thanh Hóa',
		'th-hn' => 'TP Thanh Hóa → Hà Nội',
		'hn-ss' => 'Hà Nội → Sầm Sơn',
		'ss-hn' => 'Sầm Sơn → Hà Nội',
		'hn-ht' => 'Hà Nội → Hải Tiến',
		'ht-hn' => 'Hải Tiến → Hà Nội',
	);

	/**
	 * Filter booking route list.
	 *
	 * @param array<string, string> $routes Routes.
	 */
	return apply_filters( 'xe36_booking_routes', $routes );
}

/**
 * Resolve route label from value.
 *
 * @param string $value Route key.
 * @return string
 */
function xe36_booking_route_label( $value ) {
	$routes = xe36_booking_routes();
	return $routes[ $value ] ?? $value;
}

/**
 * Whether route adds Sầm Sơn / Hải Tiến surcharge (+50.000đ).
 *
 * @param string $route Route key.
 * @return bool
 */
function xe36_booking_route_has_seat_surcharge( $route ) {
	return in_array( $route, array( 'hn-ss', 'ss-hn', 'hn-ht', 'ht-hn' ), true );
}

/**
 * Seat type value => base label (without price).
 *
 * @return array<string, string>
 */
function xe36_booking_seat_types() {
	return array(
		'front'  => 'Ghế đầu',
		'middle' => 'Ghế giữa',
		'back'   => 'Ghế cuối',
	);
}

/**
 * Base seat prices (Hà Nội ↔ TP Thanh Hóa). Editable in admin.
 *
 * @return array<string, int>
 */
function xe36_booking_seat_base_prices() {
	$defaults = array(
		'front'  => 260000,
		'middle' => 280000,
		'back'   => 260000,
	);

	$prices = array(
		'front'  => (int) xe36_get_homepage_field( 'booking_price_front', $defaults['front'] ),
		'middle' => (int) xe36_get_homepage_field( 'booking_price_middle', $defaults['middle'] ),
		'back'   => (int) xe36_get_homepage_field( 'booking_price_back', $defaults['back'] ),
	);

	foreach ( $prices as $key => $value ) {
		if ( $value < 0 ) {
			$prices[ $key ] = $defaults[ $key ];
		}
	}

	/**
	 * Filter base seat prices.
	 *
	 * @param array<string, int> $prices Prices.
	 */
	return apply_filters( 'xe36_booking_seat_base_prices', $prices );
}

/**
 * Extra fee for Sầm Sơn / Hải Tiến routes. Editable in admin.
 *
 * @return int
 */
function xe36_booking_seat_surcharge() {
	$default = 50000;
	$value   = (int) xe36_get_homepage_field( 'booking_price_surcharge', $default );
	if ( $value < 0 ) {
		$value = $default;
	}

	/**
	 * Filter route surcharge amount.
	 *
	 * @param int $value Surcharge in VND.
	 */
	return (int) apply_filters( 'xe36_booking_seat_surcharge', $value );
}

/**
 * Seat unit price for a route (VND).
 *
 * @param string $seat  Seat key.
 * @param string $route Route key.
 * @return int
 */
function xe36_booking_seat_price( $seat, $route ) {
	$bases = xe36_booking_seat_base_prices();
	if ( ! isset( $bases[ $seat ] ) ) {
		return 0;
	}

	$price = (int) $bases[ $seat ];
	if ( xe36_booking_route_has_seat_surcharge( $route ) ) {
		$price += xe36_booking_seat_surcharge();
	}

	return $price;
}

/**
 * Format VND for display.
 *
 * @param int $amount Amount in VND.
 * @return string
 */
function xe36_booking_format_price( $amount ) {
	return number_format( (int) $amount, 0, ',', '.' ) . 'đ';
}

/**
 * Split route label into from / to parts.
 *
 * @param string $label Route label.
 * @return array{from: string, to: string}
 */
function xe36_booking_route_endpoints( $label ) {
	$parts = preg_split( '/\s*→\s*/u', (string) $label );
	if ( ! is_array( $parts ) || count( $parts ) < 2 ) {
		return array(
			'from' => (string) $label,
			'to'   => '',
		);
	}

	return array(
		'from' => trim( (string) $parts[0] ),
		'to'   => trim( (string) $parts[1] ),
	);
}

/**
 * Card data for popular routes section.
 *
 * @return array<int, array<string, mixed>>
 */
function xe36_booking_route_cards() {
	$cards = array();

	foreach ( xe36_booking_routes() as $value => $label ) {
		$ends  = xe36_booking_route_endpoints( $label );
		$price = 0;

		foreach ( array_keys( xe36_booking_seat_types() ) as $seat ) {
			$seat_price = xe36_booking_seat_price( $seat, $value );
			if ( $seat_price > 0 && ( 0 === $price || $seat_price < $price ) ) {
				$price = $seat_price;
			}
		}

		$cards[] = array(
			'value'       => $value,
			'label'       => $label,
			'from'        => $ends['from'],
			'to'          => $ends['to'],
			'price'       => $price,
			'price_label' => 'Từ ' . xe36_booking_format_price( $price ),
			'duration'    => '≈ 3 giờ',
			'frequency'   => '60 phút/chuyến',
		);
	}

	/**
	 * Filter popular route cards.
	 *
	 * @param array<int, array<string, mixed>> $cards Cards.
	 */
	return apply_filters( 'xe36_booking_route_cards', $cards );
}

/**
 * Seat option label including price for a route.
 *
 * @param string $seat  Seat key.
 * @param string $route Route key.
 * @return string
 */
function xe36_booking_seat_option_label( $seat, $route ) {
	$types = xe36_booking_seat_types();
	if ( ! isset( $types[ $seat ] ) ) {
		return $seat;
	}

	return sprintf(
		'%s — %s',
		$types[ $seat ],
		xe36_booking_format_price( xe36_booking_seat_price( $seat, $route ) )
	);
}
