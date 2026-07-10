<?php
/**
 * ACF field group: Vận chuyển hành khách page.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register passenger page fields.
 */
function xe36_acf_register_passenger_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_xe36_passenger',
			'title'                 => 'Vận chuyển hành khách — Xe 36',
			'fields'                => array(
				array(
					'key'   => 'field_xe36_pax_tab_hero',
					'label' => 'Hero',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_pax_hero_eyebrow',
					'label' => 'Eyebrow',
					'name'  => 'pax_hero_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_pax_hero_title',
					'label' => 'Tiêu đề',
					'name'  => 'pax_hero_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_pax_hero_text',
					'label' => 'Mô tả',
					'name'  => 'pax_hero_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_xe36_pax_hero_cta_text',
					'label' => 'Nút CTA — chữ',
					'name'  => 'pax_hero_cta_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_pax_hero_cta_url',
					'label' => 'Nút CTA — link',
					'name'  => 'pax_hero_cta_url',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_xe36_pax_hero_image',
					'label'         => 'Ảnh hero',
					'name'          => 'pax_hero_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_xe36_pax_tab_pricing',
					'label' => 'Bảng giá',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_pax_pricing_title',
					'label' => 'Tiêu đề bảng giá',
					'name'  => 'pax_pricing_title',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_xe36_pax_pricing_image',
					'label'         => 'Ảnh bảng giá',
					'name'          => 'pax_pricing_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_xe36_pax_tab_intro',
					'label' => 'Giới thiệu',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_pax_intro_title',
					'label' => 'Tiêu đề',
					'name'  => 'pax_intro_title',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_pax_intro_text',
					'label'        => 'Nội dung (cách đoạn bằng dòng trống)',
					'name'         => 'pax_intro_text',
					'type'         => 'textarea',
					'rows'         => 6,
				),
				array(
					'key'           => 'field_xe36_pax_intro_image',
					'label'         => 'Ảnh dưới giới thiệu',
					'name'          => 'pax_intro_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_xe36_pax_tab_features',
					'label' => 'Cam kết',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_pax_features_title',
					'label' => 'Tiêu đề',
					'name'  => 'pax_features_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_pax_features_lead',
					'label' => 'Mô tả ngắn',
					'name'  => 'pax_features_lead',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_pax_features',
					'label'        => 'Danh sách (Tiêu đề|Mô tả)',
					'name'         => 'pax_features',
					'type'         => 'textarea',
					'rows'         => 12,
					'instructions' => 'Mỗi dòng: <code>Tiêu đề|Mô tả</code>',
				),
				array(
					'key'   => 'field_xe36_pax_tab_offices',
					'label' => 'Văn phòng',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_pax_offices_title',
					'label' => 'Tiêu đề văn phòng',
					'name'  => 'pax_offices_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_pax_tab_cta',
					'label' => 'CTA',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_pax_cta_title',
					'label' => 'Tiêu đề CTA',
					'name'  => 'pax_cta_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_pax_cta_text',
					'label' => 'Mô tả CTA',
					'name'  => 'pax_cta_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_xe36_pax_cta_btn_text',
					'label' => 'Nút — chữ',
					'name'  => 'pax_cta_btn_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_pax_cta_btn_url',
					'label' => 'Nút — link',
					'name'  => 'pax_cta_btn_url',
					'type'  => 'text',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/passenger.php',
					),
				),
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => '1302',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
