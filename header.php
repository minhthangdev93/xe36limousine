<?php
/**
 * The Header for our theme.
 *
 * @package OceanWP WordPress theme
 */

?>
<!DOCTYPE html>
<html class="<?php echo esc_attr( oceanwp_html_classes() ); ?>" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Google Tag Manager (delayed for LCP) -->
<script>
window.dataLayer = window.dataLayer || [];
window.xe36LoadGTM = function () {
	if (window.xe36GtmLoaded) return;
	window.xe36GtmLoaded = true;
	window.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
	var f = document.getElementsByTagName('script')[0];
	var j = document.createElement('script');
	j.async = true;
	j.src = 'https://www.googletagmanager.com/gtm.js?id=GTM-M9S8CX7';
	f.parentNode.insertBefore(j, f);
};
if ('requestIdleCallback' in window) {
	requestIdleCallback(window.xe36LoadGTM, { timeout: 3500 });
} else {
	window.addEventListener('load', function () { setTimeout(window.xe36LoadGTM, 1); });
}
</script>
<!-- End Google Tag Manager -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php oceanwp_schema_markup( 'html' ); ?>>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9S8CX7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

	<?php wp_body_open(); ?>

	<?php do_action( 'ocean_before_outer_wrap' ); ?>

	<div id="outer-wrap" class="site clr">

		<a class="skip-link screen-reader-text" href="#main"><?php echo esc_html( oceanwp_theme_strings( 'owp-string-header-skip-link', false ) ); ?></a>

		<?php do_action( 'ocean_before_wrap' ); ?>

		<div id="wrap" class="clr">

			<?php do_action( 'ocean_top_bar' ); ?>

			<?php get_template_part( 'template-parts/header/site-header' ); ?>

			<?php do_action( 'ocean_before_main' ); ?>

			<main id="main" class="site-main clr"<?php oceanwp_schema_markup( 'main' ); ?> role="main">

				<?php do_action( 'ocean_page_header' ); ?>
