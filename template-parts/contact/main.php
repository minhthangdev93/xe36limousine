<?php
/**
 * Contact: Info + form.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

$info_title  = xe36_get_contact_field( 'contact_info_title' );
$form_title  = xe36_get_contact_field( 'contact_form_title' );
$form_lead   = xe36_get_contact_field( 'contact_form_lead' );
$btn_text    = xe36_get_contact_field( 'contact_cta_btn_text' );

$hotline_raw     = xe36_get_site_field( 'hotline', '1900888999' );
$hotline_display = xe36_get_site_field( 'hotline_display', '1900 888 999' );
if ( ! is_string( $hotline_display ) || '' === trim( $hotline_display ) || '1900 xxxx' === trim( $hotline_display ) ) {
	$hotline_display = '1900 888 999';
}
$hotline_tel = is_string( $hotline_raw ) && '' !== preg_replace( '/\D+/', '', $hotline_raw )
	? 'tel:' . preg_replace( '/\D+/', '', $hotline_raw )
	: 'tel:1900888999';

$zalo_url = xe36_get_site_field( 'zalo_url', 'https://zalo.me/1jc92dlvfodg4' );
if ( ! is_string( $zalo_url ) || '' === trim( $zalo_url ) ) {
	$zalo_url = 'https://zalo.me/1jc92dlvfodg4';
}

$email = xe36_get_site_field( 'footer_email', '36limousine@gmail.com' );
if ( ! is_string( $email ) || '' === trim( $email ) ) {
	$email = '36limousine@gmail.com';
}

if ( ! is_string( $btn_text ) || '' === trim( $btn_text ) ) {
	$btn_text = 'Gửi liên hệ';
}
?>
<section class="contact-section contact-main" id="contact-main">
	<div class="contact-section__inner contact-main__inner">
		<aside class="contact-info">
			<?php if ( $info_title ) : ?>
				<h2 class="contact-info__title"><?php echo esc_html( $info_title ); ?></h2>
			<?php endif; ?>

			<ul class="contact-info__list">
				<li class="contact-info__item">
					<span class="contact-info__label">Tổng đài</span>
					<a class="contact-info__value" href="<?php echo esc_url( $hotline_tel ); ?>"><?php echo esc_html( $hotline_display ); ?></a>
				</li>
				<li class="contact-info__item">
					<span class="contact-info__label">Zalo</span>
					<a class="contact-info__value" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer">Nhắn Zalo ngay</a>
				</li>
				<li class="contact-info__item">
					<span class="contact-info__label">Email</span>
					<a class="contact-info__value" href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
				</li>
			</ul>

			<div class="contact-info__actions">
				<a class="btn contact-info__btn contact-info__btn--call" href="<?php echo esc_url( $hotline_tel ); ?>">Gọi <?php echo esc_html( $hotline_display ); ?></a>
				<a class="btn contact-info__btn contact-info__btn--zalo" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer">Nhắn Zalo</a>
			</div>
		</aside>

		<div class="contact-form-wrap">
			<?php if ( $form_title || $form_lead ) : ?>
				<header class="contact-form-wrap__header">
					<?php if ( $form_title ) : ?>
						<h2 class="contact-form-wrap__title"><?php echo esc_html( $form_title ); ?></h2>
					<?php endif; ?>
					<?php if ( $form_lead ) : ?>
						<p class="contact-form-wrap__lead"><?php echo esc_html( $form_lead ); ?></p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<form class="contact-form" id="xe36-contact-form" novalidate>
				<p class="contact-form__honeypot" aria-hidden="true">
					<label for="xe36-contact-website">Website</label>
					<input type="text" id="xe36-contact-website" name="website" tabindex="-1" autocomplete="off" />
				</p>

				<div class="contact-form__row">
					<label class="contact-form__field" for="xe36-contact-name">
						<span class="contact-form__label">Họ và tên <abbr title="bắt buộc">*</abbr></span>
						<input class="xe36-input" type="text" id="xe36-contact-name" name="name" required autocomplete="name" placeholder="Nguyễn Văn A" />
					</label>
					<label class="contact-form__field" for="xe36-contact-phone">
						<span class="contact-form__label">Số điện thoại <abbr title="bắt buộc">*</abbr></span>
						<input class="xe36-input" type="tel" id="xe36-contact-phone" name="phone" required autocomplete="tel" placeholder="09xx xxx xxx" />
					</label>
				</div>

				<div class="contact-form__row">
					<label class="contact-form__field" for="xe36-contact-email">
						<span class="contact-form__label">Email</span>
						<input class="xe36-input" type="email" id="xe36-contact-email" name="email" autocomplete="email" placeholder="email@example.com" />
					</label>
					<label class="contact-form__field" for="xe36-contact-subject">
						<span class="contact-form__label">Chủ đề</span>
						<input class="xe36-input" type="text" id="xe36-contact-subject" name="subject" placeholder="Đặt vé / Gửi hàng / Thuê xe…" />
					</label>
				</div>

				<label class="contact-form__field" for="xe36-contact-message">
					<span class="contact-form__label">Nội dung <abbr title="bắt buộc">*</abbr></span>
					<textarea class="xe36-textarea" id="xe36-contact-message" name="message" rows="5" required placeholder="Nhập nội dung cần hỗ trợ…"></textarea>
				</label>

				<div class="contact-form__footer">
					<button type="submit" class="btn contact-form__submit" data-contact-submit>
						<?php echo esc_html( $btn_text ); ?>
					</button>
					<div class="contact-form__response" data-contact-response role="status" aria-live="polite"></div>
				</div>
			</form>
		</div>
	</div>
</section>
