<?php
/**
 * Template Name: Vận chuyển hàng hóa
 * Description: Landing dịch vụ vận chuyển hàng hóa — PHP, đồng bộ template hành khách.
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();

get_template_part( 'template-parts/cargo/hero' );
get_template_part( 'template-parts/cargo/pricing' );
get_template_part( 'template-parts/cargo/features' );
get_template_part( 'template-parts/cargo/offices' );
get_template_part( 'template-parts/cargo/cta' );

xe36_custom_ui_shell_close();

get_footer();
