# Admin Panel UI Redesign

**Date:** 2026-04-28  
**Status:** Approved  
**Scope:** Filament admin panel — visual redesign of all content pages to match the industri portal design system

---

## Goal

Replace the current default-Filament appearance of admin content pages with the same polished design language used in the industri portal (`components/layouts/industri.blade.php`). The sidebar (dark green, user footer with logout) is already done. This spec covers the content area.

---

## Design Tokens (from industri portal)

| Token | Value | Use |
|-------|-------|-----|
| `--bg` | `#F8FAFC` | Page background |
| `--surface` | `#ffffff` | Cards, tables |
| `--border` | `#E5EDF5` | All borders |
| `--border-2` | `#cdd8e5` | Stronger borders |
| `--text` | `#061B31` | Primary text (navy) |
| `--text-2` | `#2d3e55` | Table cell text |
| `--text-3` | `#64748D` | Secondary text |
| `--text-4` | `#9aabbc` | Muted labels |
| `--brand` | `#006837` | Green accent |
| `--stripe-shadow-sm` | `rgba(50,50,93,.10) 0 8px 24px -8px` | Card shadow |

---

## Components to Redesign

### 1. Page Header
- Title: 20px, weight 700, navy, letter-spacing -0.035em
- Subtitle: 12.5px, slate (#64748D), margin-top 3px
- Breadcrumbs: 12px, green links, muted separator

### 2. Table (`.fi-ta-ctn`)
- Container: white, 10px border-radius, `#E5EDF5` border, stripe shadow
- Header cells (`.fi-ta-header-cell`): 10px uppercase, weight 700, `#9aabbc`, `#F8FAFC` background
- Body cells (`.fi-ta-cell`): 12px 16px padding, `#2d3e55`, 13px font
- Row hover: `#fafbfc` background
- Search bar: styled input with search icon, `#F8FAFC` background
- Pagination: `#F8FAFC` background, `#E5EDF5` top border, green active page button

### 3. Status Badges (`.fi-badge`)
- 11.5px, weight 500, 6px border-radius
- Dot indicator prefix via `::before` pseudo-element
- Colour variants: green (ok), amber (review), red (rejected), blue (submitted), gray (draft), orange (needs action), purple (pending)

### 4. Role Badges (custom `.role-badge`)
- Compact colored pills, 10.5px, weight 600, 20px border-radius
- Colors per role: Super Admin (red), Pendaftar (blue), Penilai Teknikal (purple), Penilai Label (teal), Pegawai Pendaftaran (orange)

### 5. Section Cards (`.fi-section`)
- White, 10px border-radius, `#E5EDF5` border, stripe shadow
- Header: 13px bold title, `#E5EDF5` bottom border, 14px 20px padding
- Content: 20px padding

### 6. Infolist / View Pages (`.fi-in-entry-*`)
- Labels: 10px uppercase, weight 700, letter-spacing 0.07em, `#9aabbc`
- Values: 13.5px, `#061B31`, weight 400
- Grid layout: 2 columns, separated by `#F1F5F9` borders

### 7. Form Inputs (`.fi-input-wrp`)
- White background, `#E5EDF5` border, 8px border-radius
- Focus: green border + 3px green glow (`rgba(0,104,55,.10)`)
- Labels: 12px, weight 500, navy

### 8. Buttons (`.fi-btn`)
- 6px border-radius, weight 500, Poppins font
- Primary: `#006837` background
- Danger: `#dc2626` background

### 9. Table Action Links
- Green pill: `#f0fdf4` bg + `#bbf7d0` border + `#006837` text
- Danger pill: `#fef2f2` bg + `#fecaca` border + `#dc2626` text

### 10. Topbar
- White bg, `#E5EDF5` bottom border, 52px height
- Back button: slate text, hover green
- Title: 14px, weight 600, navy
- Notification icon button: ghost style with red dot
- CTA button: green primary

---

## Implementation Approach

**Single file change:** All changes live in `resources/css/filament/admin/theme.css` via CSS overrides targeting Filament's `fi-*` class names. No PHP or Blade changes needed beyond what is already done.

**Build step required:** `npm run build` inside `mylrmp/` after each CSS change.

**Already done:** Sidebar dark green + user footer with logout (from previous session).

---

## Out of Scope

- Filament widget styling (charts, custom widgets) — separate task
- Dark mode support
- Mobile/responsive adjustments
- Custom Blade component overrides (keep Filament defaults, style via CSS only)
