<?php
/**
 * [readmore] shortcode — smooth expand / collapse.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue readmore assets once per request.
 */
function xe36_enqueue_readmore_assets() {
	static $enqueued = false;

	if ( $enqueued ) {
		return;
	}

	$enqueued = true;
	$version  = xe36_theme_version();

	wp_enqueue_style(
		'xe36-readmore',
		xe36_theme_uri( 'assets/css/readmore.css' ),
		array( 'xe36-variables', 'xe36-components' ),
		$version
	);

	wp_enqueue_script(
		'xe36-readmore',
		xe36_theme_uri( 'assets/js/readmore.js' ),
		array(),
		$version,
		true
	);
}

/**
 * Render expandable content shortcode.
 *
 * @param array       $atts    Shortcode attributes.
 * @param string|null $content Shortcode content.
 * @return string
 */
function xe36_readmore_shortcode( $atts, $content = null ) {
	if ( null === $content || '' === trim( $content ) ) {
		return '';
	}

	xe36_enqueue_readmore_assets();

	$atts = shortcode_atts(
		array(
			'height' => 320,
			'more'   => 'Đọc thêm',
			'less'   => 'Thu gọn',
		),
		$atts,
		'readmore'
	);

	$height = max( 120, (int) $atts['height'] );
	$more   = (string) $atts['more'];
	$less   = (string) $atts['less'];

	$raw = $content;

	// Optional classic <!--more--> split: preview always visible, rest expands.
	$parts   = explode( '<!--more-->', $raw, 2 );
	$preview = isset( $parts[0] ) ? $parts[0] : $raw;
	$rest    = isset( $parts[1] ) ? $parts[1] : '';

	$format = static function ( $html ) {
		$html = shortcode_unautop( $html );
		$html = do_shortcode( $html );
		$html = wpautop( $html );
		return $html;
	};

	$preview_html = $format( $preview );
	$rest_html    = '' !== trim( $rest ) ? $format( $rest ) : '';

	$body_html = $preview_html . $rest_html;

	ob_start();
	?>
	<div
		class="readmore-wrapper"
		data-collapsed-height="<?php echo esc_attr( (string) $height ); ?>"
		data-more="<?php echo esc_attr( $more ); ?>"
		data-less="<?php echo esc_attr( $less ); ?>"
	>
		<div class="readmore-panel is-collapsed">
			<div class="readmore-body">
				<?php echo $body_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- filtered editor HTML. ?>
			</div>
			<div class="readmore-fade" aria-hidden="true"></div>
		</div>
		<div class="readmore-actions">
			<button type="button" class="readmore-btn btn btn--primary" hidden>
				<?php echo esc_html( $more ); ?>
			</button>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'readmore', 'xe36_readmore_shortcode' );
