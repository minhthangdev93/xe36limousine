<?php
/**
 * HTML email for booking request notifications.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build professional HTML email body for a booking request.
 *
 * @param array $data Booking fields (already sanitized / escaped for display).
 * @return string
 */
function xe36_booking_email_html( array $data ) {
	$brand   = function_exists( 'xe36_brand_site_name' ) ? xe36_brand_site_name() : 'Xe 36 Limousine';
	$hotline = xe36_get_site_field( 'hotline_display', '' );
	if ( ! is_string( $hotline ) || '' === trim( $hotline ) ) {
		$hotline = xe36_get_site_field( 'hotline', '' );
	}

	$route        = (string) ( $data['route'] ?? '' );
	$date         = (string) ( $data['date'] ?? '' );
	$time         = (string) ( $data['time'] ?? '' );
	$seat         = (string) ( $data['seat'] ?? '' );
	$quantity     = (string) ( $data['quantity'] ?? '' );
	$name         = (string) ( $data['name'] ?? '' );
	$country_code = (string) ( $data['country_code'] ?? '' );
	$phone        = (string) ( $data['phone'] ?? '' );
	$phone_full   = trim( $country_code . ' ' . $phone );

	$rows = array(
		array( 'Tuyến', $route ),
		array( 'Ngày đi', $date ),
		array( 'Giờ đi', $time ),
		array( 'Ghế muốn ngồi', $seat ),
		array( 'Số vé', $quantity ),
		array( 'Họ và tên', $name ),
		array( 'Số điện thoại', $phone_full ),
	);

	$rows_html = '';
	foreach ( $rows as $index => $row ) {
		$label     = esc_html( $row[0] );
		$value     = esc_html( $row[1] );
		$bg        = ( 0 === $index % 2 ) ? '#f8fafc' : '#ffffff';
		$val_style = 'font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.4;color:#111827;font-weight:600;text-align:right;';

		$rows_html .= '<tr>'
			. '<td style="padding:12px 16px;background:' . $bg . ';border-bottom:1px solid #eef2f7;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.4;color:#6b7280;width:42%;">'
			. $label
			. '</td>'
			. '<td style="padding:12px 16px;background:' . $bg . ';border-bottom:1px solid #eef2f7;' . $val_style . '">'
			. $value
			. '</td>'
			. '</tr>';
	}

	$hotline_html = '';
	if ( is_string( $hotline ) && '' !== trim( $hotline ) ) {
		$hotline_html = '<p style="margin:8px 0 0;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.5;color:#9ca3af;">Hotline: '
			. esc_html( trim( $hotline ) )
			. '</p>';
	}

	$site_url = esc_url( home_url( '/' ) );

	return '<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yêu cầu đặt vé</title>
</head>
<body style="margin:0;padding:0;background:#edfdfa;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#edfdfa;padding:28px 12px;">
	<tr>
		<td align="center">
			<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;">
				<tr>
					<td style="background:linear-gradient(135deg,#007AFF 0%,#5856D6 100%);background-color:#007AFF;padding:28px 24px;text-align:left;">
						<p style="margin:0 0 6px;font-family:Arial,Helvetica,sans-serif;font-size:12px;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.85);font-weight:700;">Yêu cầu đặt vé mới</p>
						<h1 style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:22px;line-height:1.3;color:#ffffff;font-weight:700;">' . esc_html( $brand ) . '</h1>
					</td>
				</tr>
				<tr>
					<td style="padding:24px 24px 8px;">
						<p style="margin:0 0 6px;font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.5;color:#374151;">
							Có yêu cầu đặt vé mới từ khách hàng. Vui lòng gọi lại để tư vấn và xác nhận.
						</p>
						<p style="margin:0 0 18px;display:inline-block;padding:6px 12px;border-radius:999px;background:#fff7ed;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:1.4;color:#c2410c;font-weight:700;">
							Đây mới là yêu cầu — chưa phải vé chính thức
						</p>
					</td>
				</tr>
				<tr>
					<td style="padding:0 24px 24px;">
						<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
							' . $rows_html . '
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding:0 24px 28px;">
						<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f0f9ff;border:1px solid #dbeafe;border-radius:12px;">
							<tr>
								<td style="padding:16px 18px;">
									<p style="margin:0 0 4px;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.4;color:#1d4ed8;font-weight:700;">Bước tiếp theo</p>
									<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.55;color:#374151;">
										Liên hệ khách theo số điện thoại bên trên để xác nhận ghế, giờ đi và hoàn tất đặt vé trên hệ thống.
									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding:18px 24px;background:#f8fafc;border-top:1px solid #eef2f7;text-align:center;">
						<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.5;color:#6b7280;">
							Email tự động từ <a href="' . $site_url . '" style="color:#007AFF;text-decoration:none;font-weight:600;">' . esc_html( $brand ) . '</a>
						</p>
						' . $hotline_html . '
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>';
}
