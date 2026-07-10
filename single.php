<?php
/**
 * Single post template.
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/single/hero' );
	get_template_part( 'template-parts/single/content' );
	get_template_part( 'template-parts/single/related' );
	get_template_part( 'template-parts/single/cta' );
endwhile;

xe36_custom_ui_shell_close();

get_footer();
