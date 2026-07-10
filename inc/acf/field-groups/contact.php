<?php
/**
 * ACF field group: Liên hệ page.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register contact page fields.
 */
function xe36_acf_register_contact_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_xe36_contact',
			'title'                 => 'Liên hệ — Xe 36',
			'fields'                => array(
				array(
					'key'   => 'field_xe36_contact_tab_hero',
					'label' => 'Hero',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_contact_hero_eyebrow',
					'label' => 'Eyebrow',
					'name'  => 'contact_hero_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_contact_hero_title',
					'label' => 'Tiêu đề',
					'name'  => 'contact_hero_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_contact_hero_text',
					'label' => 'Mô tả',
					'name'  => 'contact_hero_text',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_xe36_contact_tab_form',
					'label' => 'Form',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_contact_info_title',
					'label' => 'Tiêu đề cột thông tin',
					'name'  => 'contact_info_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_contact_form_title',
					'label' => 'Tiêu đề form',
					'name'  => 'contact_form_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_contact_form_lead',
					'label' => 'Mô tả form',
					'name'  => 'contact_form_lead',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_contact_cta_btn_text',
					'label' => 'Nút gửi — chữ',
					'name'  => 'contact_cta_btn_text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_xe36_contact_success_text',
					'label' => 'Thông báo gửi thành công',
					'name'  => 'contact_success_text',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_xe36_contact_tab_offices',
					'label' => 'Văn phòng',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_xe36_contact_offices_title',
					'label' => 'Tiêu đề văn phòng',
					'name'  => 'contact_offices_title',
					'type'  => 'text',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/contact.php',
					),
				),
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => '135',
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
