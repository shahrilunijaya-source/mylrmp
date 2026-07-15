<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'myLRMP' }} — Portal Industri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
:root {
  /* Reference design tokens */
  --navy:        #061B31;
  --slate:       #64748D;
  --off-white:   #F8FAFC;
  --border:      #E5EDF5;
  --shadow-blue: rgba(50,50,93,0.25);
  --shadow-blk:  rgba(0,0,0,0.10);

  /* Aliases for blade templates */
  --bg:          #F8FAFC;
  --surface:     #ffffff;
  --surface-2:   #F8FAFC;
  --border-2:    #cdd8e5;

  --text:        #061B31;
  --text-2:      #2d3e55;
  --text-3:      #64748D;
  --text-4:      #9aabbc;

  --brand:       #006837;
  --brand-light: #f0fdf4;
  --brand-mid:   #16a34a;
  --brand-dark:  #004d28;
  --gold:        #FFCC00;

  --amber:       #d97706;
  --amber-bg:    #fffbeb;
  --red:         #dc2626;
  --red-bg:      #fef2f2;
  --blue:        #2563eb;
  --blue-bg:     #eff6ff;
  --orange:      #f97316;
  --orange-bg:   #fff7ed;
  --purple:      #7c3aed;
  --purple-bg:   #faf5ff;
  --teal:        #0e7490;
  --teal-bg:     #ecfeff;

  --mono: 'SF Mono', 'Cascadia Code', ui-monospace, 'Courier New', monospace;
  --font: 'Poppins', sans-serif;

  --stripe-shadow: rgba(50,50,93,0.25) 0px 13px 27px -5px, rgba(0,0,0,0.10) 0px 8px 16px -8px;
  --stripe-shadow-sm: rgba(50,50,93,0.15) 0px 8px 18px -6px, rgba(0,0,0,0.06) 0px 4px 10px -4px;

  --sidebar-w: 242px;
  --topbar-h:  56px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; overflow: hidden; }
body {
  font-family: var(--font);
  -webkit-font-smoothing: antialiased;
  background: var(--bg);
  color: var(--text);
  display: flex;
  font-size: 14px;
}

/* ─── STRIPE SHADOWS ─────────────────────────────────── */
.stripe-shadow    { box-shadow: var(--stripe-shadow); }
.stripe-shadow-sm { box-shadow: var(--stripe-shadow-sm); }
.card-hover { transition: transform 200ms ease-out, box-shadow 200ms ease-out; }
.card-hover:hover { transform: translateY(-3px); box-shadow: var(--stripe-shadow); }
.eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--brand); }

