<?php
/**
 * ACF field group: Giới thiệu page.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register about page fields.
 */
function xe36_acf_register_about_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_xe36_about',
			'title'                 => 'Giới thiệu — Xe 36',
			'fields'                => array(
				array(
					'key'   => 'field_xe36_about_tab_hero',
					'label' => 'Hero',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_about_hero_eyebrow',
					'label' => 'Eyebrow',
					'name'  => 'about_hero_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_hero_title',
					'label' => 'Tiêu đề',
					'name'  => 'about_hero_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_hero_text',
					'label' => 'Mô tả',
					'name'  => 'about_hero_text',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_xe36_about_hero_cta_text',
					'label' => 'Nút CTA — chữ',
					'name'  => 'about_hero_cta_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_hero_cta_url',
					'label' => 'Nút CTA — link',
					'name'  => 'about_hero_cta_url',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_xe36_about_hero_image',
					'label'         => 'Ảnh hero',
					'name'          => 'about_hero_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_xe36_about_tab_benefits',
					'label' => 'Ưu điểm',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_about_benefits_title',
					'label' => 'Tiêu đề',
					'name'  => 'about_benefits_title',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_about_benefits',
					'label'        => 'Danh sách (Tiêu đề|Mô tả)',
					'name'         => 'about_benefits',
					'type'         => 'textarea',
					'rows'         => 6,
					'instructions' => 'Mỗi dòng: <code>Tiêu đề|Mô tả</code>',
				),
				array(
					'key'   => 'field_xe36_about_tab_services',
					'label' => 'Dịch vụ',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_about_services_title',
					'label' => 'Eyebrow',
					'name'  => 'about_services_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_services_sub',
					'label' => 'Tiêu đề',
					'name'  => 'about_services_sub',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_about_services',
					'label'        => 'Danh sách dịch vụ',
					'name'         => 'about_services',
					'type'         => 'textarea',
					'rows'         => 6,
					'instructions' => 'Mỗi dòng: <code>Tiêu đề|Mô tả|/link/|URL ảnh</code>',
				),
				array(
					'key'   => 'field_xe36_about_tab_gallery',
					'label' => 'Nội thất',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_about_gallery_title',
					'label' => 'Tiêu đề',
					'name'  => 'about_gallery_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_gallery_text',
					'label' => 'Mô tả',
					'name'  => 'about_gallery_text',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_xe36_about_gallery_images',
					'label'        => 'URL ảnh (mỗi dòng 1 URL)',
					'name'         => 'about_gallery_images',
					'type'         => 'textarea',
					'rows'         => 6,
				),
				array(
					'key'   => 'field_xe36_about_tab_cta',
					'label' => 'CTA',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_about_cta_title',
					'label' => 'Tiêu đề CTA',
					'name'  => 'about_cta_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_cta_text',
					'label' => 'Mô tả CTA',
					'name'  => 'about_cta_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_xe36_about_cta_btn_text',
					'label' => 'Nút — chữ',
					'name'  => 'about_cta_btn_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_cta_btn_url',
					'label' => 'Nút — link',
					'name'  => 'about_cta_btn_url',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_about_tab_offices',
					'label' => 'Văn phòng',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_about_offices_title',
					'label' => 'Tiêu đề văn phòng',
					'name'  => 'about_offices_title',
					'type'  => 'text',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/about.php',
					),
				),
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => '36',
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
