<?php
/**
 * Template Name: Liên hệ
 * Description: Trang liên hệ — form đơn giản, không phụ thuộc Elementor.
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();

get_template_part( 'template-parts/contact/hero' );
get_template_part( 'template-parts/contact/main' );
get_template_part( 'template-parts/contact/offices' );

xe36_custom_ui_shell_close();

get_footer();
