<?php
/**
 * Default content — fallbacks only, never auto-overwrite admin edits.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default values keyed by ACF field name.
 *
 * @return array<string, array<string, mixed>>
 */
function xe36_acf_defaults() {
	return array(
		'homepage' => array(
			'hero_title'                  => 'Xe 36 Limousine',
			'hero_subtitle'               => 'Tuyến Hà Nội ⇌ TP Thanh Hóa / Sầm Sơn / Hải Tiến',
			'hero_highlight'              => 'Đưa đón tận nơi',
			'hero_facts'                  => "Chạy cao tốc CT01 Hà Nội - Ninh Bình - Thanh Hóa\nTần suất: 60 phút/chuyến\nTừ 5h sáng đến 20 giờ tối\nThời gian di chuyển: 3 tiếng",
			'hero_image'                  => null,
			'hero_show_form'              => 0,
			'hero_cta_text'               => 'Đặt vé ngay',
			'hero_cta_url'                => '#home-booking',
			'hero_cta2_text'              => 'Gọi hotline',
			'hero_cta2_url'               => 'tel:19001234',
			'hero_cta3_text'              => 'Nhắn Zalo',
			'hero_cta3_url'               => '',
			'booking_form_title'          => 'Đặt vé nhanh',
			'booking_section_title'       => 'Đặt vé Limousine Hà Nội ⇌ Thanh Hóa nhanh',
			'booking_process_steps'       => "Điền các thông tin và gửi yêu cầu đặt vé\nTổng đài gọi lại tư vấn và xác nhận\nĐặt vé chính thức lên hệ thống",
			'booking_process_note'        => 'Đây mới là yêu cầu đặt vé. Nếu tổng đài chưa liên hệ, vui lòng gửi yêu cầu đặt vé lại.',
			'booking_label_route'         => 'Tuyến',
			'booking_label_date'          => 'Ngày đi',
			'booking_label_time'          => 'Giờ đi',
			'booking_label_name'          => 'Họ và tên',
			'booking_label_phone'         => 'Số điện thoại',
			'booking_label_seat'          => 'Ghế muốn ngồi',
			'booking_label_tickets'       => 'Số vé',
			'booking_submit_text'         => 'Yêu cầu đặt vé',
			'booking_success_text'        => 'Cảm ơn bạn đã đặt vé! Yêu cầu của bạn đã được gửi thành công.',
			'booking_price_front'         => 260000,
			'booking_price_middle'        => 280000,
			'booking_price_back'          => 260000,
			'booking_price_surcharge'     => 50000,
			'gallery_title'               => 'Nội thất, ngoại thất xe Limousine 11 chỗ',
			'gallery_images'              => array(),
			'routes_title'                => 'Lộ trình phổ biến',
			'routes_cta_text'             => 'Đặt vé ngay',
			'offers_title'                => 'Chương trình ưu đãi',
			'offers_items'                => "Khứ hồi trong ngày giảm 20.000đ\nBệnh nhân ung thư giảm 50% giá vé\nSinh viên giảm 20.000đ",
			'offers_video_url'            => 'https://www.youtube.com/shorts/texzSFipzUQ',
			'pricing_title'               => 'Bảng giá & lịch chạy',
			'pricing_schedule_title'      => 'Lịch chạy hàng ngày',
			'pricing_schedule_subtitle'   => 'Ghế hạng thương gia — Xe 36 Limousine',
			'pricing_schedule_route'      => 'Hà Nội ⇌ Thanh Hóa',
			'pricing_schedule_morning'    => "04:00\n05:00\n06:00\n07:00\n08:00\n09:00\n10:00\n11:00\n12:00",
			'pricing_schedule_afternoon'  => "13:00\n14:00\n15:00\n16:00\n17:00\n18:00\n19:00\n20:00",
			'features_title'              => 'Lý do chọn xe 36 Limousine',
			'features_items'              => "Không phải thanh toán trước|Đặt vé giữ chỗ nhanh, thanh toán khi lên xe\nĐón trả tận nơi|Xe trung chuyển đưa đón theo địa chỉ của bạn\nGiá luôn tốt nhất|Đúng giá niêm yết, không tăng giá ngày lễ Tết\nTần suất 1 tiếng 1 chuyến|Nhiều chuyến trong ngày từ sáng sớm đến tối\nĐúng giờ đón trả|Cam kết đúng giờ, đúng ghế đã đặt trên vé\nTổng đài hỗ trợ 24/7|Hotline 1900 888 999 luôn sẵn sàng tư vấn",
			'reviews_title'               => 'Khách hàng nói gì về chúng tôi',
			'reviews_shortcode'           => '[trustindex no-registration=google]',
			'faq_title'                   => 'Câu hỏi thường gặp',
			'faq_items'                   => "Làm thế nào để tôi có thể đặt vé online?\n\nRất đơn giản. Bạn truy cập trang chủ và tiến hành theo 3 bước sau:\n\n– Bước 1: Chọn điểm đón, điểm đến, ngày giờ và loại ghế phù hợp\n– Bước 2: Điền họ tên, số điện thoại rồi gửi yêu cầu đặt vé\n– Bước 3: Chờ tổng đài viên xác nhận — thanh toán sau khi lên xe\n\nHoặc gọi qua tổng đài 1900 888 999 để được tư vấn và hỗ trợ nhanh nhất.\n\n---\n\nLàm sao tôi có thể thanh toán vé?\n\nHiện tại, chúng tôi có các hình thức thanh toán cơ bản sau:\n\n– Chuyển khoản ngân hàng\n– Ví điện tử MoMo\n– Thanh toán trực tiếp tại văn phòng hãng xe\n– Thanh toán khi lên xe (không bắt buộc thanh toán trước)\n\nBạn có thể chọn hình thức phù hợp khi tổng đài viên xác nhận vé.\n\n---\n\nLàm sao để biết tôi đã đặt vé thành công?\n\nSau khi gửi yêu cầu đặt vé, tổng đài viên sẽ xác nhận thông tin và cung cấp vé điện tử qua Zalo, email hoặc SMS.\n\nTrên vé điện tử đã có đầy đủ thông tin: mã vé, vị trí ghế ngồi, số lượng vé, thông tin cá nhân và hotline hỗ trợ. Bạn chỉ cần trình mã vé hoặc số điện thoại trước khi lên xe.\n\n---\n\nTôi nhận vé bằng cách nào?\n\nCó nhiều hình thức nhận vé:\n\n– Nhận vé qua Zalo, Email hoặc SMS\n– Nếu muốn nhận vé giấy: ngày đi đọc tên, số điện thoại hoặc mã vé tại văn phòng nhà xe trước giờ khởi hành\n\n---\n\nVé tôi đặt được cam kết những gì?\n\nVé đặt tại Xe 36 Limousine được cam kết 100% những điều sau:\n\n– Đúng xe Limousine Dcar Solati đời mới VIP\n– Đúng vị trí ghế đã đặt và xác nhận trong vé\n– Đúng giá vé niêm yết trên website\n– Đầy đủ dịch vụ, tiện nghi đã tư vấn và cam kết\n– Đón trả đúng nơi, đúng giờ",
			'section_hero_enabled'        => 1,
			'section_booking_enabled'     => 1,
			'section_routes_enabled'      => 1,
			'section_offers_enabled'      => 1,
			'section_pricing_enabled'     => 1,
			'section_gallery_enabled'     => 1,
			'section_features_enabled'    => 1,
			'section_reviews_enabled'     => 1,
			'section_faq_enabled'         => 1,
			'section_content_enabled'     => 1,
			'section_cta_enabled'         => 1,
			'cta_title'                   => 'Đặt xe limousine ngay hôm nay',
			'cta_subtitle'                => 'Tổng đài hỗ trợ 24/7 — phản hồi nhanh qua điện thoại và Zalo',
			'cta_button_text'             => 'Đặt vé ngay',
			'cta_button_url'              => '#home-booking',
			'cta_call_text'               => 'Gọi hotline',
			'cta_zalo_text'               => 'Nhắn Zalo',
		),
		'site'     => array(
			'hotline'                 => '1900888999',
			'hotline_display'         => '1900 888 999',
			'zalo_url'                => 'https://zalo.me/0367503636',
			'booking_email'           => 'booking.36limousine@gmail.com',
			'footer_company'          => 'CÔNG TY CỔ PHẦN 36 TRAVEL',
			'footer_tagline'          => 'Xe limousine VIP Hà Nội ⇔ Thanh Hóa ⇔ Sầm Sơn',
			'footer_depot'            => 'Ki ốt 10, Chung cư N5 - KĐT Đồng Tàu, Hoàng Mai, Hà Nội',
			'footer_email'            => '36limousine@gmail.com',
			'footer_phone_2'          => '0367503636',
			'footer_phone_3'          => '0343825678',
			'footer_legal'            => "DKKD số 0110122730 do Sở KH&ĐT Hà Nội cấp ngày 20/09/2022\nGiấy phép KD vận tải bằng ô tô số 9595/GPKDVT do Sở GTVT Hà Nội cấp ngày 18/01/2023",
			'footer_offices_hn'       => "23 Tú Mỡ, Phường Yên Hòa, Hà Nội\n56 Phố Vọng, P. Phương Mai, Đống Đa, Hà Nội\n51 P. Minh Khai, Minh Khai, Hai Bà Trưng, Hà Nội",
			'footer_offices_th'       => 'Sảnh chính Khách sạn Lam Kinh, Đại lộ Lê Lợi, KĐT mới Đông Hương, TP Thanh Hóa',
			'footer_links_services'   => "Giới thiệu|/gioi-thieu/\nLiên hệ|/lien-he/\nHướng dẫn đặt vé|/huong-dan-dat-ve-online/",
			'footer_links_policies'   => "Phương thức thanh toán|/phuong-thuc-thanh-toan/\nChính sách hủy & trả vé|/chinh-sach-huy-tra-ve/\nChính sách bảo mật|/chinh-sach-bao-mat/\nĐiều khoản & điều kiện|/dieu-khoan-dieu-kien/",
		),
	);
}
