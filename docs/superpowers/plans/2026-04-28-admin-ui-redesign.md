# Admin UI Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the default Filament appearance of all admin content pages with the approved industri portal design system.

**Architecture:** Pure CSS override approach — all changes live in `resources/css/filament/admin/theme.css`, targeting Filament's `fi-*` CSS class names with `!important` overrides. Sidebar and user footer (already done) are preserved. A single `npm run build` inside `mylrmp/` compiles the CSS via Vite.

**Tech Stack:** Laravel 11, Filament v3, Tailwind v4 (Vite), Poppins (Google Fonts)

---

## File Map

| File | Action | Responsibility |
|------|--------|---------------|
| `mylrmp/resources/css/filament/admin/theme.css` | **Rewrite** | All visual overrides — font, body, topbar, sidebar, tables, badges, cards, infolist, forms, buttons, dropdowns |

No other files need to change.

---

### Task 1: Rewrite theme.css — global styles, sidebar, topbar

**Files:**
- Modify: `mylrmp/resources/css/filament/admin/theme.css`

- [ ] **Step 1: Replace theme.css with the global + sidebar + topbar section**

Open `mylrmp/resources/css/filament/admin/theme.css` and replace the **entire file** with the following content:

```css
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
@import 'tailwindcss';
@import '../../../../vendor/filament/filament/resources/css/index.css';

@source '../../../../app/**/*.php';
@source '../../../../resources/**/*.blade.php';
@source '../../../../vendor/filament/**/*.blade.php';

@variant dark (&:where(.dark, .dark *));

/* ═══════════════════════════════════════════════════════════
   DESIGN TOKENS
   navy #061B31 · slate #64748D · bg #F8FAFC · border #E5EDF5
   brand #006837 · brand-dark #004d28
   green-900 #14532d · green-950 #052e16 (sidebar)
   ═══════════════════════════════════════════════════════════ */

/* ─── Font ──────────────────────────────────────────────── */
* {
    font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
}

/* ─── Body & layout ─────────────────────────────────────── */
.fi-body {
    background-color: #F8FAFC;
}

.fi-main-ctn {
    padding: 24px 28px !important;
}

/* ─── Topbar ────────────────────────────────────────────── */
.fi-topbar {
    background-color: #ffffff;
    box-shadow: none;
    border-bottom: 1px solid #E5EDF5;
}

/* ─── Sidebar body: green-900 ───────────────────────────── */
.fi-sidebar {
    background-color: #14532d;
}

.fi-sidebar-header {
    background-color: #052e16;
}

.fi-body-has-topbar .fi-sidebar-header {
    background-color: #052e16;
    box-shadow: none;
    border: none;
}

/* ─── Sidebar nav group labels ──────────────────────────── */
.fi-sidebar-group-label {
    color: #6ee7b7;
    font-size: 0.6875rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

/* ─── Nav item text & icons ─────────────────────────────── */
.fi-sidebar-item-label {
    color: #dcfce7;
    font-size: 0.84375rem;
}

.fi-sidebar-item-btn > .fi-icon {
    color: #6ee7b7;
}

/* ─── Active: green-700 ─────────────────────────────────── */
.fi-sidebar-item.fi-active > .fi-sidebar-item-btn {
    background-color: #15803d;
    border-radius: 6px;
}

.fi-sidebar-item.fi-active > .fi-sidebar-item-btn .fi-sidebar-item-label {
    color: #ffffff;
}

.fi-sidebar-item.fi-active > .fi-sidebar-item-btn .fi-icon {
    color: #ffffff;
}

/* ─── Hover: green-800 ──────────────────────────────────── */
.fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:hover,
.fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:focus-visible {
    background-color: #166534;
    border-radius: 6px;
}

.fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:hover .fi-sidebar-item-label,
.fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:focus-visible .fi-sidebar-item-label {
    color: #ffffff;
}

.fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:hover > .fi-icon,
.fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:focus-visible > .fi-icon {
    color: #ffffff;
}

/* ─── Group collapse icons ──────────────────────────────── */
.fi-sidebar-group-btn .fi-icon,
.fi-sidebar-group-dropdown-trigger-btn .fi-icon {
    color: #6ee7b7;
}

.fi-sidebar-group-dropdown-trigger-btn:hover,
.fi-sidebar-group-dropdown-trigger-btn:focus-visible {
    background-color: #166534;
}

.fi-sidebar-group-dropdown-trigger-btn:hover .fi-icon,
.fi-sidebar-group-dropdown-trigger-btn:focus-visible .fi-icon {
    color: #ffffff;
}

/* ─── Sidebar footer & toggles ──────────────────────────── */
.fi-sidebar-footer {
    border-top: 1px solid #166534;
}

.fi-sidebar-open-sidebar-btn,
.fi-sidebar-close-sidebar-btn,
.fi-sidebar-open-collapse-sidebar-btn,
.fi-sidebar-close-collapse-sidebar-btn {
    color: #dcfce7;
}

/* ─── Custom sidebar user footer (render hook) ──────────── */
.fi-sidebar-user-footer {
    border-top: 1px solid #166534;
    padding: 10px 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.fi-sf-user-link {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    min-width: 0;
    text-decoration: none;
    border-radius: 6px;
    padding: 4px 6px;
    margin: -4px -6px;
    transition: background 0.1s;
}

.fi-sf-user-link:hover {
    background: rgba(255, 255, 255, 0.08);
}

.fi-sf-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #15803d;
    color: #ffffff;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.fi-sf-info {
    flex: 1;
    min-width: 0;
}

.fi-sf-name {
    font-size: 12.5px;
    font-weight: 600;
    color: #ffffff;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    line-height: 1.3;
}

.fi-sf-role {
    font-size: 10.5px;
    color: #6ee7b7;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin-top: 1px;
}

.fi-sf-logout {
    background: none;
    border: none;
    cursor: pointer;
    color: #6ee7b7;
    padding: 5px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: color 0.1s, background 0.1s;
}

.fi-sf-logout:hover {
    color: #fca5a5;
    background: rgba(220, 38, 38, 0.2);
}
```

