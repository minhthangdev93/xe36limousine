# GTM / GA4 — Form conversion tracking (Xe 36 Travel Limousine)

AI-oriented integration notes for measuring booking and contact form conversions on **xe36limousine.vn**.

## Context

| Item | Value |
|------|--------|
| Site | https://xe36limousine.vn |
| GTM container | `GTM-M9S8CX7` |
| Theme | `wp-content/themes/oceanwp-child` |
| Load | GTM loaded lazily from `header.php` via `window.xe36LoadGTM` |
| Forms | AJAX (no thank-you URL redirect) |

**Important:** Do **not** use “Page View → thank you URL” for conversion. Use **Custom Event** triggers on `dataLayer` events below.

## Source of truth (code)

| Form | File | When event fires |
|------|------|------------------|
| Booking (`#booking-form`) | `assets/js/booking.js` | AJAX success **and** HTML contains `.xe36-booking-response--success` |
| Contact (`#xe36-contact-form`) | `assets/js/contact.js` | `fetch` JSON `success === true` |

Backend AJAX:

- Booking: `action=submit_booking_form` → `inc/booking/ajax.php`
- Contact: `action=submit_contact_form` → `inc/contact/bootstrap.php`

Events are **not** pushed on validation errors or network/mail failures.

## dataLayer contracts

### 1) Booking success

```js
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
  event: 'booking_submit_success',
  form_id: 'booking-form',
  booking_route: '<route-key>',      // e.g. hn-th, th-hn, hn-ss, ss-hn, hn-ht, ht-hn
  booking_date: 'YYYY-MM-DD',
  booking_time: 'HH:MM',
  booking_seat: '<seat-key>',        // front | middle | back
  booking_quantity: '<number-string>'
});
```

**GTM Custom Event name:** `booking_submit_success`

### 2) Contact success

```js
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
  event: 'contact_submit_success',
  form_id: 'xe36-contact-form'
});
```

**GTM Custom Event name:** `contact_submit_success`

## Recommended GTM setup

Container: `GTM-M9S8CX7`.

### Variables (User-Defined → Data Layer Variable, Version 2)

| GTM variable name | Data Layer key |
|-------------------|----------------|
| `dlv - booking_route` | `booking_route` |
| `dlv - booking_date` | `booking_date` |
| `dlv - booking_time` | `booking_time` |
| `dlv - booking_seat` | `booking_seat` |
| `dlv - booking_quantity` | `booking_quantity` |
| `dlv - form_id` | `form_id` |

### Triggers (Custom Event)

| Trigger name | Event name | Fires on |
|--------------|------------|----------|
| `CE - booking_submit_success` | `booking_submit_success` | All Custom Events |
| `CE - contact_submit_success` | `contact_submit_success` | All Custom Events |

### Tags (GA4 Event)

Prerequisite: existing **GA4 Configuration** tag with Measurement ID.

#### Tag A — booking lead

- Type: Google Analytics: GA4 Event
- Name: `GA4 - generate_lead (booking)`
- Event Name: `generate_lead`
- Parameters:

| Param | Value |
|-------|--------|
| `form_id` | `{{dlv - form_id}}` |
| `booking_route` | `{{dlv - booking_route}}` |
| `booking_seat` | `{{dlv - booking_seat}}` |
| `booking_quantity` | `{{dlv - booking_quantity}}` |
| `method` | `booking_form` |

- Trigger: `CE - booking_submit_success`

#### Tag B — contact lead

- Type: Google Analytics: GA4 Event
- Name: `GA4 - generate_lead (contact)`
- Event Name: `generate_lead`
- Parameters:

| Param | Value |
|-------|--------|
| `form_id` | `{{dlv - form_id}}` |
| `method` | `contact_form` |

- Trigger: `CE - contact_submit_success`

### Optional — Google Ads Conversion

- Tag type: Google Ads Conversion Tracking
- Conversion ID + Label from Google Ads
- Trigger: `CE - booking_submit_success` (and optionally contact)

## GA4 configuration

1. Confirm events arrive: Reports → Realtime → Events → `generate_lead`
2. Admin → Events (or Key events) → mark `generate_lead` as **key event**
3. Funnel / Explore:
   - `session_start` / `page_view` → `generate_lead`
4. Segment booking vs contact with event param `method` or `form_id`

### Conversion formula

```text
Form conversion rate = generate_lead count / sessions (or page_views of pages with form)
```

Offline check: count emails subject `[Yêu cầu đặt vé]` in `booking.36limousine@gmail.com`.

## Verification checklist

1. GTM → Preview → open https://xe36limousine.vn/
2. Submit booking form successfully
3. Tag Assistant shows Custom Event `booking_submit_success`
4. Tag `GA4 - generate_lead (booking)` status = Fired
5. Browser console:

```js
dataLayer.filter(function (e) {
  return e && (e.event === 'booking_submit_success' || e.event === 'contact_submit_success');
});
```

6. Repeat on /lien-he/ for `contact_submit_success`
7. Publish GTM container

## Do not

- Do not bind conversion to Contact Form 7 / Elementor form listeners — these forms are custom AJAX
- Do not require a thank-you page URL
- Do not fire on click of submit button alone (false positives before server success)
- Do not rename `event` keys without updating GTM triggers

## Deploy note

After theme deploy, bust caches (WP Rocket). Asset version comes from child theme `style.css` Version header via `xe36_theme_version()`.

## Related files

- `header.php` — GTM bootstrap (`GTM-M9S8CX7`)
- `assets/js/booking.js` — `pushBookingConversion()` → `booking_submit_success`
- `assets/js/contact.js` — `contact_submit_success`
- `inc/booking/partials/form.php` — `#booking-form`
- `inc/booking/ajax.php` — success HTML class `xe36-booking-response--success`
