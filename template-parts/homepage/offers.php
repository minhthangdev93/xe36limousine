<?php
/**
 * Homepage section: Promotions — text left, YouTube Shorts right.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$title     = xe36_get_homepage_field( 'offers_title', 'Chương trình ưu đãi' );
$items_raw = xe36_get_homepage_field(
	'offers_items',
	"Khứ hồi trong ngày giảm 20.000đ\nBệnh nhân K giảm 50% giá vé\nSinh viên giảm 20.000đ"
);
$video_url = xe36_get_homepage_field( 'offers_video_url', 'https://www.youtube.com/shorts/texzSFipzUQ' );

$items = array();
if ( is_string( $items_raw ) && '' !== trim( $items_raw ) ) {
	foreach ( preg_split( '/\r\n|\r|\n/', $items_raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$items[] = $line;
		}
	}
}

/**
 * Extract YouTube video ID from watch / shorts / youtu.be URLs.
 *
 * @param string $url Video URL.
 * @return string
 */
$video_id = '';
if ( is_string( $video_url ) && '' !== $video_url ) {
	if ( preg_match( '~(?:youtube\.com/(?:watch\?v=|shorts/|embed/)|youtu\.be/)([A-Za-z0-9_-]{6,})~', $video_url, $m ) ) {
		$video_id = $m[1];
	}
}

if ( ! $items && ! $video_id ) {
	return;
}

$poster = $video_id
	? 'https://i.ytimg.com/vi/' . rawurlencode( $video_id ) . '/hqdefault.jpg'
	: '';

$hotline_raw = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';

$zalo_url = xe36_get_site_field( 'zalo_url', 'https://zalo.me/1jc92dlvfodg4' );
if ( ! is_string( $zalo_url ) || '' === trim( $zalo_url ) ) {
	$zalo_url = 'https://zalo.me/1jc92dlvfodg4';
}
?>
<section class="home-section home-offers" id="home-offers" data-section="offers">
	<div class="home-section__inner home-offers__inner">
		<div class="home-offers__grid">
			<div class="home-offers__content">
				<?php if ( $title ) : ?>
					<header class="home-offers__header">
						<p class="home-offers__eyebrow">Ưu đãi</p>
						<h2 class="home-offers__title"><?php echo esc_html( $title ); ?></h2>
					</header>
				<?php endif; ?>

				<?php if ( $items ) : ?>
					<ul class="home-offers__list">
						<?php foreach ( $items as $index => $item ) : ?>
							<li class="home-offers__item">
								<span class="home-offers__num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
								<span class="home-offers__text"><?php echo esc_html( $item ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="home-offers__actions">
					<a class="btn home-offers__btn home-offers__btn--tel" href="<?php echo esc_url( $hotline_tel ); ?>">
						1900 888 999
					</a>
					<a class="btn home-offers__btn home-offers__btn--zalo" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer">
						Nhắn Zalo
					</a>
				</div>
			</div>

			<?php if ( $video_id ) : ?>
				<div class="home-offers__media">
					<div class="home-offers__video">
						<button
							type="button"
							class="home-offers__facade"
							data-youtube-facade
							data-youtube-id="<?php echo esc_attr( $video_id ); ?>"
							data-youtube-title="<?php echo esc_attr( $title ? $title : 'Video ưu đãi' ); ?>"
							aria-label="<?php echo esc_attr__( 'Phát video YouTube', 'oceanwp-child' ); ?>"
							style="background-image:url(<?php echo esc_url( $poster ); ?>)"
						>
							<span class="home-offers__play" aria-hidden="true"></span>
						</button>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