- [ ] **Step 2: Build and verify no errors**

```bash
cd mylrmp && npm run build
```

Expected output ends with: `✓ built in X.XXs` — no errors.

- [ ] **Step 3: Commit**

```bash
cd mylrmp
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): rewrite theme — global, sidebar, topbar"
```

---

### Task 2: Page header, breadcrumbs, and section cards

**Files:**
- Modify: `mylrmp/resources/css/filament/admin/theme.css`

- [ ] **Step 1: Append to theme.css**

Add this block at the end of `theme.css`:

```css
/* ═══════════════════════════════════════════════════════════
   PAGE HEADER & BREADCRUMBS
   ═══════════════════════════════════════════════════════════ */

.fi-header-heading {
    font-size: 1.3125rem !important;
    font-weight: 700 !important;
    letter-spacing: -0.035em !important;
    color: #061B31 !important;
    line-height: 1.2 !important;
}

.fi-header-subheading {
    font-size: 0.8125rem !important;
    color: #64748D !important;
    margin-top: 3px !important;
}

.fi-breadcrumbs ol li a {
    color: #006837 !important;
    font-size: 0.8125rem !important;
    font-weight: 500 !important;
    transition: color 75ms ease !important;
    text-decoration: none !important;
}

.fi-breadcrumbs ol li a:hover {
    color: #004d28 !important;
}

.fi-breadcrumbs ol li:not(:first-child)::before {
    color: #9aabbc !important;
}

/* ═══════════════════════════════════════════════════════════
   SECTION / PANEL CARDS
   ═══════════════════════════════════════════════════════════ */

.fi-section:not(.fi-section-not-contained):not(.fi-aside) {
    border-radius: 10px !important;
    background-color: #ffffff !important;
    border: 1px solid #E5EDF5 !important;
    box-shadow: rgba(50, 50, 93, 0.10) 0px 8px 24px -8px,
                rgba(0, 0, 0, 0.06) 0px 4px 12px -4px !important;
}

.fi-section-header {
    padding: 14px 20px !important;
    border-bottom: 1px solid #E5EDF5 !important;
}

.fi-section-header-heading {
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    color: #061B31 !important;
    letter-spacing: -0.01em !important;
}

.fi-section-header-description {
    font-size: 0.8125rem !important;
    color: #64748D !important;
    margin-top: 2px !important;
}

.fi-section-content {
    padding: 20px !important;
}

.fi-section-content-ctn {
    padding: 0 !important;
}
```

