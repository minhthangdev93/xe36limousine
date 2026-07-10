<?php
/**
 * Site header markup.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$hotline_raw     = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_display = xe36_get_site_field( 'hotline_display', '1900 888 999' );
if ( ! is_string( $hotline_display ) || '' === trim( $hotline_display ) || '1900 xxxx' === trim( $hotline_display ) ) {
	$hotline_display = '1900 888 999';
}
$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';

$logo_id  = (int) get_theme_mod( 'custom_logo' );
$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
if ( ! $logo_url && $logo_id ) {
	$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
}
if ( ! $logo_url ) {
	$logo_url = 'https://xe36limousine.vn/wp-content/uploads/2022/12/logo-xe-36-travel.png';
}
$logo_alt = get_bloginfo( 'name', 'display' );

$has_menu = has_nav_menu( 'main_menu' );
?>
<header class="xe36-header" id="xe36-header" data-xe36-header>
	<div class="xe36-header__bar">
		<div class="xe36-header__inner">
			<a class="xe36-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img
					class="xe36-header__logo"
					src="<?php echo esc_url( $logo_url ); ?>"
					alt="<?php echo esc_attr( $logo_alt ); ?>"
					width="160"
					height="48"
					decoding="async"
					fetchpriority="low"
				/>
			</a>

			<?php if ( $has_menu ) : ?>
				<nav class="xe36-header__nav" aria-label="<?php echo esc_attr__( 'Menu chính', 'oceanwp' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'main_menu',
							'container'       => false,
							'menu_class'      => 'xe36-header__menu',
							'depth'           => 2,
							'fallback_cb'     => false,
							'xe36_header_nav' => true,
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<div class="xe36-header__actions">
				<a class="xe36-header__hotline" href="<?php echo esc_url( $hotline_tel ); ?>">
					<span class="xe36-header__hotline-icon" aria-hidden="true"></span>
					<span class="xe36-header__hotline-text"><?php echo esc_html( $hotline_display ); ?></span>
				</a>

				<button
					type="button"
					class="xe36-header__toggle"
					data-xe36-nav-toggle
					aria-expanded="false"
					aria-controls="xe36-header-drawer"
					aria-label="<?php echo esc_attr__( 'Mở menu', 'oceanwp' ); ?>"
				>
					<span class="xe36-header__toggle-bar" aria-hidden="true"></span>
					<span class="xe36-header__toggle-bar" aria-hidden="true"></span>
					<span class="xe36-header__toggle-bar" aria-hidden="true"></span>
				</button>
			</div>
		</div>
	</div>

	<?php if ( $has_menu ) : ?>
		<div class="xe36-header__drawer" id="xe36-header-drawer" data-xe36-nav-drawer hidden>
			<nav class="xe36-header__drawer-nav" aria-label="<?php echo esc_attr__( 'Menu mobile', 'oceanwp' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'main_menu',
						'container'       => false,
						'menu_class'      => 'xe36-header__drawer-menu',
						'depth'           => 2,
						'fallback_cb'     => false,
						'xe36_header_nav' => true,
					)
				);
				?>
			</nav>
			<a class="xe36-header__drawer-hotline" href="<?php echo esc_url( $hotline_tel ); ?>">
				Gọi <?php echo esc_html( $hotline_display ); ?>
			</a>
		</div>
	<?php endif; ?>
</header>
