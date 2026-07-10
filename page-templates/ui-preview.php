<?php
/**
 * Template Name: UI Preview (Elite Motion)
 * Description: Trang xem trước design system — không index, chỉ dùng nội bộ.
 *
 * @package OceanWP_Child
 */

get_header();

xe36_custom_ui_shell_open();
?>

			<main class="xe36-ui-preview">
				<div class="xe36-surface-dark xe36-ui-preview__hero">
					<div class="xe36-container">
						<p class="text-label-caps">Elite Motion · Hybrid</p>
						<h1 class="text-display-lg">Xe 36 Limousine — UI Preview</h1>
						<p>Hero navy tối · nội dung &amp; form nền sáng · footer navy.</p>
					</div>
				</div>

				<div class="xe36-container">

					<?php
					$colors = array(
						array( 'name' => 'Primary', 'var' => '--xe36-primary', 'hex' => '#107EB9' ),
						array( 'name' => 'Secondary', 'var' => '--xe36-secondary', 'hex' => '#0068FF' ),
						array( 'name' => 'Accent', 'var' => '--xe36-accent', 'hex' => '#FF6600' ),
						array( 'name' => 'Background', 'var' => '--xe36-bg', 'hex' => '#FFFFFF' ),
						array( 'name' => 'Background Alt', 'var' => '--xe36-bg-soft', 'hex' => '#F8FAFC' ),
						array( 'name' => 'Hero / Footer', 'var' => '--xe36-bg-dark', 'hex' => '#0A243F' ),
						array( 'name' => 'Text', 'var' => '--xe36-text', 'hex' => '#1E293B' ),
						array( 'name' => 'Text on Dark', 'var' => '--xe36-text-on-dark', 'hex' => '#E2E8F0' ),
						array( 'name' => 'Muted', 'var' => '--xe36-muted', 'hex' => '#64748B' ),
						array( 'name' => 'Border', 'var' => '--xe36-border', 'hex' => '#E2E8F0' ),
					);
					?>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-colors-title">
						<h2 id="ui-colors-title" class="xe36-ui-preview__section-title">Colors</h2>
						<p class="xe36-ui-preview__section-desc">Hybrid — hero/footer navy, content trắng/xám nhạt.</p>
						<div class="xe36-ui-preview__grid xe36-ui-preview__grid--colors">
							<?php foreach ( $colors as $color ) : ?>
								<div class="xe36-ui-preview__swatch">
									<div class="xe36-ui-preview__swatch-color" style="background: var(<?php echo esc_attr( $color['var'] ); ?>);"></div>
									<div class="xe36-ui-preview__swatch-meta">
										<span class="xe36-ui-preview__swatch-name"><?php echo esc_html( $color['name'] ); ?></span>
										<span class="xe36-ui-preview__swatch-value"><?php echo esc_html( $color['hex'] ); ?></span>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-type-title">
						<h2 id="ui-type-title" class="xe36-ui-preview__section-title">Typography</h2>
						<p class="xe36-ui-preview__section-desc">SF Pro / system-ui — Large Title, Body, Footnote (iOS 16).</p>
						<div class="xe36-ui-preview__grid xe36-ui-preview__grid--type">
							<div class="xe36-ui-preview__type-row">
								<p class="text-label-caps xe36-ui-preview__type-label">Display LG</p>
								<p class="text-display-lg">Limousine cao cấp Hà Nội ⇔ Thanh Hóa</p>
							</div>
							<div class="xe36-ui-preview__type-row">
								<p class="text-label-caps xe36-ui-preview__type-label">Headline MD</p>
								<p class="text-headline-md">Đặt vé nhanh — phục vụ 24/7</p>
							</div>
							<div class="xe36-ui-preview__type-row">
								<p class="text-label-caps xe36-ui-preview__type-label">Headline SM</p>
								<p class="text-headline-sm">Tuyến phổ biến &amp; giờ khởi hành</p>
							</div>
							<div class="xe36-ui-preview__type-row">
								<p class="text-label-caps xe36-ui-preview__type-label">Body LG / MD / SM</p>
								<p class="text-body-lg">Body large — mô tả dịch vụ limousine chuyên nghiệp, an toàn và đúng giờ.</p>
								<p class="text-body-md">Body medium — thông tin chuyến đi, điểm đón trả và hành lý tiêu chuẩn.</p>
								<p class="text-body-sm">Body small — metadata, ghi chú phụ hoặc điều khoản ngắn.</p>
							</div>
							<div class="xe36-ui-preview__type-row">
								<p class="text-label-caps">Vehicle Class · 7 Seats · WiFi</p>
							</div>
						</div>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-buttons-title">
						<h2 id="ui-buttons-title" class="xe36-ui-preview__section-title">Buttons</h2>
						<p class="xe36-ui-preview__section-desc">Primary blue, outline platinum, accent orange cho CTA đặt vé.</p>
						<div class="xe36-ui-preview__grid xe36-ui-preview__grid--buttons">
							<div class="xe36-ui-preview__button-stack">
								<button type="button" class="btn btn--primary">Đặt vé ngay</button>
								<button type="button" class="btn btn--outline">Xem tuyến</button>
								<button type="button" class="btn btn--cta">Gửi yêu cầu</button>
								<button type="button" class="btn btn--ghost">Tìm hiểu thêm</button>
								<button type="button" class="btn btn--call btn--sm">Gọi hotline</button>
								<button type="button" class="btn btn--primary" disabled>Disabled</button>
							</div>
							<div class="xe36-ui-preview__button-stack">
								<button type="button" class="btn btn--primary btn--block">Block primary</button>
								<button type="button" class="btn btn--cta btn--block">Block CTA</button>
							</div>
						</div>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-inputs-title">
						<h2 id="ui-inputs-title" class="xe36-ui-preview__section-title">Inputs</h2>
						<p class="xe36-ui-preview__section-desc">Nền tối, viền ghost, focus highlight primary blue.</p>
						<div class="xe36-ui-preview__grid xe36-ui-preview__grid--inputs">
							<div class="xe36-ui-preview__field">
								<label class="text-label-caps" for="ui-name">Họ tên</label>
								<input class="xe36-input" id="ui-name" type="text" placeholder="Nguyễn Văn A">
							</div>
							<div class="xe36-ui-preview__field">
								<label class="text-label-caps" for="ui-phone">Số điện thoại</label>
								<input class="xe36-input" id="ui-phone" type="tel" placeholder="09xx xxx xxx">
							</div>
							<div class="xe36-ui-preview__field">
								<label class="text-label-caps" for="ui-date">Ngày đi</label>
								<input class="xe36-input" id="ui-date" type="date">
							</div>
							<div class="xe36-ui-preview__field">
								<label class="text-label-caps" for="ui-route">Tuyến</label>
								<select class="xe36-select" id="ui-route">
									<option>Hà Nội → Thanh Hóa</option>
									<option>Thanh Hóa → Hà Nội</option>
									<option>Hà Nội → Sầm Sơn</option>
								</select>
							</div>
							<div class="xe36-ui-preview__field" style="grid-column: 1 / -1;">
								<label class="text-label-caps" for="ui-note">Ghi chú</label>
								<textarea class="xe36-textarea" id="ui-note" rows="3" placeholder="Điểm đón, số lượng khách..."></textarea>
							</div>
						</div>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-chips-title">
						<h2 id="ui-chips-title" class="xe36-ui-preview__section-title">Chips &amp; Links</h2>
						<div class="xe36-ui-preview__chip-row">
							<span class="xe36-chip xe36-chip--primary">Premium Class</span>
							<span class="xe36-chip xe36-chip--accent">Book Now</span>
							<span class="xe36-chip xe36-chip--success">Available</span>
						</div>
						<div class="xe36-ui-preview__link-row" style="margin-top: 1.5rem;">
							<a class="xe36-link" href="#">Liên kết secondary</a>
							<a class="xe36-link" href="#">Chính sách đặt vé</a>
						</div>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-elevation-title">
						<h2 id="ui-elevation-title" class="xe36-ui-preview__section-title">Elevation</h2>
						<p class="xe36-ui-preview__section-desc">Light surfaces — form &amp; nội dung chính.</p>
						<div class="xe36-ui-preview__grid xe36-ui-preview__grid--elevation">
							<div class="xe36-ui-preview__surface xe36-ui-preview__surface--l0">
								<p class="text-label-caps">Level 0</p>
								<p class="text-body-sm">Background #FFFFFF</p>
							</div>
							<div class="xe36-ui-preview__surface xe36-ui-preview__surface--l1">
								<p class="text-label-caps">Level 1</p>
								<p class="text-body-sm">Section alt #F8FAFC</p>
							</div>
							<div class="xe36-ui-preview__surface xe36-ui-preview__surface--l2">
								<p class="text-label-caps">Level 2</p>
								<p class="text-body-sm">Cards / form floating</p>
							</div>
							<div class="xe36-ui-preview__surface xe36-ui-preview__surface--dark">
								<p class="text-label-caps">Hero / Footer</p>
								<p class="text-body-sm" style="color: var(--xe36-muted-on-dark);">Deep navy #0A243F</p>
							</div>
						</div>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-spacing-title">
						<h2 id="ui-spacing-title" class="xe36-ui-preview__section-title">Spacing (8px unit)</h2>
						<?php
						$spaces = array( 1, 2, 3, 4, 6, 8 );
						foreach ( $spaces as $mult ) :
							$px = 8 * $mult;
							?>
							<div class="xe36-ui-preview__spacing-row">
								<div class="xe36-ui-preview__spacing-bar" style="width: <?php echo esc_attr( (string) $px ); ?>px;"></div>
								<span><?php echo esc_html( (string) $mult ); ?>× unit</span>
								<span><?php echo esc_html( (string) $px ); ?>px</span>
							</div>
						<?php endforeach; ?>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-booking-title">
						<h2 id="ui-booking-title" class="xe36-ui-preview__section-title">Booking Card Mock</h2>
						<p class="xe36-ui-preview__section-desc">Component hero cho flow đặt vé.</p>
						<article class="xe36-card xe36-ui-preview__booking-mock">
							<div class="xe36-ui-preview__booking-mock-header">
								<div>
									<p class="text-label-caps">Limousine 9 chỗ</p>
									<h3 class="text-headline-sm">Hà Nội → Thanh Hóa</h3>
									<div class="xe36-ui-preview__booking-specs">
										<span class="xe36-chip xe36-chip--primary">7 Seats</span>
										<span class="xe36-chip xe36-chip--primary">WiFi</span>
										<span class="xe36-chip xe36-chip--primary">USB</span>
									</div>
								</div>
								<p class="xe36-ui-preview__booking-price">350.000₫</p>
							</div>
							<div class="xe36-ui-preview__grid xe36-ui-preview__grid--inputs">
								<div class="xe36-ui-preview__field">
									<label class="text-label-caps" for="ui-mock-date">Ngày</label>
									<input class="xe36-input" id="ui-mock-date" type="date">
								</div>
								<div class="xe36-ui-preview__field">
									<label class="text-label-caps" for="ui-mock-time">Giờ</label>
									<select class="xe36-select" id="ui-mock-time">
										<option>06:00</option>
										<option>08:30</option>
										<option>14:00</option>
									</select>
								</div>
							</div>
							<button type="button" class="btn btn--cta btn--block">Chọn chuyến</button>
						</article>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-list-title">
						<h2 id="ui-list-title" class="xe36-ui-preview__section-title">List Items</h2>
						<div class="xe36-card">
							<div class="xe36-list-item">
								<p class="text-headline-sm">Ga Hà Nội</p>
								<p class="text-body-sm">Điểm đón trung tâm — 15 phút/lượt</p>
							</div>
							<div class="xe36-list-item">
								<p class="text-headline-sm">Big C Thanh Hóa</p>
								<p class="text-body-sm">Trả khách tại cổng chính</p>
							</div>
							<div class="xe36-list-item">
								<p class="text-headline-sm">FLC Sầm Sơn</p>
								<p class="text-body-sm">Resort &amp; khách sạn ven biển</p>
							</div>
						</div>
					</section>

					<section class="xe36-ui-preview__section" aria-labelledby="ui-form-title">
						<h2 id="ui-form-title" class="xe36-ui-preview__section-title">Booking Form (live)</h2>
						<p class="xe36-ui-preview__section-desc">Shortcode thật từ theme — để so sánh với mock ở trên.</p>
						<?php echo do_shortcode( '[booking_form]' ); ?>
					</section>

				</div>
			</main>

<?php
xe36_custom_ui_shell_close();
get_footer();