- [ ] **Step 2: Build**

```bash
cd mylrmp && npm run build
```

Expected: `✓ built in X.XXs`

- [ ] **Step 3: Commit**

```bash
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): page header, breadcrumbs, section cards"
```

---

### Task 3: Table — container, headers, cells, rows

**Files:**
- Modify: `mylrmp/resources/css/filament/admin/theme.css`

- [ ] **Step 1: Append to theme.css**

```css
/* ═══════════════════════════════════════════════════════════
   TABLE
   ═══════════════════════════════════════════════════════════ */

/* Container */
.fi-ta-ctn {
    border-radius: 10px !important;
    overflow: hidden !important;
    background-color: #ffffff !important;
    border: 1px solid #E5EDF5 !important;
    box-shadow: rgba(50, 50, 93, 0.10) 0px 8px 24px -8px,
                rgba(0, 0, 0, 0.06) 0px 4px 12px -4px !important;
}

/* Search / filter bar */
.fi-ta-filters-ctn,
.fi-ta-header {
    padding: 12px 16px !important;
    border-bottom: 1px solid #E5EDF5 !important;
    background: #ffffff !important;
}

/* Header cells */
.fi-ta-header-cell {
    background-color: #F8FAFC !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 0.07em !important;
    text-transform: uppercase !important;
    color: #9aabbc !important;
    padding: 9px 16px !important;
    border-bottom: 1px solid #E5EDF5 !important;
    white-space: nowrap !important;
}

.fi-ta-actions-header-cell,
.fi-ta-empty-header-cell {
    background-color: #F8FAFC !important;
    border-bottom: 1px solid #E5EDF5 !important;
    padding: 9px 16px !important;
}

/* Sort button */
.fi-ta-header-cell-sort-btn {
    color: #9aabbc !important;
}

.fi-ta-header-cell-sorted .fi-ta-header-cell-sort-btn {
    color: #006837 !important;
}

/* Body cells */
.fi-ta-cell {
    padding: 12px 16px !important;
    color: #2d3e55 !important;
    font-size: 0.84375rem !important;
    border-bottom: 1px solid #F1F5F9 !important;
    vertical-align: middle !important;
}

/* Selection cells — match body cell padding */
.fi-ta-selection-cell {
    padding: 12px !important;
    border-bottom: 1px solid #F1F5F9 !important;
    vertical-align: middle !important;
}

/* Last row — remove bottom border */
.fi-ta-row:last-child .fi-ta-cell,
.fi-ta-row:last-child .fi-ta-selection-cell {
    border-bottom: none !important;
}

/* Row hover */
.fi-ta-row:hover .fi-ta-cell,
.fi-ta-row:hover .fi-ta-selection-cell {
    background-color: #fafbfc !important;
}

/* Pagination */
.fi-ta-pagination-ctn,
.fi-ta-pagination {
    padding: 10px 16px !important;
    border-top: 1px solid #E5EDF5 !important;
    background: #F8FAFC !important;
}

.fi-pagination-item-btn.fi-active,
.fi-pagination-item-btn[aria-current="page"] {
    background-color: #006837 !important;
    border-color: #006837 !important;
    color: #ffffff !important;
}
```

