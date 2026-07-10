<?php
/**
 * ACF field group: Liên hệ & site-wide settings.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register site settings field group.
 */
function xe36_acf_register_site_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_xe36_site',
			'title'    => 'Liên hệ & thông tin chung',
			'fields'   => array(
				array(
					'key'   => 'field_xe36_tab_contact',
					'label' => 'Liên hệ',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_xe36_hotline',
					'label'        => 'Hotline (tel:)',
					'name'         => 'hotline',
					'type'         => 'text',
					'instructions' => 'Dạng số gọi: 1900888999. Dùng cho link tel:.',
				),
				array(
					'key'   => 'field_xe36_hotline_display',
					'label' => 'Hotline hiển thị',
					'name'  => 'hotline_display',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_zalo_url',
					'label' => 'Link Zalo',
					'name'  => 'zalo_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_xe36_booking_email',
					'label' => 'Email nhận đặt vé',
					'name'  => 'booking_email',
					'type'  => 'email',
				),
				array(
					'key'   => 'field_xe36_tab_footer',
					'label' => 'Footer',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_footer_company',
					'label' => 'Tên công ty',
					'name'  => 'footer_company',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_footer_tagline',
					'label' => 'Dòng mô tả ngắn',
					'name'  => 'footer_tagline',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_footer_depot',
					'label' => 'Địa chỉ xuất bến',
					'name'  => 'footer_depot',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_footer_email',
					'label' => 'Email hiển thị footer',
					'name'  => 'footer_email',
					'type'  => 'email',
				),
				array(
					'key'   => 'field_xe36_footer_phone_2',
					'label' => 'Hotline / Zalo 1',
					'name'  => 'footer_phone_2',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_footer_phone_3',
					'label' => 'Hotline / Zalo 2',
					'name'  => 'footer_phone_3',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_footer_legal',
					'label'        => 'Thông tin pháp lý (mỗi dòng 1 mục)',
					'name'         => 'footer_legal',
					'type'         => 'textarea',
					'rows'         => 3,
				),
				array(
					'key'          => 'field_xe36_footer_offices_hn',
					'label'        => 'Chi nhánh Hà Nội (mỗi dòng 1 địa chỉ)',
					'name'         => 'footer_offices_hn',
					'type'         => 'textarea',
					'rows'         => 4,
				),
				array(
					'key'          => 'field_xe36_footer_offices_th',
					'label'        => 'Chi nhánh Thanh Hóa (mỗi dòng 1 địa chỉ)',
					'name'         => 'footer_offices_th',
					'type'         => 'textarea',
					'rows'         => 3,
				),
				array(
					'key'          => 'field_xe36_footer_links_services',
					'label'        => 'Link dịch vụ (Label|URL)',
					'name'         => 'footer_links_services',
					'type'         => 'textarea',
					'rows'         => 4,
					'instructions' => 'Mỗi dòng: <code>Nhãn|/duong-dan/</code>',
				),
				array(
					'key'          => 'field_xe36_footer_links_policies',
					'label'        => 'Link chính sách (Label|URL)',
					'name'         => 'footer_links_policies',
					'type'         => 'textarea',
					'rows'         => 5,
					'instructions' => 'Mỗi dòng: <code>Nhãn|/duong-dan/</code>',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'xe36-site',
					),
				),
			),
			'active'   => true,
		)
	);
}
