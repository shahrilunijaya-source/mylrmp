<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal Pegawai' }} — myLRMP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
:root {
  --navy:        #061B31;
  --navy-2:      #0a2440;
  --navy-3:      #0f3060;
  --bg:          #F8FAFC;
  --surface:     #ffffff;
  --surface-2:   #F8FAFC;
  --border:      #E5EDF5;
  --border-2:    #cdd8e5;
  --text:        #061B31;
  --text-2:      #2d3e55;
  --text-3:      #64748D;
  --text-4:      #9aabbc;
  --gold:        #FFCC00;
  --gold-dark:   #e6b800;
  --brand:       #006837;
  --brand-light: #f0fdf4;
  --brand-mid:   #16a34a;
  --amber:       #d97706;  --amber-bg:    #fffbeb;
  --red:         #dc2626;  --red-bg:      #fef2f2;
  --blue:        #2563eb;  --blue-bg:     #eff6ff;
  --orange:      #f97316;  --orange-bg:   #fff7ed;
  --purple:      #7c3aed;  --purple-bg:   #faf5ff;
  --teal:        #0e7490;  --teal-bg:     #ecfeff;
  --mono: 'SF Mono','Cascadia Code',ui-monospace,'Courier New',monospace;
  --font: 'Poppins', sans-serif;
  --stripe-shadow:    rgba(50,50,93,0.25) 0px 13px 27px -5px, rgba(0,0,0,0.10) 0px 8px 16px -8px;
  --stripe-shadow-sm: rgba(50,50,93,0.15) 0px 8px 18px -6px, rgba(0,0,0,0.06) 0px 4px 10px -4px;
  --sidebar-w: 248px;
  --topbar-h:  58px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { height: 100%; overflow: hidden; }
body {
  font-family: var(--font);
  -webkit-font-smoothing: antialiased;
  background: var(--bg);
  color: var(--text);
  display: flex; flex-direction: column;
  height: 100%; overflow: hidden;
  zoom: 1.07;
}
input, select, textarea { font-family: var(--font); }
[x-cloak] { display: none !important; }

/* ─── TOPBAR ─────────────────────────────────────────────── */
.topbar {
  height: var(--topbar-h); min-height: var(--topbar-h);
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center;
  padding: 0 24px; gap: 0; flex-shrink: 0; z-index: 20;
}
.topbar-logo {
  display: flex; align-items: center; gap: 10px;
  text-decoration: none; flex-shrink: 0;
}
.topbar-logo img { height: 42px; width: auto; }
.topbar-agency-name {
  font-size: 13px; font-weight: 700; color: var(--navy);
  letter-spacing: -0.01em; line-height: 1.25; white-space: nowrap;
}
.topbar-agency-sys {
  font-size: 10px; font-weight: 500; color: var(--text-4);
  letter-spacing: 0.01em; white-space: nowrap; margin-top: 1px;
}
.topbar-vdiv { width: 1px; height: 18px; background: var(--border); margin: 0 14px; flex-shrink: 0; }
.topbar-back {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 12.5px; font-weight: 400; color: var(--text-3);
  text-decoration: none; flex-shrink: 0;
  transition: color 120ms ease;
}
.topbar-back:hover { color: var(--navy); }
.topbar-back svg { flex-shrink: 0; }
.topbar-title {
  font-size: 13.5px; font-weight: 600; color: var(--text);
  letter-spacing: -0.02em; white-space: nowrap; overflow: hidden;
  text-overflow: ellipsis;
}
.topbar-right {
  margin-left: auto; display: flex; align-items: center; gap: 6px;
  flex-shrink: 0;
}
.notif-btn {
  position: relative;
  width: 32px; height: 32px;
  display: flex; align-items: center; justify-content: center;
  background: none; border: 1px solid var(--border);
  border-radius: 7px; cursor: pointer; color: var(--text-3);
  transition: background 100ms ease, border-color 100ms ease;
  text-decoration: none;
}
.notif-btn:hover { background: var(--surface-2); border-color: var(--border-2); color: var(--text); }
.notif-dot {
  position: absolute; top: 6px; right: 6px;
  width: 6px; height: 6px; background: var(--red);
  border-radius: 50%; border: 1.5px solid #fff;
}
.officer-badge {
  display: flex; align-items: center; gap: 5px;
  font-size: 11px; font-weight: 500; color: var(--text-3);
  padding: 4px 10px;
  background: var(--bg); border: 1px solid var(--border);
  border-radius: 99px; white-space: nowrap;
}
.officer-dot { width: 6px; height: 6px; background: var(--brand); border-radius: 50%; flex-shrink: 0; }
.prof-wrap { position: relative; }
.prof-btn {
  width: 30px; height: 30px;
  background: var(--navy); color: var(--gold);
  border-radius: 50%; font-size: 10px; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; border: none; letter-spacing: -0.3px;
  transition: opacity 150ms ease;
}
.prof-btn:hover { opacity: 0.82; }
.prof-pop {
  position: absolute; top: calc(100% + 8px); right: 0;
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 10px; box-shadow: var(--stripe-shadow);
  min-width: 200px; overflow: hidden; z-index: 200;
}
.prof-meta { padding: 12px 14px; border-bottom: 1px solid var(--border); }
.prof-meta-name { font-size: 12.5px; font-weight: 600; color: var(--text); }
.prof-meta-role { font-size: 11px; color: var(--text-4); margin-top: 2px; }
.prof-item {
  display: flex; align-items: center; gap: 8px;
  padding: 9px 14px; font-size: 13px; color: var(--text-2);
  text-decoration: none; transition: background 80ms ease;
  cursor: pointer; border: none; background: transparent;
  width: 100%; font-family: var(--font); text-align: left;
}
.prof-item:hover { background: var(--bg); }
.prof-item.danger { color: var(--red); }
.prof-item.danger:hover { background: var(--red-bg); }
.prof-sep { height: 1px; background: var(--border); margin: 3px 0; }

/* ─── MAIN CONTENT ───────────────────────────────────────── */
.main-content {
  flex: 1; overflow-y: auto;
  padding: 32px 36px;
  background: var(--bg); min-width: 0;
}
.main-content::-webkit-scrollbar { width: 4px; }
.main-content::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
.main-content::-webkit-scrollbar-track { background: transparent; }

/* Full-bleed variant (used by launcher) */
.main-content.flush { padding: 0; }

/* Back link inside content */
.page-back {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 13px; color: var(--text-3); text-decoration: none;
  margin-bottom: 22px; transition: color 100ms ease;
}
.page-back:hover { color: var(--navy); }

/* ─── MODULE CONTEXT BAR ─────────────────────────────────── */
.module-bar {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  padding: 14px 28px 0;
  flex-shrink: 0; z-index: 15;
}
.module-bar-top {
  display: flex; align-items: center; gap: 12px; margin-bottom: 8px;
}
.module-bar-back {
  font-size: 11.5px; color: var(--text-4);
  text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
  transition: color 100ms ease; flex-shrink: 0; white-space: nowrap;
}
.module-bar-back:hover { color: var(--navy); }
.module-bar-vsep { width: 1px; height: 14px; background: var(--border); flex-shrink: 0; }
.module-bar-name {
  font-size: 20px; font-weight: 700; color: var(--text);
  letter-spacing: -0.04em; line-height: 1;
}
.module-bar-code {
  font-size: 10px; font-weight: 700; letter-spacing: 0.04em;
  padding: 2px 8px; border-radius: 4px;
  background: rgba(6,27,49,.06); color: var(--text-2);
}
.module-bar-tabs {
  display: flex; align-items: stretch; height: 40px; gap: 0;
}
.mod-tab {
  position: relative;
  display: inline-flex; align-items: center;
  height: 100%; padding: 0 14px;
  font-size: 13px; font-weight: 400; font-family: var(--font);
  color: var(--text-3); text-decoration: none; white-space: nowrap;
  transition: color 120ms ease; cursor: pointer;
  border: none; background: transparent;
  border-bottom: 2px solid transparent;
  border-top: 2px solid transparent;
}
.mod-tab:hover { color: var(--text); }
.mod-tab.active {
  color: var(--navy); font-weight: 500; border-bottom-color: var(--navy);
}
.mod-tab.disabled {
  opacity: 0.38; cursor: not-allowed;
}
.mod-tab.disabled:hover { color: var(--text-3); opacity: 0.50; }
.mod-tab.disabled[data-tip]::after {
  content: attr(data-tip);
  position: absolute; left: 50%; top: calc(100% + 4px);
  transform: translateX(-50%);
  background: #0F172A; color: #fff;
  font-size: 11px; font-weight: 500;
  padding: 5px 10px; border-radius: 6px;
  white-space: nowrap; pointer-events: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.25);
  opacity: 0; transition: opacity 150ms ease; z-index: 200;
}
.mod-tab.disabled[data-tip]:hover::after { opacity: 1; }

