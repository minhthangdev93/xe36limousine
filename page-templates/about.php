<?php
/**
 * Template Name: Giới thiệu
 * Description: Trang giới thiệu Xe 36 Limousine — PHP, không phụ thuộc Elementor.
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();

get_template_part( 'template-parts/about/hero' );
get_template_part( 'template-parts/about/benefits' );
get_template_part( 'template-parts/about/services' );
get_template_part( 'template-parts/about/gallery' );
get_template_part( 'template-parts/about/cta' );
get_template_part( 'template-parts/about/offices' );

xe36_custom_ui_shell_close();

get_footer();
