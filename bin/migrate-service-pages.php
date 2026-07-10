<?php
/**
 * Production migration: convert service posts → pages + assign templates.
 *
 * Run once after deploying theme code:
 *   wp eval-file wp-content/themes/oceanwp-child/bin/migrate-service-pages.php
 *
 * Safe to re-run (idempotent).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$map = array(
	'van-chuyen-hanh-khach' => 'page-templates/passenger.php',
	'van-chuyen-hang-hoa'   => 'page-templates/cargo.php',
);

foreach ( $map as $slug => $template ) {
	$post = get_page_by_path( $slug, OBJECT, array( 'page', 'post' ) );

	if ( ! $post ) {
		$q = new WP_Query(
			array(
				'name'           => $slug,
				'post_type'      => array( 'page', 'post' ),
				'post_status'    => array( 'publish', 'draft', 'private' ),
				'posts_per_page' => 1,
			)
		);
		$post = $q->posts[0] ?? null;
	}

	if ( ! $post ) {
		fwrite( STDOUT, "[SKIP] Not found: {$slug}\n" );
		continue;
	}

	$updates = array( 'ID' => (int) $post->ID );

	if ( 'page' !== $post->post_type ) {
		$updates['post_type'] = 'page';
	}

	$result = wp_update_post( $updates, true );
	if ( is_wp_error( $result ) ) {
		fwrite( STDOUT, "[ERR] {$slug}: " . $result->get_error_message() . "\n" );
		continue;
	}

	update_post_meta( (int) $post->ID, '_wp_page_template', $template );

	fwrite(
		STDOUT,
		sprintf(
			"[OK] #%d %s → page + %s\n",
			(int) $post->ID,
			$slug,
			$template
		)
	);
}

// Fix menu items that still reference old posts by URL slug.
$menus = wp_get_nav_menus();
foreach ( $menus as $menu ) {
	$items = wp_get_nav_menu_items( $menu->term_id );
	if ( ! $items ) {
		continue;
	}

	foreach ( $items as $item ) {
		$path = wp_parse_url( (string) $item->url, PHP_URL_PATH );
		$path = is_string( $path ) ? trim( $path, '/' ) : '';
		if ( ! isset( $map[ $path ] ) ) {
			continue;
		}

		$page = get_page_by_path( $path, OBJECT, 'page' );
		if ( ! $page ) {
			continue;
		}

		update_post_meta( (int) $item->ID, '_menu_item_type', 'post_type' );
		update_post_meta( (int) $item->ID, '_menu_item_object', 'page' );
		update_post_meta( (int) $item->ID, '_menu_item_object_id', (int) $page->ID );
		update_post_meta( (int) $item->ID, '_menu_item_url', '' );

		fwrite( STDOUT, "[MENU] #{$item->ID} → page #{$page->ID} ({$path})\n" );
	}
}

flush_rewrite_rules( false );
fwrite( STDOUT, "[DONE] Rewrite flushed.\n" );