/* ─── MODULE LAUNCHER ────────────────────────────────────── */
.launcher-hero {
  background: linear-gradient(135deg, var(--navy) 0%, #0a2a4a 100%);
  padding: 36px 36px 32px;
  display: flex; align-items: flex-start; justify-content: space-between; gap: 24px;
}
.launcher-hero-left {}
.launcher-eyebrow {
  font-size: 10px; font-weight: 700; letter-spacing: 0.14em;
  text-transform: uppercase; color: var(--gold); margin-bottom: 6px;
}
.launcher-title {
  font-size: 22px; font-weight: 700; color: #ffffff;
  letter-spacing: -0.03em; line-height: 1.2; margin-bottom: 4px;
}
.launcher-sub { font-size: 13px; color: rgba(255,255,255,0.55); }
.launcher-stats {
  display: flex; align-items: center; gap: 10px; flex-shrink: 0; flex-wrap: wrap;
  align-self: center;
}
.launcher-stat {
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 10px; padding: 10px 16px; text-align: center; min-width: 96px;
}
.launcher-stat-val { font-size: 22px; font-weight: 700; color: #fff; letter-spacing: -0.04em; line-height: 1; }
.launcher-stat-val.amber { color: var(--gold); }
.launcher-stat-val.green { color: #4ade80; }
.launcher-stat-lbl { font-size: 10.5px; color: rgba(255,255,255,0.45); margin-top: 3px; }

.launcher-body { padding: 28px 36px 40px; }
.launcher-sec-head { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.launcher-sec-eye { font-size: 10px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--text-4); }
.launcher-sec-line { flex: 1; height: 1px; background: var(--border); }
.launcher-sec-count { font-size: 11px; color: var(--text-4); }

.module-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
  margin-bottom: 36px;
}
.mod-tile {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 18px 16px 14px;
  display: flex; flex-direction: column;
  transition: transform 180ms ease-out, box-shadow 180ms ease-out;
  position: relative; overflow: hidden;
  text-decoration: none; color: inherit;
}
.mod-tile::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: var(--border); border-radius: 10px 10px 0 0;
}
.mod-tile.live::before { background: var(--navy); }
.mod-tile.live { cursor: pointer; }
.mod-tile.live:hover { transform: translateY(-3px); box-shadow: var(--stripe-shadow); }
.mod-tile.roadmap { background: var(--surface-2); cursor: default; }
.mod-tile.roadmap::before { background: var(--border-2); }

.mod-tile-top {
  display: flex; align-items: flex-start; justify-content: space-between;
  margin-bottom: 12px;
}
.mod-tile-icon {
  width: 38px; height: 38px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.mod-tile.live   .mod-tile-icon { background: var(--navy); color: #fff; }
.mod-tile.roadmap .mod-tile-icon { background: var(--border); color: var(--text-4); }
.mod-code {
  font-size: 10px; font-weight: 700; letter-spacing: 0.04em;
  padding: 2px 7px; border-radius: 4px;
}
.mod-tile.live   .mod-code { background: rgba(6,27,49,0.07); color: var(--navy); }
.mod-tile.roadmap .mod-code { background: var(--border); color: var(--text-4); }

.mod-tile-name {
  font-size: 13px; font-weight: 600; color: var(--text);
  margin-bottom: 5px; letter-spacing: -0.01em; line-height: 1.3;
}
.mod-tile.roadmap .mod-tile-name { color: var(--text-3); }
.mod-tile-desc {
  font-size: 11.5px; color: var(--text-4); line-height: 1.5; flex: 1;
}
.mod-tile-foot {
  display: flex; align-items: center; justify-content: space-between;
  margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--border);
}
.mod-status {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 10.5px; font-weight: 600; padding: 2px 8px;
  border-radius: 99px;
}
.mod-status.live   { background: var(--brand-light); color: var(--brand); }
.mod-status.live::before   { content:''; width:5px; height:5px; background:var(--brand-mid); border-radius:50%; box-shadow:0 0 0 2px rgba(22,163,74,.2); }
.mod-status.soon   { background: var(--amber-bg); color: var(--amber); }
.mod-status.soon::before   { content:''; width:5px; height:5px; background:var(--amber); border-radius:50%; }
.mod-tile-arrow {
  width: 24px; height: 24px;
  background: var(--bg); border: 1px solid var(--border);
  border-radius: 6px; display: flex; align-items: center; justify-content: center;
  color: var(--text-3); transition: all 150ms ease;
}
.mod-tile.live:hover .mod-tile-arrow { background: var(--navy); border-color: var(--navy); color: #fff; }

/* ─── TILE STAT BOXES ─────────────────────────────────────── */
.tile-stats {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 7px; margin: 10px 0 6px;
}
.tile-stat {
  padding: 8px 10px; border-radius: 8px;
  background: var(--bg); border: 1px solid var(--border);
  text-align: center; text-decoration: none; display: block;
}
a.tile-stat { cursor: pointer; transition: background 100ms, border-color 100ms; }
a.tile-stat:hover { background: #edf1f6; border-color: var(--border-2); }
.tile-stat-n {
  font-size: 22px; font-weight: 700;
  letter-spacing: -0.04em; line-height: 1;
  font-variant-numeric: tabular-nums; color: var(--text);
}
.tile-stat-lbl { font-size: 10px; color: var(--text-4); margin-top: 2px; line-height: 1.3; }
.tile-stat.amber .tile-stat-n { color: var(--amber); }
.tile-stat.green .tile-stat-n { color: var(--brand-mid); }
.tile-stat.navy  .tile-stat-n { color: var(--navy); }
.tile-stat.red   .tile-stat-n { color: var(--red); }
.tile-stat.muted { opacity: 0.35; }
.tile-stat.muted .tile-stat-n { color: var(--text-4); font-size: 18px; }

/* ─── PAGE HEADING ─────────────────────────────────────────── */
.pg-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 28px; }
.pg-title { font-size: 21px; font-weight: 700; color: var(--text); letter-spacing: -0.03em; line-height: 1.2; }
.pg-sub   { font-size: 13px; color: var(--text-3); margin-top: 4px; }

/* ─── KPI CARDS ─────────────────────────────────────────────── */
.kpi-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 28px; }
.kpi { background: var(--surface); border: 1px solid var(--border); border-top: 2px solid var(--border-2); border-radius: 8px; padding: 20px 22px 18px; box-shadow: var(--stripe-shadow-sm); transition: transform 200ms ease-out, box-shadow 200ms ease-out; }
.kpi:hover { transform: translateY(-2px); box-shadow: var(--stripe-shadow); }
.kpi.accent-gold  { border-top-color: var(--gold); }
.kpi.accent-brand { border-top-color: var(--brand); }
.kpi.accent-red   { border-top-color: var(--red); }
.kpi.accent-navy  { border-top-color: var(--navy); }
.kpi-lbl { font-size: 10.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-4); margin-bottom: 14px; }
.kpi-val { font-size: 40px; font-weight: 700; letter-spacing: -0.05em; color: var(--text); line-height: 1; margin-bottom: 10px; font-variant-numeric: tabular-nums; }
.kpi-val.v-gold  { color: var(--amber); }
.kpi-val.v-brand { color: var(--brand); }
.kpi-val.v-red   { color: var(--red); }
.kpi-val.v-navy  { color: var(--navy); }
.kpi-foot { font-size: 11.5px; color: var(--text-4); display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.kpi-foot strong { color: var(--text-3); font-weight: 500; }
.kpi-trend { font-size: 11px; display: flex; align-items: center; gap: 3px; }
.trend-up  { color: var(--brand); }
.trend-neu { color: var(--text-4); }

/* ─── CARDS ─────────────────────────────────────────────────── */
.card { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; margin-bottom: 20px; box-shadow: var(--stripe-shadow-sm); }
.card-head { display: flex; align-items: center; padding: 15px 20px; border-bottom: 1px solid var(--border); gap: 10px; }
.card-title { font-size: 13.5px; font-weight: 600; color: var(--text); letter-spacing: -0.01em; flex: 1; }
.card-meta  { font-size: 12px; color: var(--text-4); }
.card-link { font-size: 12.5px; font-weight: 500; color: var(--navy); text-decoration: none; display: flex; align-items: center; gap: 3px; transition: color .1s; }
.card-link:hover { color: var(--navy-2); }
.card-hover { transition: transform 200ms ease-out, box-shadow 200ms ease-out; }
.card-hover:hover { transform: translateY(-3px); box-shadow: var(--stripe-shadow); }

/* ─── TABLE ──────────────────────────────────────────────────── */
.tbl { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.tbl th { font-size: 10.5px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-4); padding: 10px 16px; border-bottom: 1px solid var(--border); text-align: left; background: var(--surface-2); white-space: nowrap; }
.tbl td { padding: 13px 16px; border-bottom: 1px solid var(--border); color: var(--text-2); vertical-align: middle; }
.tbl tr:last-child td { border-bottom: none; }
.tbl tbody tr { transition: background .08s; }
.tbl tbody tr:hover td { background: #fafbfc; }
.app-chip { font-family: var(--mono); font-size: 11px; background: var(--bg); border: 1px solid var(--border); color: var(--text-3); padding: 2px 8px; border-radius: 5px; letter-spacing: 0.03em; white-space: nowrap; display: inline-block; }
.prod-name { font-size: 13.5px; font-weight: 500; color: var(--text); line-height: 1.3; }
.prod-ing  { font-size: 11.5px; color: var(--text-4); margin-top: 1px; }

/* ─── STATUS PILLS ───────────────────────────────────────────── */
.st { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 500; padding: 3px 9px 3px 7px; border-radius: 6px; white-space: nowrap; line-height: 1.4; }
.st::before { content:''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.st-ok  { background: var(--brand-light); color: var(--brand); } .st-ok::before  { background: var(--brand-mid); box-shadow: 0 0 0 2px rgba(22,163,74,.2); }
.st-rev { background: var(--amber-bg);   color: var(--amber); } .st-rev::before { background: var(--amber); }
.st-rej { background: var(--red-bg);     color: var(--red);   } .st-rej::before { background: var(--red); }
.st-sub { background: var(--blue-bg);    color: var(--blue);  } .st-sub::before { background: var(--blue); }
.st-drf { background: var(--bg); color: var(--text-3); border: 1px solid var(--border); } .st-drf::before { background: var(--border-2); }
.st-nds { background: var(--orange-bg);  color: var(--orange); } .st-nds::before { background: var(--orange); }
.st-tec { background: var(--purple-bg);  color: var(--purple); } .st-tec::before { background: #8b5cf6; }
.st-lbl { background: var(--teal-bg);    color: var(--teal);  } .st-lbl::before { background: #06b6d4; }
.st-dec { background: #fff7ed; color: #c2410c; } .st-dec::before { background: var(--orange); }

/* ─── BUTTONS ─────────────────────────────────────────────────── */
.btn-navy { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--navy); color: #fff; font-family: var(--font); font-size: 13px; font-weight: 500; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; transition: background 150ms ease, transform 150ms ease; white-space: nowrap; }
.btn-navy:hover { background: var(--navy-2); transform: translateY(-1px); }
.btn-navy:active { transform: translateY(0); }
.btn-ghost { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; background: transparent; color: var(--text-2); font-family: var(--font); font-size: 13px; font-weight: 400; border: 1px solid var(--border); border-radius: 4px; cursor: pointer; text-decoration: none; transition: border-color 150ms ease, background 150ms ease; }
.btn-ghost:hover { border-color: var(--border-2); background: var(--surface-2); }
.tbl-action { font-size: 12px; font-weight: 500; color: var(--navy); text-decoration: none; padding: 4px 10px; border: 1px solid #dde3ec; border-radius: 4px; background: var(--bg); display: inline-block; transition: all .1s; white-space: nowrap; }
.tbl-action:hover { background: #e8edf4; border-color: #c0ccd8; }

/* ─── REVIEW ACTIONS ──────────────────────────────────────────── */
.action-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; font-family: var(--font); font-size: 13px; font-weight: 500; border-radius: 4px; cursor: pointer; text-decoration: none; border: none; transition: background 150ms ease, transform 150ms ease; }
.action-btn:hover { transform: translateY(-1px); }
.action-pass   { background: var(--brand); color: #fff; } .action-pass:hover   { background: #004d28; }
.action-fail   { background: var(--amber-bg); color: var(--amber); border: 1px solid #fde68a; } .action-fail:hover   { background: #fef3c7; }
.action-final  { background: var(--navy); color: #fff; } .action-final:hover  { background: var(--navy-2); }
.action-reject { background: var(--red-bg); color: var(--red); border: 1px solid #fecaca; } .action-reject:hover { background: #fee2e2; }

/* ─── FORMS ──────────────────────────────────────────────────── */
.form-label { display: block; font-size: 12px; font-weight: 600; color: var(--text); margin-bottom: 6px; letter-spacing: 0.2px; }
.form-input, .form-select, .form-textarea { width: 100%; border: 1px solid var(--border); border-radius: 6px; padding: 10px 14px; font-family: var(--font); font-size: 13.5px; color: var(--text); background: #fff; outline: none; transition: border-color 150ms ease, box-shadow 150ms ease; }
.form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(6,27,49,.08); }
.form-input::placeholder, .form-textarea::placeholder { color: var(--text-4); }
.form-textarea { resize: vertical; min-height: 90px; line-height: 1.5; }

/* ─── MISC ─────────────────────────────────────────────────── */
.empty { padding: 56px 24px; text-align: center; display: flex; flex-direction: column; align-items: center; }
.empty-icon  { width: 44px; height: 44px; background: var(--bg); border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; color: var(--text-4); }
.empty-title { font-size: 14px; font-weight: 600; color: var(--text-2); margin-bottom: 5px; }
.empty-sub   { font-size: 13px; color: var(--text-4); margin-bottom: 18px; max-width: 280px; }
.eyebrow     { font-size: 10.5px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-4); }
.pagination  { display: flex; align-items: center; gap: 4px; padding: 14px 20px; border-top: 1px solid var(--border); }
.stripe-shadow    { box-shadow: var(--stripe-shadow); }
.stripe-shadow-sm { box-shadow: var(--stripe-shadow-sm); }
::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
    </style>
    @livewireStyles
</head>

<body x-data="{ profileOpen: false }">

@php
/* Compute module context for the module bar */
$moduleCtx = null;
if (request()->routeIs('officer.applications.*')) {
    $moduleCtx = ['code' => 'e-Cert', 'name' => 'Pendaftaran Produk'];
} elseif (request()->routeIs(['officer.pemeriksaan.*', 'officer.premis.*'])) {
    $moduleCtx = ['code' => 'e-Periksa', 'name' => 'Pemeriksaan'];
} elseif (request()->routeIs(['officer.companies.*', 'officer.products.*', 'officer.users.*', 'officer.audit.*', 'officer.profile'])) {
    $moduleCtx = ['code' => 'Admin', 'name' => 'Pentadbiran & Pengurusan'];
}
@endphp

{{-- ═══ TOPBAR ═══ --}}
<header class="topbar">
    <a href="{{ route('officer.dashboard') }}" class="topbar-logo">
        <img src="/images/jata-malaysia.png" alt="Jata Negara Malaysia">
        <div>
            <div class="topbar-agency-name">Jabatan Pertanian Malaysia</div>
            <div class="topbar-agency-sys">Sistem Bersepadu Racun Makhluk Perosak</div>
        </div>
        <div style="width:1px;height:32px;background:var(--border);margin:0 10px;flex-shrink:0;"></div>
        <img src="/images/mylrmp-logo.png" alt="myLRMP" style="height:32px;width:auto;flex-shrink:0;">
    </a>

    <div class="topbar-right">
        <a href="#" class="notif-btn" title="Notifikasi">
            <div class="notif-dot"></div>
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
            </svg>
        </a>
        <div class="officer-badge">
            <div class="officer-dot"></div>
            {{ auth()->user()?->roles->first()?->name ?? 'Pegawai' }}
        </div>
        <div class="prof-wrap">
            <button class="prof-btn" @click="profileOpen = !profileOpen">
                {{ strtoupper(substr(auth()->user()?->name ?? 'P', 0, 2)) }}
            </button>
            <div class="prof-pop" x-show="profileOpen" @click.outside="profileOpen = false" x-cloak>
                <div class="prof-meta">
                    <div class="prof-meta-name">{{ auth()->user()?->name }}</div>
                    <div class="prof-meta-role">{{ auth()->user()?->roles->first()?->name ?? 'Pegawai' }}</div>
                </div>
                <a href="{{ route('officer.profile') }}" class="prof-item">
                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                    Profil Saya
                </a>
                <div class="prof-sep"></div>
                <form method="POST" action="{{ route('officer.logout') }}" style="margin:0">
                    @csrf
                    <button type="submit" class="prof-item danger">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/></svg>
                        Log Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

{{-- ═══ MODULE CONTEXT BAR ═══ --}}
@if($moduleCtx)
<div class="module-bar">
    <div class="module-bar-top">
        <a href="{{ route('officer.dashboard') }}" class="module-bar-back">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.5 3L5 8l5.5 5"/>
            </svg>
            Semua Modul
        </a>
        <div class="module-bar-vsep"></div>
        <span class="module-bar-name">{{ $moduleCtx['name'] }}</span>
        <span class="module-bar-code">{{ $moduleCtx['code'] }}</span>
    </div>

    <div class="module-bar-tabs">
        @if($moduleCtx['code'] === 'e-Cert')
            <a href="{{ route('officer.applications.index') }}" class="mod-tab {{ request()->routeIs('officer.applications.*') ? 'active' : '' }}">Peti Masuk</a>
            <span class="mod-tab disabled" tabindex="-1" data-tip="Belum tersedia dalam prototaip ini">Pindaan Borang A</span>
            <span class="mod-tab disabled" tabindex="-1" data-tip="Belum tersedia dalam prototaip ini">Pendaftaran Perawis</span>
            <span class="mod-tab disabled" tabindex="-1" data-tip="Belum tersedia dalam prototaip ini">Pelabelan Produk</span>
        @elseif($moduleCtx['code'] === 'e-Periksa')
            <a href="{{ route('officer.pemeriksaan.index') }}" class="mod-tab {{ request()->routeIs('officer.pemeriksaan.*') ? 'active' : '' }}">Senarai Pemeriksaan</a>
            <a href="{{ route('officer.premis.index') }}" class="mod-tab {{ request()->routeIs('officer.premis.*') ? 'active' : '' }}">Premis</a>
            @can('inspections.schedule')
            <a href="{{ route('officer.pemeriksaan.create') }}" class="mod-tab {{ request()->routeIs('officer.pemeriksaan.create') ? 'active' : '' }}">+ Jadual Baharu</a>
            @endcan
        @elseif($moduleCtx['code'] === 'Admin')
            <a href="{{ route('officer.companies.index') }}" class="mod-tab {{ request()->routeIs('officer.companies.*') ? 'active' : '' }}">Syarikat</a>
            <a href="{{ route('officer.products.index') }}" class="mod-tab {{ request()->routeIs('officer.products.*') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('officer.users.index') }}" class="mod-tab {{ request()->routeIs('officer.users.*') ? 'active' : '' }}">Pengguna & ACL</a>
            <a href="{{ route('officer.audit.index') }}" class="mod-tab {{ request()->routeIs('officer.audit.*') ? 'active' : '' }}">Log Audit</a>
            <a href="{{ route('officer.profile') }}" class="mod-tab {{ request()->routeIs('officer.profile') ? 'active' : '' }}">Profil Saya</a>
            <span class="mod-tab disabled" tabindex="-1" data-tip="Belum tersedia dalam prototaip ini">Kawalan Akses</span>
        @endif
    </div>
</div>
@endif

{{-- ═══ MAIN CONTENT ═══ --}}
<main class="main-content {{ request()->routeIs('officer.dashboard') ? 'flush' : '' }}">
    @if(request()->routeIs('officer.applications.show'))
        <a class="page-back" href="{{ route('officer.applications.index') }}">
            <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 3L5 8l5.5 5"/></svg>
            Kembali ke Peti Masuk
        </a>
    @endif
    {{ $slot }}
</main>

@livewireScripts
</body>
</html>