/* ─── SIDEBAR ─────────────────────────────────────────── */
.sidebar {
  width: var(--sidebar-w);
  min-width: var(--sidebar-w);
  background: var(--surface);
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
  flex-shrink: 0;
}
.sidebar-top {
  padding: 18px 16px 14px;
  border-bottom: 1px solid var(--border);
  flex-shrink: 0;
}
.brand-anchor {
  display: flex; align-items: center; gap: 10px;
  text-decoration: none;
}
.brand-mark {
  width: 32px; height: 32px;
  background: var(--brand);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.brand-mark span { color: var(--gold); font-weight: 800; font-size: 12px; letter-spacing: -0.5px; }
.brand-name { font-size: 14.5px; font-weight: 700; color: var(--text); letter-spacing: -0.025em; line-height: 1.2; }
.brand-sub  { font-size: 10px; color: var(--text-4); margin-top: 1px; }

.sidebar-body { flex: 1; min-height: 0; padding: 8px 0; overflow-y: auto; }

.nav-sec {
  padding: 14px 16px 4px;
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.09em; text-transform: uppercase;
  color: var(--text-4);
}
.nav-a {
  display: flex; align-items: center; gap: 9px;
  padding: 8px 12px;
  margin: 1px 6px;
  border-radius: 7px;
  font-size: 13.5px; font-weight: 500;
  color: var(--text-3);
  text-decoration: none;
  transition: background 0.1s, color 0.1s;
  white-space: nowrap; overflow: hidden;
  cursor: pointer; border: none; background: none;
  width: calc(100% - 12px); text-align: left;
}
.nav-a:hover { background: var(--bg); color: var(--text-2); }
.nav-a.active {
  background: var(--brand-light);
  color: var(--brand);
  font-weight: 600;
  box-shadow: inset 3px 0 0 var(--brand);
  border-radius: 0 7px 7px 0;
  margin-left: 0; padding-left: 21px;
  width: calc(100% - 6px);
}
.nav-ic {
  width: 16px; height: 16px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; opacity: 0.55;
}
.nav-a.active .nav-ic { opacity: 1; }
.nav-badge {
  margin-left: auto;
  background: var(--brand); color: #fff;
  font-size: 10px; font-weight: 700;
  padding: 1px 6px; border-radius: 9999px;
  min-width: 18px; text-align: center;
}

/* ─── Disabled / roadmap nav items ─────────────────────── */
.nav-a.is-disabled {
  opacity: 0.40;
  cursor: not-allowed;
  pointer-events: auto;
  position: relative;
}
.nav-a.is-disabled:hover {
  opacity: 0.55;
  background: transparent;
  color: var(--text-3);
}
.nav-a.is-disabled[data-tip]::after {
  content: attr(data-tip);
  position: absolute;
  left: calc(100% + 8px); top: 50%;
  transform: translateY(-50%);
  background: #0F172A;
  color: #fff;
  font-size: 11px; font-weight: 500;
  padding: 5px 10px;
  border-radius: 6px;
  white-space: nowrap;
  box-shadow: 0 4px 12px rgba(0,0,0,0.30);
  opacity: 0; pointer-events: none;
  transition: opacity 150ms ease;
  z-index: 50;
}
.nav-a.is-disabled[data-tip]:hover::after { opacity: 1; }

.sidebar-footer {
  border-top: 1px solid var(--border);
  padding: 10px 12px;
  display: flex; align-items: center; gap: 9px;
  flex-shrink: 0;
}
.sf-avatar {
  width: 32px; height: 32px;
  background: var(--brand); color: #fff;
  border-radius: 50%;
  font-size: 11.5px; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; letter-spacing: -0.3px;
}
.sf-name { font-size: 12.5px; font-weight: 600; color: var(--text); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.sf-co   { font-size: 10.5px; color: var(--text-4); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.sf-logout {
  margin-left: auto; flex-shrink: 0;
  background: none; border: none;
  color: var(--text-4); cursor: pointer;
  padding: 5px; border-radius: 6px;
  display: flex; align-items: center;
  transition: color 0.1s, background 0.1s;
}
.sf-logout:hover { color: var(--red); background: var(--red-bg); }

/* ─── MAIN ──────────────────────────────────────────────── */
.main {
  flex: 1; display: flex; flex-direction: column;
  height: 100vh; overflow: hidden; min-width: 0;
}

/* ─── TOPBAR ─────────────────────────────────────────────── */
.topbar {
  height: var(--topbar-h); min-height: var(--topbar-h);
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  padding: 0 28px;
  display: flex; align-items: center; gap: 12px;
  flex-shrink: 0;
}
.topbar-back {
  display: flex; align-items: center; gap: 6px;
  font-size: 13px; color: var(--text-3);
  text-decoration: none; cursor: pointer;
  transition: color 0.1s;
}
.topbar-back:hover { color: var(--brand); }
.topbar-div { width: 1px; height: 18px; background: var(--border); flex-shrink: 0; }
.topbar-title {
  font-size: 14.5px; font-weight: 600;
  color: var(--text); letter-spacing: -0.02em;
}
.topbar-right { margin-left: auto; display: flex; align-items: center; gap: 8px; }
.btn-ghost {
  display: flex; align-items: center; justify-content: center;
  width: 34px; height: 34px;
  background: none; border: 1px solid var(--border);
  border-radius: 8px; cursor: pointer;
  color: var(--text-3); text-decoration: none;
  transition: all 0.1s; position: relative;
}
.btn-ghost:hover { background: var(--bg); color: var(--text-2); border-color: var(--border-2); }
.notif-dot {
  position: absolute; top: 7px; right: 7px;
  width: 6px; height: 6px;
  background: var(--red); border-radius: 50%;
  border: 1.5px solid var(--surface);
}
.btn-primary {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 8px 16px;
  background: var(--brand); color: #fff;
  font-family: var(--font);
  font-size: 13px; font-weight: 500;
  border: none; border-radius: 4px;
  cursor: pointer; text-decoration: none;
  transition: background 150ms ease, transform 150ms ease;
  white-space: nowrap;
}
.btn-primary:hover { background: var(--brand-dark); transform: translateY(-1px); }
.btn-primary:active { transform: translateY(0); }

/* ─── CONTENT ────────────────────────────────────────────── */
.main-content {
  flex: 1; overflow-y: auto;
  padding: 28px 32px;
  background: var(--bg);
}
::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

/* ─── PAGE HEADING ───────────────────────────────────────── */
.pg-head {
  display: flex; align-items: flex-start;
  justify-content: space-between; gap: 16px;
  margin-bottom: 28px;
}
.pg-title {
  font-size: 21px; font-weight: 700;
  color: var(--text); letter-spacing: -0.03em; line-height: 1.2;
}
.pg-sub { font-size: 13px; color: var(--text-3); margin-top: 4px; }

/* ─── KPI CARDS ──────────────────────────────────────────── */
.kpi-row {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 16px; margin-bottom: 28px;
}
.kpi {
  background: var(--surface);
  border: 1px solid var(--border);
  border-top: 2px solid var(--border-2);
  border-radius: 8px;
  padding: 20px 22px 18px;
  box-shadow: var(--stripe-shadow-sm);
  transition: transform 200ms ease-out, box-shadow 200ms ease-out;
}
.kpi:hover { transform: translateY(-2px); box-shadow: var(--stripe-shadow); }
.kpi.accent-brand { border-top-color: var(--brand); }
.kpi.accent-amber { border-top-color: var(--amber); }
.kpi.accent-red   { border-top-color: var(--red); }
.kpi-lbl {
  font-size: 10.5px; font-weight: 700;
  letter-spacing: 0.08em; text-transform: uppercase;
  color: var(--text-4); margin-bottom: 14px;
}
.kpi-val {
  font-size: 40px; font-weight: 700;
  letter-spacing: -0.05em; color: var(--text);
  line-height: 1; margin-bottom: 10px;
  font-variant-numeric: tabular-nums;
}
.kpi-val.v-brand { color: var(--brand); }
.kpi-val.v-amber { color: var(--amber); }
.kpi-val.v-red   { color: var(--red); }
.kpi-foot { font-size: 11.5px; color: var(--text-4); display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.kpi-foot strong { color: var(--text-3); font-weight: 500; }
.kpi-trend {
  display: inline-flex; align-items: center; gap: 2px;
  font-size: 10.5px; font-weight: 600;
  padding: 1px 5px; border-radius: 4px;
}
.trend-up  { background: var(--brand-light); color: var(--brand); }
.trend-neu { background: var(--bg); color: var(--text-4); border: 1px solid var(--border); }

/* ─── SECTION CARD ───────────────────────────────────────── */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 20px;
  box-shadow: var(--stripe-shadow-sm);
}
.card-head {
  display: flex; align-items: center;
  padding: 15px 20px; border-bottom: 1px solid var(--border); gap: 10px;
}
.card-title { font-size: 13.5px; font-weight: 600; color: var(--text); letter-spacing: -0.01em; flex: 1; }
.card-meta  { font-size: 12px; color: var(--text-4); }
.card-link {
  font-size: 12.5px; font-weight: 500;
  color: var(--brand); text-decoration: none;
  display: flex; align-items: center; gap: 3px;
  transition: color 0.1s;
}
.card-link:hover { color: var(--brand-dark); }

/* ─── DATA TABLE ─────────────────────────────────────────── */
.tbl { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.tbl th {
  font-size: 10.5px; font-weight: 700;
  letter-spacing: 0.06em; text-transform: uppercase;
  color: var(--text-4); padding: 10px 16px;
  border-bottom: 1px solid var(--border);
  text-align: left; background: var(--surface-2); white-space: nowrap;
}
.tbl td {
  padding: 13px 16px;
  border-bottom: 1px solid var(--border);
  color: var(--text-2); vertical-align: middle;
}
.tbl tr:last-child td { border-bottom: none; }
.tbl tbody tr { transition: background 0.08s; }
.tbl tbody tr:hover td { background: #fafbfc; }

.app-chip {
  font-family: var(--mono);
  font-size: 11px;
  background: var(--bg); border: 1px solid var(--border);
  color: var(--text-3); padding: 2px 8px;
  border-radius: 5px; letter-spacing: 0.03em;
  white-space: nowrap; display: inline-block;
}
.prod-name { font-size: 13.5px; font-weight: 500; color: var(--text); line-height: 1.3; }
.prod-ing  { font-size: 11.5px; color: var(--text-4); margin-top: 1px; }

/* ─── STATUS PILLS ───────────────────────────────────────── */
.st {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 11.5px; font-weight: 500;
  padding: 3px 9px 3px 7px; border-radius: 6px;
  white-space: nowrap; line-height: 1.4;
}
.st::before {
  content: ''; width: 5px; height: 5px;
  border-radius: 50%; flex-shrink: 0;
}
.st-ok   { background: var(--brand-light); color: var(--brand); }
.st-ok::before   { background: var(--brand-mid); box-shadow: 0 0 0 2px rgba(22,163,74,.2); }
.st-rev  { background: var(--amber-bg); color: var(--amber); }
.st-rev::before  { background: var(--amber); }
.st-rej  { background: var(--red-bg); color: var(--red); }
.st-rej::before  { background: var(--red); }
.st-sub  { background: var(--blue-bg); color: var(--blue); }
.st-sub::before  { background: var(--blue); }
.st-drf  { background: var(--bg); color: var(--text-3); border: 1px solid var(--border); }
.st-drf::before  { background: var(--border-2); }
.st-nds  { background: var(--orange-bg); color: var(--orange); }
.st-nds::before  { background: var(--orange); }
.st-tec  { background: var(--purple-bg); color: var(--purple); }
.st-tec::before  { background: #8b5cf6; }
.st-lbl  { background: var(--teal-bg); color: var(--teal); }
.st-lbl::before  { background: #06b6d4; }
.st-dec  { background: #fff7ed; color: #c2410c; }
.st-dec::before  { background: #f97316; }

.tbl-action {
  font-size: 12px; font-weight: 500;
  color: var(--brand); text-decoration: none;
  padding: 4px 10px;
  border: 1px solid #bbf7d0; border-radius: 6px;
  background: var(--brand-light);
  display: inline-block; transition: all 0.1s; white-space: nowrap;
}
.tbl-action:hover { background: #dcfce7; border-color: #86efac; color: var(--brand-dark); }

/* ─── EMPTY STATE ─────────────────────────────────────────── */
.empty {
  padding: 56px 24px; text-align: center;
  display: flex; flex-direction: column; align-items: center;
}
.empty-icon {
  width: 44px; height: 44px; background: var(--bg);
  border: 1px solid var(--border); border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 14px; color: var(--text-4);
}
.empty-title { font-size: 14px; font-weight: 600; color: var(--text-2); margin-bottom: 5px; }
.empty-sub   { font-size: 13px; color: var(--text-4); margin-bottom: 18px; max-width: 280px; }

/* ─── SECTION HEADING (wizard pages etc.) ─────────────────── */
.section-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 10px; padding: 20px; margin-bottom: 20px;
}
.section-header {
  display: flex; align-items: center;
  justify-content: space-between; margin-bottom: 14px;
}
.section-title { font-size: 14px; font-weight: 600; color: var(--text); }
.section-more  { font-size: 12.5px; color: var(--brand); cursor: pointer; font-weight: 500; text-decoration: none; }
.section-more:hover { text-decoration: underline; }

/* ─── BADGE (legacy compat) ──────────────────────────────── */
.badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 500; gap: 5px; }
.badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.badge-diluluskan   { background: var(--brand-light); color: var(--brand); }
.badge-diluluskan::before { background: var(--brand-mid); }
.badge-ditolak      { background: var(--red-bg); color: var(--red); }
.badge-ditolak::before { background: var(--red); }
.badge-dalam-proses { background: var(--amber-bg); color: var(--amber); }
.badge-dalam-proses::before { background: var(--amber); }
.badge-draf         { background: var(--bg); color: var(--text-3); border: 1px solid var(--border); }
.badge-draf::before { background: var(--border-2); }
.badge-dihantar     { background: var(--blue-bg); color: var(--blue); }
.badge-dihantar::before { background: var(--blue); }
.badge-semakan      { background: var(--orange-bg); color: var(--orange); }
.badge-semakan::before { background: var(--orange); }

/* ─── CHIPS ───────────────────────────────────────────────── */
.chip { font-size: 10.5px; font-weight: 600; padding: 2px 8px; border-radius: 5px; display: inline-flex; align-items: center; }
.chip-brand { background: var(--brand-light); color: var(--brand); }
.chip-green { background: #dcfce7; color: #15803d; }
.chip-amber { background: var(--amber-bg); color: var(--amber); }
.chip-red   { background: var(--red-bg); color: var(--red); }
.chip-blue  { background: var(--blue-bg); color: var(--blue); }
.chip-gray  { background: var(--bg); color: var(--text-3); border: 1px solid var(--border); }

input, select, textarea { font-family: var(--font); }
[x-cloak] { display: none !important; }
    </style>
    @livewireStyles
</head>
<body>

{{-- ═══ SIDEBAR ═══ --}}
<nav class="sidebar">
    <div class="sidebar-top">
        <a href="{{ route('industri.dashboard') }}" class="brand-anchor">
            <img src="/images/mylrmp-logo.png" alt="myLRMP" style="height: 38px; width: auto; flex-shrink: 0;">
        </a>
    </div>

    <div class="sidebar-body">
        <div class="nav-sec">Utama</div>
        <a href="{{ route('industri.dashboard') }}"
           class="nav-a {{ request()->routeIs('industri.dashboard') ? 'active' : '' }}">
            <span class="nav-ic">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h3a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h3a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
            </span>
            <span>Papan Pemuka</span>
        </a>
        <a href="{{ route('industri.applications.index') }}"
           class="nav-a {{ request()->routeIs('industri.applications.*') ? 'active' : '' }}">
            <span class="nav-ic">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
            </span>
            <span>Permohonan</span>
        </a>

        <a href="{{ route('industri.pemeriksaan.index') }}"
           class="nav-a {{ request()->routeIs('industri.pemeriksaan.*') ? 'active' : '' }}">
            <span class="nav-ic">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </span>
            <span>Rekod Pemeriksaan</span>
        </a>

        {{-- Dimmed: pending Permohonan sub-types --}}
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg></span>
            <span>Pindaan Borang A</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg></span>
            <span>Permohonan Iklan</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/></svg></span>
            <span>Permit Import R&D</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg></span>
            <span>Pek & Label Produk</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/></svg></span>
            <span>Khidmat Teknikal</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"/></svg></span>
            <span>Lesen PCO/PA/APA</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/><path d="M3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg></span>
            <span>Peperiksaan Online</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd"/></svg></span>
            <span>Sampel Piawai</span>
        </span>

        <div class="nav-sec">Akaun</div>
        <a href="{{ route('industri.profile') }}"
           class="nav-a {{ request()->routeIs('industri.profile') ? 'active' : '' }}">
            <span class="nav-ic">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zm14 5H2v6a2 2 0 002 2h12a2 2 0 002-2V9z" clip-rule="evenodd"/>
                </svg>
            </span>
            <span>Profil Syarikat</span>
        </a>

        <div class="nav-sec">Khidmat</div>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg></span>
            <span>Bayaran Dalam Talian</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/></svg></span>
            <span>Aduan & Cadangan</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg></span>
            <span>Temujanji Pelanggan</span>
        </span>
        <span class="nav-a is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">
            <span class="nav-ic"><svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg></span>
            <span>Aplikasi Mudah Alih</span>
        </span>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('industri.profile') }}" style="display:flex;align-items:center;gap:9px;text-decoration:none;min-width:0;flex:1;overflow:hidden;">
            <div class="sf-avatar" style="font-size:11px;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 2)) }}
            </div>
            <div style="min-width:0;flex:1;overflow:hidden;">
                <div class="sf-name">{{ auth()->user()?->name }}</div>
                <div class="sf-co">{{ auth()->user()?->company?->name ?? 'Portal Industri' }}</div>
            </div>
        </a>
        <form method="POST" action="{{ route('industri.logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="sf-logout" title="Log Keluar">
                <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                </svg>
            </button>
        </form>
    </div>
</nav>

{{-- ═══ MAIN ═══ --}}
<div class="main">

    {{-- Topbar --}}
    <div class="topbar">
        @if(request()->routeIs('industri.applications.show'))
            <a class="topbar-back" href="{{ route('industri.applications.index') }}">
                <svg viewBox="0 0 16 16" fill="none" width="13" height="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.5 3L5 8l5.5 5"/>
                </svg>
                Kembali
            </a>
            <div class="topbar-div"></div>
        @endif
        <span class="topbar-title">{{ $title ?? 'Portal Industri' }}</span>

        <div class="topbar-right">
            <a href="#" class="btn-ghost" title="Notifikasi">
                <div class="notif-dot"></div>
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
            </a>
            <a href="{{ route('industri.applications.create') }}" class="btn-primary">
                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Buat Permohonan
            </a>
        </div>
    </div>

    {{-- Page content --}}
    <main class="main-content">
        {{ $slot }}
    </main>

</div>

@livewireScripts
@include('partials.supportos-widget')
</body>
</html>
