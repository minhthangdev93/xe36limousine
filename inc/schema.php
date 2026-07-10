<?php
/**
 * Schema.org / Rank Math LocalBusiness — built from live site ACF data.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Format a phone for schema (digits, keep leading 0 for VN local).
 *
 * @param string $raw Raw phone.
 * @return string
 */
function xe36_schema_phone( $raw ) {
	$digits = preg_replace( '/\D+/', '', (string) $raw );
	return is_string( $digits ) ? $digits : '';
}

/**
 * Site logo URL (custom logo → known brand asset).
 *
 * @return string
 */
function xe36_schema_logo_url() {
	$logo_id = (int) get_theme_mod( 'custom_logo' );
	if ( $logo_id > 0 ) {
		$url = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return 'https://xe36limousine.vn/wp-content/uploads/2022/12/logo-xe-36-travel.png';
}

/**
 * Page ID by slug, or 0.
 *
 * @param string $slug Page slug.
 * @return int
 */
function xe36_schema_page_id( $slug ) {
	$page = get_page_by_path( $slug );
	return ( $page && ! empty( $page->ID ) ) ? (int) $page->ID : 0;
}

/**
 * Business profile assembled from site fields / defaults.
 *
 * @return array<string, mixed>
 */
function xe36_schema_business_profile() {
	if ( ! function_exists( 'xe36_booking_seat_base_prices' ) && function_exists( 'xe36_theme_path' ) ) {
		require_once xe36_theme_path( 'inc/booking/routes.php' );
	}

	$company = (string) xe36_get_site_field( 'footer_company', 'CÔNG TY CỔ PHẦN 36 TRAVEL' );
	$tagline = (string) xe36_get_site_field( 'footer_tagline', 'Xe limousine VIP Hà Nội ⇔ Thanh Hóa ⇔ Sầm Sơn' );
	$depot   = (string) xe36_get_site_field( 'footer_depot', 'Ki ốt 10, Chung cư N5 - KĐT Đồng Tàu, Hoàng Mai, Hà Nội' );
	$email   = (string) xe36_get_site_field( 'footer_email', '36limousine@gmail.com' );
	$booking = (string) xe36_get_site_field( 'booking_email', 'booking.36limousine@gmail.com' );
	$hotline = xe36_schema_phone( (string) xe36_get_site_field( 'hotline', '1900888999' ) );
	$phone2  = xe36_schema_phone( (string) xe36_get_site_field( 'footer_phone_2', '0367503636' ) );
	$phone3  = xe36_schema_phone( (string) xe36_get_site_field( 'footer_phone_3', '0343825678' ) );
	$zalo    = (string) xe36_get_site_field( 'zalo_url', 'https://zalo.me/0367503636' );

	$prices = function_exists( 'xe36_booking_seat_base_prices' )
		? xe36_booking_seat_base_prices()
		: array(
			'front'  => 260000,
			'middle' => 280000,
			'back'   => 260000,
		);
	$surcharge = function_exists( 'xe36_booking_seat_surcharge' )
		? (int) xe36_booking_seat_surcharge()
		: 50000;

	$min_price = min( array_map( 'intval', $prices ) );
	$max_price = max( array_map( 'intval', $prices ) ) + max( 0, $surcharge );

	$hn_offices = function_exists( 'xe36_footer_parse_lines' )
		? xe36_footer_parse_lines(
			(string) xe36_get_site_field(
				'footer_offices_hn',
				"23 Tú Mỡ, Phường Yên Hòa, Hà Nội\n56 Phố Vọng, P. Phương Mai, Đống Đa, Hà Nội\n51 P. Minh Khai, Minh Khai, Hai Bà Trưng, Hà Nội"
			)
		)
		: array();

	$th_offices = function_exists( 'xe36_footer_parse_lines' )
		? xe36_footer_parse_lines(
			(string) xe36_get_site_field(
				'footer_offices_th',
				'Sảnh chính Khách sạn Lam Kinh, Đại lộ Lê Lợi, KĐT mới Đông Hương, TP Thanh Hóa'
			)
		)
		: array();

	return array(
		'name'           => function_exists( 'xe36_brand_site_name' ) ? xe36_brand_site_name() : 'Xe 36 Limousine',
		'legalName'      => $company,
		'alternateName'  => function_exists( 'xe36_brand_alternate_names' ) ? xe36_brand_alternate_names() : array( '36 Travel Limousine' ),
		'description'    => $tagline,
		'url'            => home_url( '/' ),
		'logo'           => xe36_schema_logo_url(),
		'image'          => function_exists( 'xe36_get_share_banner_url' ) ? xe36_get_share_banner_url() : '',
		'email'          => $email,
		'booking_email'  => $booking,
		'telephone'      => $hotline,
		'phones'         => array_values( array_filter( array( $hotline, $phone2, $phone3 ) ) ),
		'zalo'           => $zalo,
		'priceRange'     => sprintf( '₫%s - ₫%s', number_format_i18n( $min_price ), number_format_i18n( $max_price ) ),
		'minPrice'       => $min_price,
		'maxPrice'       => $max_price,
		'currency'       => 'VND',
		'taxID'          => '0110122730',
		'vatID'          => '0110122730',
		'address'        => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Ki ốt 10, Chung cư N5 - KĐT Đồng Tàu',
			'addressLocality' => 'Hoàng Mai',
			'addressRegion'   => 'Hà Nội',
			'postalCode'      => '10000',
			'addressCountry'  => 'VN',
		),
		'address_text'   => $depot,
		'hn_offices'     => $hn_offices,
		'th_offices'     => $th_offices,
		'areaServed'     => array( 'Hà Nội', 'Thanh Hóa', 'Sầm Sơn', 'Hải Tiến', 'Ninh Bình' ),
		'opening_hours'  => '04:00-20:00',
		'about_page_id'  => xe36_schema_page_id( 'gioi-thieu' ),
		'contact_page_id'=> xe36_schema_page_id( 'lien-he' ),
	);
}

