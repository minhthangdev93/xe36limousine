<?php
/**
 * Front page — custom UI shell (isolated from OceanWP layout).
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();

foreach ( array_keys( xe36_get_homepage_sections() ) as $section_slug ) {
	xe36_render_homepage_section( $section_slug );
}

xe36_custom_ui_shell_close();

get_footer();
