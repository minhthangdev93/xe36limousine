<?php
/**
 * ACF field group: Vận chuyển hàng hóa page.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register cargo page fields.
 */
function xe36_acf_register_cargo_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_xe36_cargo',
			'title'                 => 'Vận chuyển hàng hóa — Xe 36',
			'fields'                => array(
				array(
					'key'   => 'field_xe36_cargo_tab_hero',
					'label' => 'Hero',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_cargo_hero_eyebrow',
					'label' => 'Eyebrow',
					'name'  => 'cargo_hero_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_hero_title',
					'label' => 'Tiêu đề',
					'name'  => 'cargo_hero_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_hero_text',
					'label' => 'Mô tả',
					'name'  => 'cargo_hero_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_xe36_cargo_hero_cta_text',
					'label' => 'Nút CTA — chữ',
					'name'  => 'cargo_hero_cta_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_hero_cta_url',
					'label' => 'Nút CTA — link',
					'name'  => 'cargo_hero_cta_url',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_xe36_cargo_hero_image',
					'label'         => 'Ảnh hero',
					'name'          => 'cargo_hero_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_xe36_cargo_tab_pricing',
					'label' => 'Bảng giá',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_cargo_pricing_title',
					'label' => 'Tiêu đề bảng giá',
					'name'  => 'cargo_pricing_title',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_cargo_pricing_images',
					'label'        => 'URL ảnh bảng giá (mỗi dòng 1 URL)',
					'name'         => 'cargo_pricing_images',
					'type'         => 'textarea',
					'rows'         => 4,
				),
				array(
					'key'   => 'field_xe36_cargo_tab_intro',
					'label' => 'Giới thiệu',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_cargo_intro_title',
					'label' => 'Tiêu đề',
					'name'  => 'cargo_intro_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_intro_text',
					'label' => 'Nội dung (cách đoạn bằng dòng trống)',
					'name'  => 'cargo_intro_text',
					'type'  => 'textarea',
					'rows'  => 6,
				),
				array(
					'key'           => 'field_xe36_cargo_intro_image',
					'label'         => 'Ảnh dưới giới thiệu',
					'name'          => 'cargo_intro_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_xe36_cargo_tab_features',
					'label' => 'Cam kết',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_cargo_features_title',
					'label' => 'Tiêu đề',
					'name'  => 'cargo_features_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_features_lead',
					'label' => 'Mô tả ngắn',
					'name'  => 'cargo_features_lead',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_cargo_features',
					'label'        => 'Danh sách (Tiêu đề|Mô tả)',
					'name'         => 'cargo_features',
					'type'         => 'textarea',
					'rows'         => 10,
					'instructions' => 'Mỗi dòng: <code>Tiêu đề|Mô tả</code>',
				),
				array(
					'key'   => 'field_xe36_cargo_tab_offices',
					'label' => 'Văn phòng',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_cargo_offices_title',
					'label' => 'Tiêu đề văn phòng',
					'name'  => 'cargo_offices_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_tab_cta',
					'label' => 'CTA',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_cargo_cta_title',
					'label' => 'Tiêu đề CTA',
					'name'  => 'cargo_cta_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_cta_text',
					'label' => 'Mô tả CTA',
					'name'  => 'cargo_cta_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_xe36_cargo_cta_btn_text',
					'label' => 'Nút — chữ',
					'name'  => 'cargo_cta_btn_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_cargo_cta_btn_url',
					'label' => 'Nút — link',
					'name'  => 'cargo_cta_btn_url',
					'type'  => 'text',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/cargo.php',
					),
				),
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => '1297',
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