/**
 * Sync Rank Math Local SEO / Knowledge Graph from site profile.
 *
 * @param array|false $settings Rank Math titles option.
 * @return array
 */
function xe36_schema_sync_rank_math_titles( $settings ) {
	if ( ! is_array( $settings ) ) {
		$settings = array();
	}

	// ACF helpers may not be loaded yet on very early option reads.
	if ( ! function_exists( 'xe36_get_site_field' ) ) {
		return $settings;
	}

	$p = xe36_schema_business_profile();

	$settings['knowledgegraph_type']        = 'company';
	$settings['knowledgegraph_name']        = $p['name'];
	$settings['website_name']               = $p['name'];
	$settings['website_alternate_name']     = implode( ', ', (array) $p['alternateName'] );
	$settings['local_business_type']        = 'TaxiService';
	$settings['organization_description']   = $p['description'];
	$settings['url']                        = $p['url'];
	$settings['email']                      = $p['email'];
	$settings['phone']                      = $p['telephone'];
	$settings['price_range']                = $p['priceRange'];
	$settings['knowledgegraph_logo']        = $p['logo'];
	$settings['local_address']              = array(
		'streetAddress'   => $p['address']['streetAddress'],
		'addressLocality' => $p['address']['addressLocality'],
		'addressRegion'   => $p['address']['addressRegion'],
		'postalCode'      => $p['address']['postalCode'] ?? '10000',
		'addressCountry'  => 'VN',
	);

	$days = array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
	$hours = array();
	foreach ( $days as $day ) {
		$hours[] = array(
			'day'  => $day,
			'time' => $p['opening_hours'],
		);
	}
	$settings['opening_hours'] = $hours;

	$phone_numbers = array();
	if ( ! empty( $p['telephone'] ) ) {
		$phone_numbers[] = array(
			'type'   => 'customer support',
			'number' => $p['telephone'],
		);
	}
	foreach ( array_slice( $p['phones'], 1 ) as $extra ) {
		$phone_numbers[] = array(
			'type'   => 'customer support',
			'number' => $extra,
		);
	}
	$settings['phone_numbers'] = $phone_numbers;

	$settings['additional_info'] = array(
		array(
			'type'  => 'legalName',
			'value' => $p['legalName'],
		),
		array(
			'type'  => 'taxID',
			'value' => $p['taxID'],
		),
		array(
			'type'  => 'vatID',
			'value' => $p['vatID'],
		),
	);

	if ( $p['about_page_id'] > 0 ) {
		$settings['local_seo_about_page'] = $p['about_page_id'];
	}
	if ( $p['contact_page_id'] > 0 ) {
		$settings['local_seo_contact_page'] = $p['contact_page_id'];
	}

	return $settings;
}
add_filter( 'option_rank-math-options-titles', 'xe36_schema_sync_rank_math_titles', 20 );

