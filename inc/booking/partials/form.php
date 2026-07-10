<?php
/**
 * Booking form markup — route-based quick book.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

require_once xe36_theme_path( 'inc/booking/routes.php' );
require_once xe36_theme_path( 'inc/booking/countries.php' );

$form_title    = xe36_get_homepage_field( 'booking_form_title', 'Đặt vé nhanh' );
$label_route   = xe36_get_homepage_field( 'booking_label_route', 'Tuyến' );
$label_date    = xe36_get_homepage_field( 'booking_label_date', 'Ngày đi' );
$label_time    = xe36_get_homepage_field( 'booking_label_time', 'Giờ đi' );
$label_name    = xe36_get_homepage_field( 'booking_label_name', 'Họ và tên' );
$label_phone   = xe36_get_homepage_field( 'booking_label_phone', 'Số điện thoại' );
$label_tickets = xe36_get_homepage_field( 'booking_label_tickets', 'Số vé' );
$label_seat    = xe36_get_homepage_field( 'booking_label_seat', 'Ghế muốn ngồi' );
$submit_text   = xe36_get_homepage_field( 'booking_submit_text', 'Yêu cầu đặt vé' );
$routes        = xe36_booking_routes();
$seat_types    = xe36_booking_seat_types();
$countries     = xe36_booking_countries();
$default_route = 'hn-th';
$default_seat  = 'middle';
?>
<div class="datve xe36-booking-form">
	<?php if ( $form_title ) : ?>
		<h2 class="xe36-booking-form__title text-headline-sm"><?php echo esc_html( $form_title ); ?></h2>
	<?php endif; ?>

	<form id="booking-form" class="xe36-booking-form__fields" novalidate>
		<div class="form-group form-group--route">
			<label class="text-label-caps" for="route"><?php echo esc_html( $label_route ); ?></label>
			<select class="xe36-select" id="route" name="route" required>
				<?php foreach ( $routes as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $default_route ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-row form-row--2">
			<div class="form-group">
				<label class="text-label-caps" for="date"><?php echo esc_html( $label_date ); ?></label>
				<input class="xe36-input" type="date" id="date" name="date" required>
			</div>
			<div class="form-group">
				<label class="text-label-caps" for="time"><?php echo esc_html( $label_time ); ?></label>
				<select class="xe36-select" id="time" name="time" required></select>
			</div>
		</div>

		<div class="form-group form-group--name">
			<label class="text-label-caps" for="name"><?php echo esc_html( $label_name ); ?></label>
			<input class="xe36-input" type="text" id="name" name="name" placeholder="<?php echo esc_attr( $label_name ); ?>" required autocomplete="name">
		</div>

		<div class="form-group form-group--phone">
			<label class="text-label-caps" for="phone"><?php echo esc_html( $label_phone ); ?></label>
			<div class="phone-group">
				<div class="xe36-country-combobox" data-country-combobox>
					<input type="hidden" id="country-code" name="country-code" value="Vietnam +84" required>
					<input
						type="text"
						class="xe36-input xe36-country-combobox__input"
						id="country-code-search"
						name="country_code_search"
						autocomplete="off"
						spellcheck="false"
						placeholder="Mã vùng"
						title="Gõ tên quốc gia hoặc mã (84, +81, Japan…)"
						aria-label="Mã vùng / quốc gia"
						aria-autocomplete="list"
						aria-controls="country-code-list"
						aria-expanded="false"
						role="combobox"
						value="Vietnam (+84)"
					>
					<ul class="xe36-country-combobox__list" id="country-code-list" role="listbox" hidden></ul>
				</div>
				<input class="xe36-input" type="tel" id="phone" name="phone" required placeholder="09xx xxx xxx" autocomplete="tel-national" inputmode="numeric">
			</div>
		</div>

		<div class="form-row form-row--2">
			<div class="form-group">
				<label class="text-label-caps" for="seat"><?php echo esc_html( $label_seat ); ?></label>
				<select class="xe36-select" id="seat" name="seat" required>
					<?php foreach ( $seat_types as $seat_value => $seat_label ) : ?>
						<option value="<?php echo esc_attr( $seat_value ); ?>" <?php selected( $seat_value, $default_seat ); ?>>
							<?php echo esc_html( xe36_booking_seat_option_label( $seat_value, $default_route ) ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label class="text-label-caps" for="ticket-quantity"><?php echo esc_html( $label_tickets ); ?></label>
				<select class="xe36-select" id="ticket-quantity" name="ticket-quantity" required>
					<?php for ( $i = 1; $i <= 11; $i++ ) : ?>
						<option value="<?php echo esc_attr( (string) $i ); ?>"><?php echo esc_html( (string) $i ); ?></option>
					<?php endfor; ?>
				</select>
			</div>
		</div>

		<button type="submit" class="btn btn--primary btn--block" data-submit-label="<?php echo esc_attr( $submit_text ); ?>">
			<?php echo esc_html( $submit_text ); ?>
		</button>
		<div id="response" class="xe36-booking-form__response" aria-live="polite"></div>
	</form>

	<script type="application/json" id="xe36-countries-json"><?php echo wp_json_encode( $countries ); ?></script>
</div>
