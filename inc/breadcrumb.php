<?php
/**
 * Breadcrumb trail for custom UI pages (not homepage).
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether breadcrumbs should render on the current view.
 *
 * @return bool
 */
function xe36_should_show_breadcrumb() {
	if ( is_front_page() || is_404() ) {
		return false;
	}

	if ( is_page_template( 'page-templates/ui-preview.php' ) ) {
		return false;
	}

	/**
	 * Filter breadcrumb visibility.
	 *
	 * @param bool $show Whether to show.
	 */
	return (bool) apply_filters( 'xe36_show_breadcrumb', true );
}

/**
 * Build breadcrumb items: each item is [ 'label' => string, 'url' => string|null ].
 * Last item has url = null (current page).
 *
 * @return array<int, array{label: string, url: ?string}>
 */
function xe36_breadcrumb_items() {
	$home = array(
		'label' => __( 'Trang chủ', 'oceanwp-child' ),
		'url'   => home_url( '/' ),
	);

	$items = array( $home );

	if ( is_singular( 'post' ) ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		if ( $posts_page_id > 0 ) {
			$items[] = array(
				'label' => get_the_title( $posts_page_id ) ?: __( 'Tin tức', 'oceanwp-child' ),
				'url'   => get_permalink( $posts_page_id ),
			);
		}

		$cats = get_the_category();
		if ( ! empty( $cats ) && $cats[0] instanceof WP_Term ) {
			$items[] = array(
				'label' => $cats[0]->name,
				'url'   => get_category_link( $cats[0]->term_id ),
			);
		}

		$items[] = array(
			'label' => get_the_title(),
			'url'   => null,
		);
	} elseif ( is_page() ) {
		$ancestors = array_reverse( get_post_ancestors( get_queried_object_id() ) );
		foreach ( $ancestors as $ancestor_id ) {
			$items[] = array(
				'label' => get_the_title( $ancestor_id ),
				'url'   => get_permalink( $ancestor_id ),
			);
		}

		$items[] = array(
			'label' => get_the_title(),
			'url'   => null,
		);
	} elseif ( is_home() && ! is_front_page() ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		$label         = $posts_page_id > 0 ? get_the_title( $posts_page_id ) : __( 'Tin tức', 'oceanwp-child' );
		$items[]       = array(
			'label' => $label ?: __( 'Tin tức', 'oceanwp-child' ),
			'url'   => null,
		);
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		if ( $posts_page_id > 0 ) {
			$items[] = array(
				'label' => get_the_title( $posts_page_id ) ?: __( 'Tin tức', 'oceanwp-child' ),
				'url'   => get_permalink( $posts_page_id ),
			);
		}

		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$items[] = array(
				'label' => $term->name,
				'url'   => null,
			);
		}
	} elseif ( is_author() ) {
		$author = get_queried_object();
		$items[] = array(
			'label' => $author instanceof WP_User ? $author->display_name : __( 'Tác giả', 'oceanwp-child' ),
			'url'   => null,
		);
	} elseif ( is_date() ) {
		$items[] = array(
			'label' => get_the_archive_title(),
			'url'   => null,
		);
	} elseif ( is_search() ) {
		$items[] = array(
			'label' => sprintf(
				/* translators: %s: search query */
				__( 'Tìm kiếm: %s', 'oceanwp-child' ),
				get_search_query()
			),
			'url'   => null,
		);
	} else {
		$title = get_the_title();
		if ( ! is_string( $title ) || '' === trim( $title ) ) {
			$title = wp_get_document_title();
		}
		$items[] = array(
			'label' => wp_strip_all_tags( $title ),
			'url'   => null,
		);
	}

	/**
	 * Filter breadcrumb items.
	 *
	 * @param array $items Trail items.
	 */
	return apply_filters( 'xe36_breadcrumb_items', $items );
}

/**
 * Render breadcrumb markup + optional JSON-LD.
 *
 * @param array $args {
 *     Optional. Extra classes.
 *     @type string $class Extra class on nav.
 * }
 */
function xe36_the_breadcrumb( $args = array() ) {
	if ( ! xe36_should_show_breadcrumb() ) {
		return;
	}

	$items = xe36_breadcrumb_items();
	if ( count( $items ) < 2 ) {
		return;
	}

	$args  = wp_parse_args(
		$args,
		array(
			'class' => '',
		)
	);
	$class = trim( 'xe36-breadcrumb ' . $args['class'] );

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array(),
	);

	echo '<nav class="' . esc_attr( $class ) . '" aria-label="' . esc_attr__( 'Đường dẫn', 'oceanwp-child' ) . '">';
	echo '<ol class="xe36-breadcrumb__list">';

	foreach ( $items as $index => $item ) {
		$label = isset( $item['label'] ) ? wp_strip_all_tags( (string) $item['label'] ) : '';
		$url   = isset( $item['url'] ) ? $item['url'] : null;
		$pos   = $index + 1;

		if ( '' === $label ) {
			continue;
		}

		$is_last = ( null === $url ) || ( $index === count( $items ) - 1 );

		echo '<li class="xe36-breadcrumb__item">';
		if ( ! $is_last && is_string( $url ) && '' !== $url ) {
			echo '<a class="xe36-breadcrumb__link" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
			$schema['itemListElement'][] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'name'     => $label,
				'item'     => $url,
			);
		} else {
			echo '<span class="xe36-breadcrumb__current" aria-current="page">' . esc_html( $label ) . '</span>';
			$schema['itemListElement'][] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'name'     => $label,
			);
		}
		echo '</li>';
	}

	echo '</ol>';
	echo '</nav>';

	if ( ! empty( $schema['itemListElement'] ) ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
	}
}
