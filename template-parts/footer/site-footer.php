<?php
/**
 * Site footer markup.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$company = xe36_get_site_field( 'footer_company', 'CÔNG TY CỔ PHẦN 36 TRAVEL' );
$tagline = xe36_get_site_field( 'footer_tagline', 'Xe limousine VIP Hà Nội ⇔ Thanh Hóa ⇔ Sầm Sơn' );
$depot   = xe36_get_site_field( 'footer_depot', 'Ki ốt 10, Chung cư N5 - KĐT Đồng Tàu, Hoàng Mai, Hà Nội' );
$email   = xe36_get_site_field( 'footer_email', '36limousine@gmail.com' );
$legal   = xe36_get_site_field(
	'footer_legal',
	"DKKD số 0110122730 do Sở KH&ĐT Hà Nội cấp ngày 20/09/2022\nGiấy phép KD vận tải bằng ô tô số 9595/GPKDVT do Sở GTVT Hà Nội cấp ngày 18/01/2023"
);

$hotline_raw = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_display = xe36_get_site_field( 'hotline_display', '1900 888 999' );
if ( ! is_string( $hotline_display ) || '' === trim( $hotline_display ) || '1900 xxxx' === trim( $hotline_display ) ) {
	$hotline_display = '1900 888 999';
}
$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';

$zalo_url = xe36_get_site_field( 'zalo_url', 'https://zalo.me/0367503636' );
if ( ! is_string( $zalo_url ) || '' === trim( $zalo_url ) ) {
	$zalo_url = 'https://zalo.me/0367503636';
}

$phone2 = xe36_get_site_field( 'footer_phone_2', '0367503636' );
$phone3 = xe36_get_site_field( 'footer_phone_3', '0343825678' );

$hn_offices = xe36_footer_parse_lines(
	xe36_get_site_field(
		'footer_offices_hn',
		"23 Tú Mỡ, Phường Yên Hòa, Hà Nội\n56 Phố Vọng, P. Phương Mai, Đống Đa, Hà Nội\n51 P. Minh Khai, Minh Khai, Hai Bà Trưng, Hà Nội"
	)
);

$th_offices = xe36_footer_parse_lines(
	xe36_get_site_field(
		'footer_offices_th',
		'Sảnh chính Khách sạn Lam Kinh, Đại lộ Lê Lợi, KĐT mới Đông Hương, TP Thanh Hóa'
	)
);

$service_links = xe36_footer_parse_links(
	xe36_get_site_field(
		'footer_links_services',
		"Giới thiệu|/gioi-thieu/\nLiên hệ|/lien-he/\nHướng dẫn đặt vé|/huong-dan-dat-ve-online/"
	)
);

$policy_links = xe36_footer_parse_links(
	xe36_get_site_field(
		'footer_links_policies',
		"Phương thức thanh toán|/phuong-thuc-thanh-toan/\nChính sách hủy & trả vé|/chinh-sach-huy-tra-ve/\nChính sách bảo mật|/chinh-sach-bao-mat/\nĐiều khoản & điều kiện|/dieu-khoan-dieu-kien/"
	)
);

$year = gmdate( 'Y' );
?>
<footer class="xe36-footer" id="xe36-footer" role="contentinfo">
	<div class="xe36-footer__glow" aria-hidden="true"></div>

	<div class="xe36-footer__inner">
		<div class="xe36-footer__grid">
			<div class="xe36-footer__brand">
				<p class="xe36-footer__eyebrow">Xe 36 Limousine</p>
				<?php if ( $company ) : ?>
					<h2 class="xe36-footer__company"><?php echo esc_html( $company ); ?></h2>
				<?php endif; ?>
				<?php if ( $tagline ) : ?>
					<p class="xe36-footer__tagline"><?php echo esc_html( $tagline ); ?></p>
				<?php endif; ?>

				<ul class="xe36-footer__contact">
					<?php if ( $depot ) : ?>
						<li>
							<span class="xe36-footer__label">Xuất bến</span>
							<span><?php echo esc_html( $depot ); ?></span>
						</li>
					<?php endif; ?>
					<li>
						<span class="xe36-footer__label">Tổng đài</span>
						<a href="<?php echo esc_url( $hotline_tel ); ?>"><?php echo esc_html( $hotline_display ); ?></a>
					</li>
					<?php if ( is_string( $phone2 ) && '' !== trim( $phone2 ) ) : ?>
						<li>
							<span class="xe36-footer__label">Hotline / Zalo</span>
							<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\D+/', '', $phone2 ) ); ?>"><?php echo esc_html( $phone2 ); ?></a>
							<?php if ( is_string( $phone3 ) && '' !== trim( $phone3 ) ) : ?>
								<span class="xe36-footer__sep">·</span>
								<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\D+/', '', $phone3 ) ); ?>"><?php echo esc_html( $phone3 ); ?></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( is_string( $email ) && '' !== trim( $email ) ) : ?>
						<li>
							<span class="xe36-footer__label">Email</span>
							<a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
						</li>
					<?php endif; ?>
				</ul>

				<?php
				$legal_lines = xe36_footer_parse_lines( is_string( $legal ) ? $legal : '' );
				if ( $legal_lines ) :
					?>
					<ul class="xe36-footer__legal">
						<?php foreach ( $legal_lines as $line ) : ?>
							<li><?php echo esc_html( $line ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="xe36-footer__col">
				<h3 class="xe36-footer__heading">Chi nhánh Hà Nội</h3>
				<?php if ( $hn_offices ) : ?>
					<ul class="xe36-footer__list">
						<?php foreach ( $hn_offices as $office ) : ?>
							<li><?php echo esc_html( $office ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="xe36-footer__col">
				<h3 class="xe36-footer__heading">Chi nhánh Thanh Hóa</h3>
				<?php if ( $th_offices ) : ?>
					<ul class="xe36-footer__list">
						<?php foreach ( $th_offices as $office ) : ?>
							<li><?php echo esc_html( $office ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $service_links ) : ?>
					<h3 class="xe36-footer__heading xe36-footer__heading--spaced">Dịch vụ</h3>
					<ul class="xe36-footer__nav">
						<?php foreach ( $service_links as $link ) : ?>
							<li>
								<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="xe36-footer__col">
				<h3 class="xe36-footer__heading">Chính sách & hỗ trợ</h3>
				<?php if ( $policy_links ) : ?>
					<ul class="xe36-footer__nav">
						<?php foreach ( $policy_links as $link ) : ?>
							<li>
								<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<a
					class="xe36-footer__gov"
					href="http://online.gov.vn/Home/WebDetails/101083"
					target="_blank"
					rel="noopener noreferrer"
					title="Thông báo Bộ Công Thương"
				>
					<img
						src="<?php echo esc_url( content_url( 'uploads/2022/11/thong-bao-bo-cong-thuong-xe36.png' ) ); ?>"
						alt="Đã thông báo Bộ Công Thương"
						width="140"
						height="53"
						loading="lazy"
						decoding="async"
					/>
				</a>
			</div>
		</div>

		<div class="xe36-footer__bottom">
			<p class="xe36-footer__copy">
				© <?php echo esc_html( $year ); ?> Xe 36 Limousine · 36 Travel. All rights reserved.
			</p>
			<div class="xe36-footer__social" aria-label="Mạng xã hội">
				<a class="xe36-footer__social-link" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer">Zalo</a>
				<a class="xe36-footer__social-link" href="https://www.messenger.com/t/107032312212572" target="_blank" rel="noopener noreferrer">Messenger</a>
				<a class="xe36-footer__social-link" href="<?php echo esc_url( $hotline_tel ); ?>">Hotline</a>
			</div>
		</div>
	</div>
</footer>
