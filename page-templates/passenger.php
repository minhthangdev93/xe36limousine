<?php
/**
 * Template Name: Vận chuyển hành khách
 * Description: Landing dịch vụ đưa đón hành khách — PHP, không phụ thuộc Elementor.
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();

get_template_part( 'template-parts/passenger/hero' );
get_template_part( 'template-parts/passenger/pricing' );
get_template_part( 'template-parts/passenger/features' );
get_template_part( 'template-parts/passenger/offices' );
get_template_part( 'template-parts/passenger/cta' );

xe36_custom_ui_shell_close();

get_footer();