- [ ] **Step 2: Build**

```bash
cd mylrmp && npm run build
```

Expected: `✓ built in X.XXs`

- [ ] **Step 3: Commit**

```bash
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): table container, headers, cells, rows, pagination"
```

---

### Task 4: Status badges

**Files:**
- Modify: `mylrmp/resources/css/filament/admin/theme.css`

- [ ] **Step 1: Append to theme.css**

```css
/* ═══════════════════════════════════════════════════════════
   BADGES / STATUS PILLS
   ═══════════════════════════════════════════════════════════ */

.fi-badge {
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    font-size: 11.5px !important;
    font-weight: 500 !important;
    padding: 3px 10px 3px 8px !important;
    border-radius: 6px !important;
    letter-spacing: 0 !important;
    line-height: 1.4 !important;
    border: none !important;
}

/* Dot indicator */
.fi-badge::before {
    content: '' !important;
    width: 5px !important;
    height: 5px !important;
    border-radius: 50% !important;
    flex-shrink: 0 !important;
    display: inline-block !important;
}

/* Success / Diluluskan (green) */
.fi-badge.fi-color-success,
.fi-badge.fi-color-custom[style*="--c-badge"] {
    background-color: #f0fdf4 !important;
    color: #15803d !important;
}

.fi-badge.fi-color-success::before {
    background-color: #16a34a !important;
    box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.18) !important;
}

/* Warning / Semakan (amber) */
.fi-badge.fi-color-warning {
    background-color: #fffbeb !important;
    color: #d97706 !important;
    border: none !important;
}

.fi-badge.fi-color-warning::before {
    background-color: #d97706 !important;
}

/* Danger / Ditolak (red) */
.fi-badge.fi-color-danger {
    background-color: #fef2f2 !important;
    color: #dc2626 !important;
    border: none !important;
}

.fi-badge.fi-color-danger::before {
    background-color: #dc2626 !important;
}

/* Info / Dihantar (blue) */
.fi-badge.fi-color-info {
    background-color: #eff6ff !important;
    color: #2563eb !important;
    border: none !important;
}

.fi-badge.fi-color-info::before {
    background-color: #2563eb !important;
}

/* Gray / Draf (muted) */
.fi-badge.fi-color-gray,
.fi-badge.fi-color-secondary {
    background-color: #F8FAFC !important;
    color: #64748D !important;
    border: 1px solid #E5EDF5 !important;
}

.fi-badge.fi-color-gray::before,
.fi-badge.fi-color-secondary::before {
    background-color: #cdd8e5 !important;
}

/* Primary (green brand) */
.fi-badge.fi-color-primary {
    background-color: #f0fdf4 !important;
    color: #006837 !important;
    border: none !important;
}

.fi-badge.fi-color-primary::before {
    background-color: #006837 !important;
}
```

- [ ] **Step 2: Build**

```bash
cd mylrmp && npm run build
```

Expected: `✓ built in X.XXs`

- [ ] **Step 3: Commit**

```bash
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): status badge pills with dot indicators"
```

---

### Task 5: Infolist / view pages

**Files:**
- Modify: `mylrmp/resources/css/filament/admin/theme.css`

- [ ] **Step 1: Append to theme.css**

```css
/* ═══════════════════════════════════════════════════════════
   INFOLIST (VIEW / DETAIL PAGES)
   ═══════════════════════════════════════════════════════════ */

/* Entry label */
.fi-in-entry-label-ctn label,
.fi-in-entry-label {
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 0.07em !important;
    text-transform: uppercase !important;
    color: #9aabbc !important;
    margin-bottom: 5px !important;
    line-height: 1.4 !important;
}

/* Entry value */
.fi-in-text-entry-content {
    font-size: 0.9375rem !important;
    color: #061B31 !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
}

/* Infolist layout spacing */
.fi-in-entry {
    gap: 4px !important;
}

.fi-in {
    gap: 20px !important;
}

/* Relation manager tables inside view pages */
.fi-relation-manager .fi-ta-ctn {
    box-shadow: none !important;
    border: 1px solid #E5EDF5 !important;
}
```

