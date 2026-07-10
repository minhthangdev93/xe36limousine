<?php
/**
 * Floating contact shortcuts.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$zalo_personal = xe36_get_site_field( 'zalo_url', 'https://zalo.me/1jc92dlvfodg4' );
$zalo_oa       = 'https://zalo.me/4354806326692304606?src=qr&f=1';
$hotline       = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_href  = 'tel:' . preg_replace( '/\D+/', '', (string) $hotline );
?>
<div class="giuseart-nav" aria-label="<?php esc_attr_e( 'Liên hệ nhanh', 'oceanwp-child' ); ?>">
	<ul>
		<li>
			<a href="https://wa.me/0395881133" rel="nofollow noopener" target="_blank">
				<i class="ticon-heart" aria-hidden="true"></i>Whatsapp
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url( $zalo_personal ); ?>" rel="nofollow noopener" target="_blank">
				<i class="ticon-zalo-circle2" aria-hidden="true"></i>Zalo
			</a>
		</li>
		<li class="phone-mobile">
			<a href="<?php echo esc_url( $hotline_href ); ?>" rel="nofollow" class="button">
				<span class="phone_animation animation-shadow">
					<i class="icon-phone-w" aria-hidden="true"></i>
				</span>
				<span class="btn_phone_txt">Gọi điện</span>
			</a>
		</li>
		<li>
			<a href="https://www.messenger.com/t/Xe36limousine.vn" rel="nofollow noopener" target="_blank">
				<i class="ticon-messenger" aria-hidden="true"></i>Messenger
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url( $zalo_oa ); ?>" class="chat_animation" rel="nofollow noopener" target="_blank">
				<i class="ticon-chat-sms" aria-hidden="true" title="Zalo OA"></i>
				Zalo OA
			</a>
		</li>
		<li class="to-top-pc">
			<a href="<?php echo esc_url( $zalo_oa ); ?>" rel="nofollow noopener" target="_blank">
				<i class="ticon-angle-up" aria-hidden="true" title="Zalo OA"></i>
				Zalo OA
			</a>
		</li>
	</ul>
</div>
