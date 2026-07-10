# OceanWP Child — Xe 36 Limousine

Child theme cho site [Xe 36 Limousine](https://xe36limousine.vn) (WordPress + OceanWP + ACF).

Repo: [minhthangdev93/xe36limousine](https://github.com/minhthangdev93/xe36limousine)

## Cài trên production

1. Copy toàn bộ thư mục này vào:
   ```text
   wp-content/themes/oceanwp-child/
   ```
2. Kích hoạt theme **OceanWP Child** (parent: OceanWP phải có sẵn).
3. Cần plugin: **ACF Pro** (field groups đăng ký bằng PHP trong `inc/acf/`).
4. Chạy migrate 2 trang dịch vụ (đổi post → page + gán template), **một lần** sau khi deploy code:
   ```bash
   wp eval-file wp-content/themes/oceanwp-child/bin/migrate-service-pages.php
   ```
5. Gán template (nếu chưa):
   - `/gioi-thieu` → **Giới thiệu**
   - `/van-chuyen-hanh-khach` → **Vận chuyển hành khách**
   - `/van-chuyen-hang-hoa` → **Vận chuyển hàng hóa**
   - `/lien-he` → **Liên hệ**
6. Flush permalinks: Settings → Permalinks → Save (hoặc `wp rewrite flush`).

## Cấu trúc chính

| Path | Mô tả |
|------|--------|
| `front-page.php` + `inc/homepage/` | Trang chủ custom (không Elementor) |
| `page-templates/about.php` | Giới thiệu |
| `page-templates/passenger.php` | Vận chuyển hành khách |
| `page-templates/cargo.php` | Vận chuyển hàng hóa |
| `page-templates/contact.php` | Liên hệ + form AJAX |
| `archive.php` / `home.php` / `single.php` | Blog / chuyên mục / bài viết |
| `inc/header/` `inc/footer/` | Header & footer custom |
| `inc/shortcodes/vanphong.php` | Shortcode văn phòng |
| `bin/migrate-service-pages.php` | Script migrate prod |

## Lưu ý

- **Không** commit `uploads/`, plugin, hay parent theme OceanWP vào repo này.
- Nội dung ACF nằm trong DB; code chỉ có field structure + defaults fallback.
- Sau deploy, hard-refresh nếu CSS/JS bị cache (version trong `style.css`).