/**
 * OpeningHoursSpecification list (Schema.org).
 *
 * @param string $hours e.g. 04:00-20:00.
 * @return array<int, array<string, mixed>>
 */
function xe36_schema_opening_hours_spec( $hours ) {
	$parts = explode( '-', (string) $hours );
	$opens = $parts[0] ?? '04:00';
	$closes = $parts[1] ?? '20:00';

	$days = array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
	$spec = array();
	foreach ( $days as $day ) {
		$spec[] = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => $day,
			'opens'     => $opens,
			'closes'    => $closes,
		);
	}
	return $spec;
}

/**
 * ContactPoint list.
 *
 * @param array $profile Business profile.
 * @return array<int, array<string, mixed>>
 */
function xe36_schema_contact_points( array $profile ) {
	$points = array();
	if ( ! empty( $profile['telephone'] ) ) {
		$points[] = array(
			'@type'             => 'ContactPoint',
			'telephone'         => $profile['telephone'],
			'contactType'       => 'customer service',
			'areaServed'        => 'VN',
			'availableLanguage' => array( 'Vietnamese' ),
			'hoursAvailable'    => array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
				'opens'     => '04:00',
				'closes'    => '20:00',
			),
		);
	}
	if ( ! empty( $profile['booking_email'] ) ) {
		$points[] = array(
			'@type'       => 'ContactPoint',
			'email'       => $profile['booking_email'],
			'contactType' => 'reservations',
			'areaServed'  => 'VN',
		);
	}
	return $points;
}

/**
 * Branch offices as department Organization entities.
 * (Schema.org: Organization.department expects Organization, not Place.)
 *
 * @param array $profile Business profile.
 * @return array<int, array<string, mixed>>
 */
function xe36_schema_departments( array $profile ) {
	$deps = array();
	foreach ( (array) $profile['hn_offices'] as $addr ) {
		$deps[] = array(
			'@type'   => 'Organization',
			'name'    => 'Văn phòng Hà Nội — Xe 36 Limousine',
			'parentOrganization' => array( '@id' => home_url( '/#organization' ) ),
			'address' => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $addr,
				'addressLocality' => 'Hà Nội',
				'addressRegion'   => 'Hà Nội',
				'postalCode'      => '10000',
				'addressCountry'  => 'VN',
			),
		);
	}
	foreach ( (array) $profile['th_offices'] as $addr ) {
		$deps[] = array(
			'@type'   => 'Organization',
			'name'    => 'Văn phòng Thanh Hóa — Xe 36 Limousine',
			'parentOrganization' => array( '@id' => home_url( '/#organization' ) ),
			'address' => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $addr,
				'addressLocality' => 'Thanh Hóa',
				'addressRegion'   => 'Thanh Hóa',
				'postalCode'      => '40000',
				'addressCountry'  => 'VN',
			),
		);
	}
	return $deps;
}

