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
$sch_sub   = xe36_get_homepage_field( 'pricing_schedule_subtitle', 'Ghế hạng thương gia — Xe 36 Limousine' );

if ( is_string( $sch_sub ) && '' !== $sch_sub ) {
	$sch_sub = preg_replace( '/Ba\s*Sáu\s*Travel/iu', 'Xe 36 Limousine', $sch_sub );
}

/**
 * Split departure times into morning (<= 12:00) and afternoon (> 12:00).
 *
 * @param string[] $times Times HH:MM.
 * @return array{morning: string[], afternoon: string[]}
 */
$split_periods = static function ( array $times ) {
	$morning   = array();
	$afternoon = array();

	foreach ( $times as $time ) {
		$time = (string) $time;
		if ( $time <= '12:00' ) {
			$morning[] = $time;
		} else {
			$afternoon[] = $time;
		}
	}

	return array(
		'morning'   => $morning,
		'afternoon' => $afternoon,
	);
};

/**
 * Footer summary for a direction list.
 *
 * @param string[] $times Times.
 * @return string
 */
$direction_foot = static function ( array $times ) {
	$count = count( $times );
	if ( 0 === $count ) {
		return '';
	}

	$first = $times[0];
	$last  = $times[ $count - 1 ];

	return sprintf(
		/* translators: 1: trip count, 2: first time, 3: last time */
		'%1$d chuyến · %2$s–%3$s',
		$count,
		$first,
		$last
	);
};

$schedules = xe36_booking_departure_schedules();
$directions = array(
	'outbound' => array(
		'label'   => 'HN → Thanh Hóa',
		'times'   => $schedules['outbound'] ?? array(),
		'periods' => $split_periods( $schedules['outbound'] ?? array() ),
		'foot'    => $direction_foot( $schedules['outbound'] ?? array() ),
	),
	'inbound'  => array(
		'label'   => 'Thanh Hóa → HN',
		'times'   => $schedules['inbound'] ?? array(),
		'periods' => $split_periods( $schedules['inbound'] ?? array() ),
		'foot'    => $direction_foot( $schedules['inbound'] ?? array() ),
	),
);

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
							$featured   = ( 'middle' === $row['key'] );
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
				<div class="home-pricing__schedule-card" data-schedule-card>
					<div class="home-pricing__schedule-head">
						<?php if ( $sch_title ) : ?>
							<p class="home-pricing__schedule-title"><?php echo esc_html( $sch_title ); ?></p>
						<?php endif; ?>
						<?php if ( $sch_sub ) : ?>
							<p class="home-pricing__schedule-sub"><?php echo esc_html( $sch_sub ); ?></p>
						<?php endif; ?>

						<div class="home-pricing__schedule-toggle" role="group" aria-label="<?php echo esc_attr__( 'Chọn chiều lịch chạy', 'oceanwp-child' ); ?>">
							<?php foreach ( $directions as $dir_key => $dir ) : ?>
								<button
									type="button"
									class="home-pricing__schedule-tab"
									data-schedule-dir="<?php echo esc_attr( $dir_key ); ?>"
									aria-pressed="<?php echo 'outbound' === $dir_key ? 'true' : 'false'; ?>"
								>
									<?php echo esc_html( $dir['label'] ); ?>
								</button>
							<?php endforeach; ?>
						</div>
					</div>

					<?php foreach ( $directions as $dir_key => $dir ) : ?>
						<?php
						$morning   = $dir['periods']['morning'];
						$afternoon = $dir['periods']['afternoon'];
						$is_active = ( 'outbound' === $dir_key );
						?>
						<div
							class="home-pricing__schedule-blocks"
							data-schedule-panel="<?php echo esc_attr( $dir_key ); ?>"
							<?php echo $is_active ? '' : 'hidden'; ?>
						>
							<?php if ( $morning ) : ?>
								<div class="home-pricing__block">
									<div class="home-pricing__period">
										<span class="home-pricing__period-label">Sáng</span>
										<span class="home-pricing__period-count"><?php echo esc_html( (string) count( $morning ) ); ?> chuyến</span>
									</div>
									<ul class="home-pricing__times">
										<?php foreach ( $morning as $time ) : ?>
											<li><?php echo esc_html( $time ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>

							<?php if ( $afternoon ) : ?>
								<div class="home-pricing__block">
									<div class="home-pricing__period">
										<span class="home-pricing__period-label">Chiều</span>
										<span class="home-pricing__period-count"><?php echo esc_html( (string) count( $afternoon ) ); ?> chuyến</span>
									</div>
									<ul class="home-pricing__times">
										<?php foreach ( $afternoon as $time ) : ?>
											<li><?php echo esc_html( $time ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>

					<p
						class="home-pricing__schedule-foot"
						data-schedule-foot
						data-foot-outbound="<?php echo esc_attr( $directions['outbound']['foot'] ); ?>"
						data-foot-inbound="<?php echo esc_attr( $directions['inbound']['foot'] ); ?>"
					><?php echo esc_html( $directions['outbound']['foot'] ); ?></p>
					<a class="btn home-pricing__cta home-pricing__cta--ghost" href="#home-booking">Đặt vé ngay</a>
				</div>
			</div>
		</div>
	</div>
</section>