- [ ] **Step 2: Build**

```bash
cd mylrmp && npm run build
```

Expected: `✓ built in X.XXs`

- [ ] **Step 3: Commit**

```bash
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): infolist labels, values, view page layout"
```

---

### Task 6: Form inputs, labels, and buttons

**Files:**
- Modify: `mylrmp/resources/css/filament/admin/theme.css`

- [ ] **Step 1: Append to theme.css**

```css
/* ═══════════════════════════════════════════════════════════
   FORM INPUTS & LABELS
   ═══════════════════════════════════════════════════════════ */

.fi-fo-field-wrp-label label {
    font-size: 0.8125rem !important;
    font-weight: 500 !important;
    color: #061B31 !important;
    letter-spacing: 0 !important;
}

.fi-input-wrp {
    border-radius: 8px !important;
    background-color: #ffffff !important;
    border: 1px solid #E5EDF5 !important;
    box-shadow: none !important;
    transition: border-color 0.12s, box-shadow 0.12s !important;
}

.fi-input-wrp:not(.fi-disabled):not(:has(.fi-ac-action:focus)):focus-within {
    border-color: #006837 !important;
    box-shadow: 0 0 0 3px rgba(0, 104, 55, 0.10) !important;
}

.fi-input-wrp.fi-invalid {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08) !important;
}

.fi-input-wrp.fi-disabled {
    background-color: #F8FAFC !important;
    border-color: #E5EDF5 !important;
    opacity: 0.7 !important;
}

/* Select / textarea inherit */
.fi-select-input,
.fi-textarea-input {
    font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
    font-size: 0.875rem !important;
    color: #061B31 !important;
}

/* ═══════════════════════════════════════════════════════════
   BUTTONS
   ═══════════════════════════════════════════════════════════ */

.fi-btn {
    border-radius: 6px !important;
    font-weight: 500 !important;
    font-size: 0.875rem !important;
    font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
    transition: background 0.12s, transform 0.12s !important;
}

.fi-btn:hover {
    transform: translateY(-1px) !important;
}

.fi-btn:active {
    transform: translateY(0) !important;
}
```

- [ ] **Step 2: Build**

```bash
cd mylrmp && npm run build
```

Expected: `✓ built in X.XXs`

- [ ] **Step 3: Commit**

```bash
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): form inputs, labels, buttons"
```

---

### Task 7: Dropdowns, modals, and notification panel

**Files:**
- Modify: `mylrmp/resources/css/filament/admin/theme.css`

- [ ] **Step 1: Append to theme.css**

```css
/* ═══════════════════════════════════════════════════════════
   DROPDOWN
   ═══════════════════════════════════════════════════════════ */

.fi-dropdown-panel {
    border-radius: 10px !important;
    border: 1px solid #E5EDF5 !important;
    box-shadow: rgba(50, 50, 93, 0.20) 0px 13px 27px -5px,
                rgba(0, 0, 0, 0.10) 0px 8px 16px -8px !important;
    overflow: hidden !important;
}

.fi-dropdown-list-item-btn {
    font-size: 0.875rem !important;
    color: #2d3e55 !important;
    padding: 8px 14px !important;
    transition: background 0.08s !important;
}

.fi-dropdown-list-item-btn:hover {
    background-color: #F8FAFC !important;
    color: #061B31 !important;
}

/* ═══════════════════════════════════════════════════════════
   MODAL
   ═══════════════════════════════════════════════════════════ */

.fi-modal-window {
    border-radius: 12px !important;
    border: 1px solid #E5EDF5 !important;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -15px,
                rgba(0, 0, 0, 0.15) 0px 18px 36px -18px !important;
}

.fi-modal-header {
    padding: 18px 22px 16px !important;
    border-bottom: 1px solid #E5EDF5 !important;
}

.fi-modal-heading {
    font-size: 1rem !important;
    font-weight: 600 !important;
    color: #061B31 !important;
    letter-spacing: -0.01em !important;
}

.fi-modal-content {
    padding: 20px 22px !important;
}

.fi-modal-footer {
    padding: 14px 22px !important;
    border-top: 1px solid #E5EDF5 !important;
    background: #F8FAFC !important;
}

/* ═══════════════════════════════════════════════════════════
   NOTIFICATION PANEL
   ═══════════════════════════════════════════════════════════ */

.fi-no-ctn {
    border-radius: 10px !important;
    border: 1px solid #E5EDF5 !important;
    box-shadow: rgba(50, 50, 93, 0.20) 0px 13px 27px -5px,
                rgba(0, 0, 0, 0.10) 0px 8px 16px -8px !important;
}
```

