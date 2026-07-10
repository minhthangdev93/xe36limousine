<?php
/**
 * Homepage section registry.
 *
 * Reorder, enable or disable sections here before content is added.
 * Each key maps to template-parts/homepage/{key}.php
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

return array(
	'hero'     => array(
		'label'   => 'Hero',
		'enabled' => true,
	),
	'booking'  => array(
		'label'   => 'Đặt vé',
		'enabled' => true,
	),
	'pricing'  => array(
		'label'   => 'Bảng giá & lịch chạy',
		'enabled' => true,
	),
	'gallery'  => array(
		'label'   => 'Nội / ngoại thất',
		'enabled' => true,
	),
	'routes'   => array(
		'label'   => 'Lộ trình phổ biến',
		'enabled' => true,
	),
	'offers'   => array(
		'label'   => 'Chương trình ưu đãi',
		'enabled' => true,
	),
	'features' => array(
		'label'   => 'Lý do chọn xe 36',
		'enabled' => true,
	),
	'reviews'  => array(
		'label'   => 'Khách hàng nói gì',
		'enabled' => true,
	),
	'faq'      => array(
		'label'   => 'Câu hỏi thường gặp',
		'enabled' => true,
	),
	'content'  => array(
		'label'   => 'Nội dung SEO',
		'enabled' => true,
	),
	'cta'      => array(
		'label'   => 'Kêu gọi hành động',
		'enabled' => true,
	),
);