/**
 * Offer catalog for limousine seats (homepage).
 *
 * @param array $profile Business profile.
 * @return array<string, mixed>|null
 */
function xe36_schema_offer_catalog( array $profile ) {
	if ( ! function_exists( 'xe36_booking_seat_base_prices' ) || ! function_exists( 'xe36_booking_seat_types' ) ) {
		return null;
	}

	$prices = xe36_booking_seat_base_prices();
	$labels = xe36_booking_seat_types();
	$items  = array();

	foreach ( $labels as $key => $label ) {
		$price = isset( $prices[ $key ] ) ? (int) $prices[ $key ] : 0;
		if ( $price <= 0 ) {
			continue;
		}
		$items[] = array(
			'@type' => 'Offer',
			'name'  => $label . ' — Hà Nội ⇌ Thanh Hóa',
			'price' => (string) $price,
			'priceCurrency' => 'VND',
			'availability'  => 'https://schema.org/InStock',
			'url'           => home_url( '/#home-booking' ),
		);
	}

	if ( ! $items ) {
		return null;
	}

	return array(
		'@type'           => 'OfferCatalog',
		'name'            => 'Bảng giá vé limousine',
		'itemListElement' => $items,
	);
}

/**
 * Service entities (passenger + cargo).
 *
 * @param array $profile Business profile.
 * @return array<string, array<string, mixed>>
 */
function xe36_schema_services( array $profile ) {
	$provider = array( '@id' => home_url( '/#organization' ) );

	return array(
		'service-passenger' => array(
			'@type'       => 'Service',
			'@id'         => home_url( '/#service-passenger' ),
			'name'        => 'Vận chuyển hành khách limousine',
			'description' => 'Đưa đón hành khách tuyến Hà Nội – Thanh Hóa – Sầm Sơn – Hải Tiến bằng xe Limousine VIP 11 chỗ, đưa đón tận nơi.',
			'provider'    => $provider,
			'areaServed'  => $profile['areaServed'],
			'serviceType' => 'Passenger transportation',
			'url'         => home_url( '/van-chuyen-hanh-khach/' ),
		),
		'service-cargo'     => array(
			'@type'       => 'Service',
			'@id'         => home_url( '/#service-cargo' ),
			'name'        => 'Vận chuyển hàng hóa',
			'description' => 'Vận chuyển hàng hóa siêu tốc tuyến Hà Nội – Thanh Hóa bằng xe limousine.',
			'provider'    => $provider,
			'areaServed'  => $profile['areaServed'],
			'serviceType' => 'Parcel delivery',
			'url'         => home_url( '/van-chuyen-hang-hoa/' ),
		),
	);
}

/**
 * Enrich Rank Math JSON-LD with full business + services schema.
 *
 * @param array $data   Schema graph.
 * @param mixed $jsonld Rank Math JsonLD instance (unused).
 * @return array
 */