- [ ] **Step 2: Build**

```bash
cd mylrmp && npm run build
```

Expected: `✓ built in X.XXs`

- [ ] **Step 3: Commit**

```bash
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): dropdowns, modals, notification panel"
```

---

### Task 8: Final build, visual verification, and cleanup

**Files:**
- Read: browser at `http://localhost/admin` (or whatever the local dev URL is)

- [ ] **Step 1: Final production build**

```bash
cd mylrmp && npm run build
```

Expected: clean build, no errors or warnings about missing files.

- [ ] **Step 2: Visual checklist — open admin in browser (Ctrl+Shift+R to hard refresh)**

Verify each page type:

| Page | Check |
|------|-------|
| Any list (e.g. `/admin/users`) | Table has uppercase muted headers, row hover, badge dots, stripe shadow on container |
| Any view (e.g. `/admin/registration-applications/{id}/view`) | Labels are uppercase muted, values are navy, clean card layout |
| Any edit form (e.g. `/admin/active-ingredients/{id}/edit`) | Input borders clean, focus = green ring, labels 13px |
| Dashboard | KPI cards have colored top border accents, table matches list style |
| Sidebar (any page) | Dark green body, active item green-700, user name + role + logout at bottom |

- [ ] **Step 3: Final commit**

```bash
git add resources/css/filament/admin/theme.css
git commit -m "style(admin): complete UI redesign — industri design system applied"
```

---

## Self-Review

**Spec coverage:**
- ✅ Body background (#F8FAFC) — Task 1
- ✅ Content padding (24px 28px) — Task 1
- ✅ Topbar — Task 1
- ✅ Sidebar (green-900, active green-700, hover green-800) — Task 1
- ✅ Sidebar user footer (avatar, name, role, logout) — Task 1
- ✅ Page header + breadcrumbs — Task 2
- ✅ Section cards (border, shadow, header, content padding) — Task 2
- ✅ Table container — Task 3
- ✅ Table headers (uppercase, muted, small) — Task 3
- ✅ Table cells (padding, color) — Task 3
- ✅ Table row hover — Task 3
- ✅ Pagination (green active) — Task 3
- ✅ Status badges (dot indicator, color variants) — Task 4
- ✅ Infolist labels (uppercase muted) + values (navy) — Task 5
- ✅ Form inputs (clean border, green focus ring) — Task 6
- ✅ Buttons (rounded, Poppins, hover lift) — Task 6
- ✅ Dropdown panel — Task 7
- ✅ Modal window — Task 7
- ✅ Notification panel — Task 7

**No placeholders found.**

**Type consistency:** All CSS class names cross-checked against Filament v3 source (`fi-ta-header-cell`, `fi-ta-cell`, `fi-ta-row`, `fi-badge`, `fi-in-entry-label-ctn`, `fi-input-wrp`, `fi-btn`, `fi-dropdown-panel`, `fi-modal-window`, `fi-no-ctn`).
