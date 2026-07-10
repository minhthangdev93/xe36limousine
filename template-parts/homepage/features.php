<?php
/**
 * Homepage section: Why choose Xe 36 Limousine.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title     = xe36_get_homepage_field( 'features_title', 'Lý do chọn xe 36 Limousine' );
$items_raw = xe36_get_homepage_field(
	'features_items',
	"Không phải thanh toán trước|Đặt vé giữ chỗ nhanh, thanh toán khi lên xe\nĐón trả tận nơi|Xe trung chuyển đưa đón theo địa chỉ của bạn\nGiá luôn tốt nhất|Đúng giá niêm yết, không tăng giá ngày lễ Tết\nTần suất 1 tiếng 1 chuyến|Nhiều chuyến trong ngày từ sáng sớm đến tối\nĐúng giờ đón trả|Cam kết đúng giờ, đúng ghế đã đặt trên vé\nTổng đài hỗ trợ 24/7|Hotline 1900 888 999 luôn sẵn sàng tư vấn"
);

$items = array();
if ( is_string( $items_raw ) && '' !== trim( $items_raw ) ) {
	foreach ( preg_split( '/\r\n|\r|\n/', $items_raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		$items[] = array(
			'title' => $parts[0],
			'text'  => $parts[1] ?? '',
		);
	}
}

if ( ! $items ) {
	return;
}
?>
<section class="home-section home-features" id="home-features" data-section="features">
	<div class="home-section__inner home-features__inner">
		<?php if ( $title ) : ?>
			<header class="home-features__header">
				<p class="home-features__eyebrow">Vì sao chọn chúng tôi</p>
				<h2 class="home-features__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="home-features__viewport">
			<ul class="home-features__grid">
				<?php foreach ( $items as $index => $item ) : ?>
					<li class="home-features__card">
						<span class="home-features__num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
						<div class="home-features__body">
							<h3 class="home-features__card-title"><?php echo esc_html( $item['title'] ); ?></h3>
							<?php if ( $item['text'] ) : ?>
								<p class="home-features__card-text"><?php echo esc_html( $item['text'] ); ?></p>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