function xe36_schema_enrich_json_ld( $data, $jsonld = null ) {
	unset( $jsonld );

	if ( ! is_array( $data ) || ! function_exists( 'xe36_get_site_field' ) ) {
		return $data;
	}

	$p = xe36_schema_business_profile();

	if ( ! empty( $data['publisher'] ) && is_array( $data['publisher'] ) ) {
		$pub = &$data['publisher'];

		$pub['@type']       = array( 'Organization', 'LocalBusiness', 'TaxiService' );
		$pub['@id']         = home_url( '/#organization' );
		$pub['name']        = $p['name'];
		$pub['legalName']   = $p['legalName'];
		$pub['alternateName'] = $p['alternateName'];
		$pub['description'] = $p['description'];
		$pub['url']         = $p['url'];
		$pub['email']       = $p['email'];
		$pub['telephone']   = $p['telephone'];
		$pub['priceRange']  = $p['priceRange'];
		$pub['currenciesAccepted'] = 'VND';
		$pub['paymentAccepted']    = 'Cash, Bank Transfer, MoMo';
		$pub['taxID']       = $p['taxID'];
		$pub['vatID']       = $p['vatID'];
		$pub['address']     = $p['address'];
		$pub['areaServed']  = array_map(
			static function ( $name ) {
				return array(
					'@type' => 'City',
					'name'  => $name,
				);
			},
			$p['areaServed']
		);
		$pub['openingHoursSpecification'] = xe36_schema_opening_hours_spec( $p['opening_hours'] );
		$pub['contactPoint']              = xe36_schema_contact_points( $p );

		$same_as = array();
		if ( ! empty( $p['zalo'] ) ) {
			$same_as[] = $p['zalo'];
		}
		$same_as[] = 'https://xe36limousine.vn/';
		$pub['sameAs'] = array_values( array_unique( $same_as ) );

		if ( ! empty( $p['logo'] ) ) {
			$pub['logo'] = array(
				'@type' => 'ImageObject',
				'@id'   => home_url( '/#logo' ),
				'url'   => $p['logo'],
				'caption' => $p['name'],
			);
			$pub['image'] = array( $p['logo'] );
			if ( ! empty( $p['image'] ) && $p['image'] !== $p['logo'] ) {
				$pub['image'][] = $p['image'];
			}
		}

		$deps = xe36_schema_departments( $p );
		if ( $deps ) {
			$pub['department'] = $deps;
		}

		$catalog = xe36_schema_offer_catalog( $p );
		if ( $catalog && is_front_page() ) {
			$pub['hasOfferCatalog'] = $catalog;
		}

		unset( $pub );
	}

	if ( ! empty( $data['WebSite'] ) && is_array( $data['WebSite'] ) ) {
		$data['WebSite']['name']          = $p['name'];
		$data['WebSite']['alternateName'] = $p['alternateName'];
		$data['WebSite']['description']   = $p['description'];
		$data['WebSite']['publisher']     = array( '@id' => home_url( '/#organization' ) );
	}

	// Attach services on homepage and service pages.
	$show_services = is_front_page()
		|| ( function_exists( 'xe36_is_passenger_page' ) && xe36_is_passenger_page() )
		|| ( function_exists( 'xe36_is_cargo_page' ) && xe36_is_cargo_page() )
		|| ( function_exists( 'xe36_is_about_page' ) && xe36_is_about_page() );

	if ( $show_services ) {
		foreach ( xe36_schema_services( $p ) as $key => $service ) {
			if ( function_exists( 'xe36_is_passenger_page' ) && xe36_is_passenger_page() && 'service-cargo' === $key ) {
				continue;
			}
			if ( function_exists( 'xe36_is_cargo_page' ) && xe36_is_cargo_page() && 'service-passenger' === $key ) {
				continue;
			}
			$data[ $key ] = $service;
		}
	}

	return $data;
}
add_filter( 'rank_math/json_ld', 'xe36_schema_enrich_json_ld', 110, 2 );

/**
 * Fallback JSON-LD when Rank Math is inactive.
 */
function xe36_schema_print_fallback() {
	if ( defined( 'RANK_MATH_VERSION' ) || ! function_exists( 'xe36_get_site_field' ) ) {
		return;
	}

	$p   = xe36_schema_business_profile();
	$org = array(
		'@context' => 'https://schema.org',
		'@type'    => array( 'Organization', 'LocalBusiness', 'TaxiService' ),
		'@id'      => home_url( '/#organization' ),
		'name'     => $p['name'],
		'legalName'=> $p['legalName'],
		'url'      => $p['url'],
		'telephone'=> $p['telephone'],
		'email'    => $p['email'],
		'address'  => $p['address'],
		'priceRange' => $p['priceRange'],
		'openingHoursSpecification' => xe36_schema_opening_hours_spec( $p['opening_hours'] ),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $org, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'xe36_schema_print_fallback', 6 );
