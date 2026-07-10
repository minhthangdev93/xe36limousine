---
name: iOS 16 UI Kit
colors:
  primary: '#007AFF'
  primary-light: '#5AC8FA'
  primary-dark: '#0051A8'
  secondary: '#007AFF'
  accent: '#FF9500'
  system-green: '#34C759'
  system-red: '#FF3B30'
  system-indigo: '#5856D6'
  background: '#FFFFFF'
  background-alt: '#F2F2F7'
  background-hero: '#000000'
  background-footer: '#000000'
  background-dark-elevated: '#1C1C1E'
  on-background: '#000000'
  on-background-muted: 'rgba(60, 60, 67, 0.6)'
  on-hero: '#FFFFFF'
  on-hero-muted: 'rgba(235, 235, 245, 0.6)'
  separator: '#C6C6C8'
  separator-opaque: 'rgba(60, 60, 67, 0.29)'
  status-alert: '#FF9500'
typography:
  display-lg:
    fontFamily: SF Pro Display / system-ui
    fontSize: 34px
    fontWeight: '700'
    lineHeight: 41px
  display-lg-mobile:
    fontFamily: SF Pro Display / system-ui
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 34px
  headline-md:
    fontFamily: SF Pro Text / system-ui
    fontSize: 22px
    fontWeight: '700'
    lineHeight: 28px
  headline-sm:
    fontFamily: SF Pro Text / system-ui
    fontSize: 17px
    fontWeight: '600'
    lineHeight: 22px
  body-lg:
    fontFamily: SF Pro Text / system-ui
    fontSize: 17px
    fontWeight: '400'
    lineHeight: 22px
  body-md:
    fontFamily: SF Pro Text / system-ui
    fontSize: 17px
    fontWeight: '400'
    lineHeight: 22px
  body-sm:
    fontFamily: SF Pro Text / system-ui
    fontSize: 15px
    fontWeight: '400'
    lineHeight: 20px
  label-caps:
    fontFamily: SF Pro Text / system-ui
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
    letterSpacing: -0.08px
  button-text:
    fontFamily: SF Pro Text / system-ui
    fontSize: 17px
    fontWeight: '600'
    lineHeight: 22px
rounded:
  sm: 10px
  DEFAULT: 12px
  md: 12px
  lg: 12px
  button: 980px
  xl: 16px
  full: 980px
spacing:
  unit: 8px
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 48px
---

## Style

Design system aligned to **iOS 16 UI Kit** (Apple HIG / Figma community kit). Clean, system-native controls: SF Pro stack, system colors, continuous corner radii, 8pt spacing, soft materials.

## Colors

- **System Blue `#007AFF`:** Primary actions, links, focus rings.
- **System Orange `#FF9500`:** High-emphasis CTA (book).
- **System Green `#34C759`:** Call / success actions.
- **System Red `#FF3B30`:** Errors / destructive.
- **Grouped background `#F2F2F7`:** Alternating sections, input fills.
- **Hero / footer / CTA band:** `#000000` with elevated `#1C1C1E`.
- **Label primary:** `#000000` on light; `#FFFFFF` on dark.
- **Label secondary:** `rgba(60,60,67,0.6)` on light; `rgba(235,235,245,0.6)` on dark.

### Surface pairing

| Surface | Background | Title / body | Muted |
|---------|------------|--------------|-------|
| Content / form | `#FFFFFF` / `#F2F2F7` | `#000000` | secondary label |
| Hero / CTA / Footer | `#000000` | `#FFFFFF` | tertiary label on dark |

## Typography

Use the **system font stack** (`-apple-system`, SF Pro Text/Display, Segoe UI, Roboto). Do not require hosting SF Pro.

Scale maps to iOS text styles: Large Title, Title 2/3, Body, Callout, Footnote.

Labels use Footnote weight — **not** heavy uppercase tracking.

## Layout & Spacing

- **8pt grid** for padding/margins.
- Desktop max width 1280px; mobile margin 16px.
- Touch targets ≥ 44pt height for controls.

## Elevation & Shapes

- Cards: white on grouped gray, soft shadow `0 1px 3px rgba(0,0,0,.12)`.
- Buttons: **pill** (`980px` continuous).
- Inputs: radius **10px**, fill `#F2F2F7` or white with separator border.
- Focus: 3px system-blue ring (no brand glow).

## Components

- **Primary button:** System Blue fill, white label, pill.
- **CTA / Accent:** System Orange fill.
- **Call:** System Green fill.
- **Outline:** Separator border, label color; on dark use white border @ 60%.
- **Inputs:** Grouped fill, 17px body, blue focus ring.
- **Booking card:** Elevated white, 12–16px radius, soft shadow.
