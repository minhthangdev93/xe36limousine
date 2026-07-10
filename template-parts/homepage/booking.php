<?php
/**
 * Homepage section: Booking — form left, process right.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$section_title = xe36_get_homepage_field(
	'booking_section_title',
	'Đặt vé Limousine Hà Nội ⇌ Thanh Hóa nhanh'
);

$steps_raw = xe36_get_homepage_field(
	'booking_process_steps',
	"Điền các thông tin và gửi yêu cầu đặt vé\nTổng đài gọi lại tư vấn và xác nhận\nĐặt vé chính thức lên hệ thống"
);

$note = xe36_get_homepage_field(
	'booking_process_note',
	'Đây mới là yêu cầu đặt vé. Nếu tổng đài chưa liên hệ, vui lòng gửi yêu cầu đặt vé lại.'
);

$steps = array();
if ( is_string( $steps_raw ) && '' !== trim( $steps_raw ) ) {
	foreach ( preg_split( '/\r\n|\r|\n/', $steps_raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$steps[] = $line;
		}
	}
}
?>
<section class="home-section home-booking" id="home-booking" data-section="booking">
	<div class="home-section__inner home-booking__inner">
		<?php if ( $section_title ) : ?>
			<header class="home-booking__header">
				<p class="home-booking__eyebrow">Đặt vé online</p>
				<h2 class="home-booking__title"><?php echo esc_html( $section_title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="home-booking__grid">
			<div class="home-booking__form-wrap">
				<?php echo xe36_booking_form_shortcode(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<div class="home-booking__process">
				<h3 class="home-booking__process-title">Quy trình gửi yêu cầu đặt vé</h3>
				<?php if ( $steps ) : ?>
					<ol class="home-booking__steps">
						<?php foreach ( $steps as $index => $step ) : ?>
							<li class="home-booking__step">
								<span class="home-booking__step-num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
								<span class="home-booking__step-text"><?php echo esc_html( $step ); ?></span>
							</li>
						<?php endforeach; ?>
					</ol>
				<?php endif; ?>

				<?php if ( $note ) : ?>
					<p class="home-booking__note"><?php echo esc_html( $note ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
