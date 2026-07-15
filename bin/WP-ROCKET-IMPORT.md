# WP Rocket — cấu hình ổn định cho xe36limousine.vn

## File import

`bin/wp-rocket-settings-xe36limousine.vn-2026-07-15-xe36stable01.json`

> **Quan trọng:** WP Rocket kiểm tra tên file. **Không đổi tên** (phải giữ dạng `wp-rocket-settings-…json`).

## Cách import

1. Tải file JSON về máy (hoặc copy từ theme sau `git pull`).
2. WP Admin → **Settings → WP Rocket → Tools**.
3. **Import settings** → chọn file → Upload.
4. **Clear cache** (không bật Preload).
5. Kiểm tra nhanh: trang chủ, form đặt vé, gallery vuốt mobile, contact bar.

## Điểm chính của cấu hình này

| Tuỳ chọn | Giá trị | Lý do |
|----------|---------|--------|
| Preload cache (`manual_preload`) | **TẮT** | Tránh Load/CPU max như trước |
| Separate mobile cache | Bật | Homepage mobile khác desktop |
| Minify CSS/JS | Bật | Giảm dung lượng |
| Combine JS | Tắt | Tránh lỗi form/gallery |
| Delay JS | Tắt | Theme đã tối ưu JS riêng |
| Remove Unused CSS | Tắt | Dễ vỡ layout |
| Async CSS | Tắt | Theme đã có critical CSS |
| LazyLoad + YouTube preview | Bật | Mobile nhẹ hơn |
| CDN | Tắt | Chưa cấu hình CDN |
| Heartbeat | Giảm | Bớt tải admin/editor |

## Sau khi import — kiểm tra trên server

```bash
# Clear cache, KHÔNG preload
wp rocket clean --confirm
```

Trong WP Rocket UI: **Preload → bỏ tick Preload cache** (nếu vẫn bật sau import).

## Ghi chú

- Form đặt vé / gallery JS đã exclude khỏi minify delay.
- `admin-ajax` / `wp-json` loại khỏi page cache.
- Nếu layout CSS lỗi: tắt tạm Minify CSS rồi Clear cache.
