<?php
/**
 * Blog posts index (when a Posts page is set).
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();

get_template_part( 'template-parts/archive/hero' );
get_template_part( 'template-parts/archive/loop' );

xe36_custom_ui_shell_close();

get_footer();
