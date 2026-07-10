<?php
/**
 * Editor configuration.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
