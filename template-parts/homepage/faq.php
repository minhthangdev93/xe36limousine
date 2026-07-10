<?php
/**
 * Homepage section: FAQ
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title = xe36_get_homepage_field( 'faq_title', 'Câu hỏi thường gặp' );
$raw   = xe36_get_homepage_field(
	'faq_items',
	"Làm thế nào để tôi có thể đặt vé online?\n\nRất đơn giản. Bạn truy cập trang chủ và tiến hành theo 3 bước sau:\n\n– Bước 1: Chọn điểm đón, điểm đến, ngày giờ và loại ghế phù hợp\n– Bước 2: Điền họ tên, số điện thoại rồi gửi yêu cầu đặt vé\n– Bước 3: Chờ tổng đài viên xác nhận — thanh toán sau khi lên xe\n\nHoặc gọi qua tổng đài 1900 888 999 để được tư vấn và hỗ trợ nhanh nhất.\n\n---\n\nLàm sao tôi có thể thanh toán vé?\n\nHiện tại, chúng tôi có các hình thức thanh toán cơ bản sau:\n\n– Chuyển khoản ngân hàng\n– Ví điện tử MoMo\n– Thanh toán trực tiếp tại văn phòng hãng xe\n– Thanh toán khi lên xe (không bắt buộc thanh toán trước)\n\nBạn có thể chọn hình thức phù hợp khi tổng đài viên xác nhận vé.\n\n---\n\nLàm sao để biết tôi đã đặt vé thành công?\n\nSau khi gửi yêu cầu đặt vé, tổng đài viên sẽ xác nhận thông tin và cung cấp vé điện tử qua Zalo, email hoặc SMS.\n\nTrên vé điện tử đã có đầy đủ thông tin: mã vé, vị trí ghế ngồi, số lượng vé, thông tin cá nhân và hotline hỗ trợ. Bạn chỉ cần trình mã vé hoặc số điện thoại trước khi lên xe.\n\n---\n\nTôi nhận vé bằng cách nào?\n\nCó nhiều hình thức nhận vé:\n\n– Nhận vé qua Zalo, Email hoặc SMS\n– Nếu muốn nhận vé giấy: ngày đi đọc tên, số điện thoại hoặc mã vé tại văn phòng nhà xe trước giờ khởi hành\n\n---\n\nVé tôi đặt được cam kết những gì?\n\nVé đặt tại Xe 36 Limousine được cam kết 100% những điều sau:\n\n– Đúng xe Limousine Dcar Solati đời mới VIP\n– Đúng vị trí ghế đã đặt và xác nhận trong vé\n– Đúng giá vé niêm yết trên website\n– Đầy đủ dịch vụ, tiện nghi đã tư vấn và cam kết\n– Đón trả đúng nơi, đúng giờ"
);

/**
 * Parse FAQ blocks: question on first line, answer below; items separated by ---.
 *
 * @param string $raw Raw FAQ text.
 * @return array<int, array{question: string, answer: string}>
 */
$items = array();
if ( is_string( $raw ) && '' !== trim( $raw ) ) {
	$blocks = preg_split( '/\R---\R/', $raw );
	if ( is_array( $blocks ) ) {
		foreach ( $blocks as $block ) {
			$block = trim( $block );
			if ( '' === $block ) {
				continue;
			}
			$lines = preg_split( '/\R/', $block );
			if ( ! is_array( $lines ) || ! $lines ) {
				continue;
			}
			$question = trim( (string) array_shift( $lines ) );
			while ( isset( $lines[0] ) && '' === trim( (string) $lines[0] ) ) {
				array_shift( $lines );
			}
			$answer = trim( implode( "\n", $lines ) );
			if ( '' === $question || '' === $answer ) {
				continue;
			}
			$items[] = array(
				'question' => $question,
				'answer'   => $answer,
			);
		}
	}
}

if ( ! $items ) {
	return;
}

/**
 * Format plain FAQ answer into safe HTML (paragraphs + dash lists).
 *
 * @param string $text Plain answer.
 * @return string
 */
$format_answer = static function ( $text ) {
	$lines = preg_split( '/\R/', $text );
	if ( ! is_array( $lines ) ) {
		return '';
	}

	$html        = '';
	$paragraph   = array();
	$list_items  = array();

	$flush_paragraph = static function () use ( &$html, &$paragraph ) {
		if ( ! $paragraph ) {
			return;
		}
		$html     .= '<p>' . esc_html( implode( ' ', $paragraph ) ) . '</p>';
		$paragraph = array();
	};

	$flush_list = static function () use ( &$html, &$list_items ) {
		if ( ! $list_items ) {
			return;
		}
		$html       .= '<ul>';
		foreach ( $list_items as $item ) {
			$html .= '<li>' . esc_html( $item ) . '</li>';
		}
		$html       .= '</ul>';
		$list_items  = array();
	};

	foreach ( $lines as $line ) {
		$line = trim( (string) $line );
		if ( '' === $line ) {
			$flush_list();
			$flush_paragraph();
			continue;
		}
		if ( preg_match( '/^[–\-\*]\s+(.+)$/u', $line, $m ) ) {
			$flush_paragraph();
			$list_items[] = $m[1];
			continue;
		}
		$flush_list();
		$paragraph[] = $line;
	}
	$flush_list();
	$flush_paragraph();

	return $html;
};

$schema_entities = array();
foreach ( $items as $item ) {
	$schema_entities[] = array(
		'@type'          => 'Question',
		'name'           => $item['question'],
		'acceptedAnswer' => array(
			'@type' => 'Answer',
			'text'  => wp_strip_all_tags( $item['answer'] ),
		),
	);
}
?>
<section class="home-section home-faq" id="home-faq" data-section="faq">
	<div class="home-section__inner home-faq__inner">
		<?php if ( $title ) : ?>
			<header class="home-faq__header">
				<p class="home-faq__eyebrow">Hỗ trợ</p>
				<h2 class="home-faq__title"><?php echo esc_html( $title ); ?></h2>
			</header>
		<?php endif; ?>

		<div class="home-faq__list">
			<?php foreach ( $items as $index => $item ) : ?>
				<details class="home-faq__item"<?php echo 0 === $index ? ' open' : ''; ?>>
					<summary class="home-faq__question">
						<span class="home-faq__question-text"><?php echo esc_html( $item['question'] ); ?></span>
						<span class="home-faq__icon" aria-hidden="true"></span>
					</summary>
					<div class="home-faq__answer">
						<?php echo $format_answer( $item['answer'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside formatter. ?>
					</div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>

	<script type="application/ld+json">
	<?php
	echo wp_json_encode(
		array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $schema_entities,
		),
		JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
	);
	?>
	</script>
</section>
