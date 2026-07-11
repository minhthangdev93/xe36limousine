<?php
/**
 * Homepage section: Price table (left) + daily schedule (right).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

require_once xe36_theme_path( 'inc/booking/routes.php' );

$title     = xe36_get_homepage_field( 'pricing_title', 'Bảng giá & lịch chạy' );
$sch_title = xe36_get_homepage_field( 'pricing_schedule_title', 'Lịch chạy hàng ngày' );
$sch_sub   = xe36_get_homepage_field( 'pricing_schedule_subtitle', 'Ghế hạng thương gia — Ba Sáu Travel' );
$sch_route = xe36_get_homepage_field( 'pricing_schedule_route', 'Hà Nội ⇌ Thanh Hóa' );

$morning_raw = xe36_get_homepage_field(
	'pricing_schedule_morning',
	"04:00\n05:00\n06:00\n07:00\n08:00\n09:00\n10:00\n11:00\n12:00"
);
$afternoon_raw = xe36_get_homepage_field(
	'pricing_schedule_afternoon',
	"13:00\n14:00\n15:00\n16:00\n17:00\n18:00\n19:00\n20:00"
);

/**
 * Split multiline times into clean list.
 *
 * @param mixed $raw Raw field.
 * @return string[]
 */
$parse_times = static function ( $raw ) {
	$out = array();
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return $out;
	}
	foreach ( preg_split( '/\r\n|\r|\n|,/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$out[] = $line;
		}
	}
	return $out;
};

$morning   = $parse_times( $morning_raw );
$afternoon = $parse_times( $afternoon_raw );

$seat_types = xe36_booking_seat_types();
$price_rows = array();

foreach ( $seat_types as $seat_key => $seat_label ) {
	$base = xe36_booking_seat_price( $seat_key, 'hn-th' );
	$far  = xe36_booking_seat_price( $seat_key, 'hn-ss' );
	$price_rows[] = array(
		'key'   => $seat_key,
		'label' => $seat_label,
		'th'    => xe36_booking_format_price( $base ),
		'far'   => xe36_booking_format_price( $far ),
	);
}
?>
<section class="home-section home-pricing" id="home-pricing" data-section="pricing">
	<div class="home-section__inner home-pricing__inner">
		<?php if ( $title ) : ?>
			<header class="home-pricing__header">
				<p class="home-pricing__eyebrow">Giá & lịch</p>
				<h2 class="home-pricing__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="home-pricing__grid">
			<div class="home-pricing__prices">
				<div class="home-pricing__card">
					<div class="home-pricing__card-head">
						<h3 class="home-pricing__card-title">Bảng giá vé</h3>
						<p class="home-pricing__card-note">Giá niêm yết · thanh toán khi lên xe</p>
					</div>

					<ul class="home-pricing__list">
						<?php foreach ( $price_rows as $row ) : ?>
							<?php
							$featured = ( 'middle' === $row['key'] );
							$item_class = 'home-pricing__tier' . ( $featured ? ' is-featured' : '' );
							?>
							<li class="<?php echo esc_attr( $item_class ); ?>">
								<?php if ( $featured ) : ?>
									<span class="home-pricing__badge">Phổ biến</span>
								<?php endif; ?>
								<p class="home-pricing__tier-label"><?php echo esc_html( $row['label'] ); ?></p>
								<div class="home-pricing__tier-prices">
									<div class="home-pricing__fare">
										<span class="home-pricing__fare-route">HN ⇌ Thanh Hóa</span>
										<span class="home-pricing__fare-amount"><?php echo esc_html( $row['th'] ); ?></span>
									</div>
									<div class="home-pricing__fare">
										<span class="home-pricing__fare-route">HN ⇌ Sầm Sơn / Hải Tiến</span>
										<span class="home-pricing__fare-amount"><?php echo esc_html( $row['far'] ); ?></span>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>

					<a class="btn home-pricing__cta" href="#home-booking">Đặt vé ngay</a>
				</div>
			</div>

			<div class="home-pricing__schedule">
				<div class="home-pricing__schedule-card">
					<?php if ( $sch_title ) : ?>
						<p class="home-pricing__schedule-title"><?php echo esc_html( $sch_title ); ?></p>
					<?php endif; ?>
					<?php if ( $sch_sub ) : ?>
						<p class="home-pricing__schedule-sub"><?php echo esc_html( $sch_sub ); ?></p>
					<?php endif; ?>
					<?php if ( $sch_route ) : ?>
						<p class="home-pricing__schedule-route"><?php echo esc_html( $sch_route ); ?></p>
					<?php endif; ?>

					<?php if ( $morning ) : ?>
						<p class="home-pricing__period">Sáng</p>
						<ul class="home-pricing__times">
							<?php foreach ( $morning as $time ) : ?>
								<li><?php echo esc_html( $time ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( $afternoon ) : ?>
						<p class="home-pricing__period">Chiều</p>
						<ul class="home-pricing__times">
							<?php foreach ( $afternoon as $time ) : ?>
								<li><?php echo esc_html( $time ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
