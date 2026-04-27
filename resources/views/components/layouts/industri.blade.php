<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'myLRMP' }} — Portal Industri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
      :root {
        --brand:       #006837;
        --brand-light: #e8f5ee;
        --brand-mid:   #2e7d52;
        --teal:        #2dd4bf;
        --teal-light:  #e0faf7;
        --gold:        #f59e0b;
        --gold-light:  #fef3c7;
        --red:         #ef4444;
        --red-light:   #fee2e2;
        --blue:        #3b82f6;
        --blue-light:  #dbeafe;
        --purple:      #8b5cf6;

        --page-bg:     #f4f5f7;
        --card-bg:     #ffffff;
        --sidebar-bg:  #ffffff;

        --text-1:      #111827;
        --text-2:      #374151;
        --text-3:      #6b7280;
        --text-4:      #9ca3af;

        --border:      #e5e7eb;
        --border-soft: #f3f4f6;

        --radius-sm:   8px;
        --radius-md:   12px;
        --radius-lg:   16px;

        --shadow-sm:   0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md:   0 4px 12px rgba(0,0,0,0.08), 0 1px 3px rgba(0,0,0,0.04);

        --font:        'Inter', -apple-system, system-ui, sans-serif;
      }

      * { box-sizing: border-box; margin: 0; padding: 0; }
      body {
        font-family: var(--font);
        font-feature-settings: 'cv01', 'ss03';
        background: var(--page-bg);
        color: var(--text-1);
        -webkit-font-smoothing: antialiased;
        display: flex;
        height: 100vh;
        overflow: hidden;
      }

      /* ─── SIDEBAR ─── */
      .sidebar {
        width: 220px;
        min-width: 220px;
        background: var(--sidebar-bg);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        flex-shrink: 0;
      }
      .sidebar-brand {
        padding: 20px 16px 16px;
        border-bottom: 1px solid var(--border-soft);
      }
      .sidebar-brand-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
      }
      .sidebar-brand-icon {
        width: 34px; height: 34px;
        background: var(--brand);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: -0.5px;
        flex-shrink: 0;
      }
      .sidebar-brand-text { font-size: 15px; font-weight: 700; color: var(--text-1); letter-spacing: -0.02em; }
      .sidebar-brand-sub  { font-size: 11px; color: var(--text-4); margin-top: 1px; }

      .sidebar-section {
        padding: 8px 8px 4px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-4);
        margin-top: 8px;
      }
      .nav-item {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 12px;
        border-radius: 8px;
        margin: 1px 6px;
        font-size: 13.5px; font-weight: 500;
        color: var(--text-3);
        text-decoration: none;
        cursor: pointer;
        transition: background 0.12s, color 0.12s;
        user-select: none;
        border: none;
        background: none;
        width: calc(100% - 12px);
        text-align: left;
      }
      .nav-item:hover { background: var(--border-soft); color: var(--text-1); }
      .nav-item.active {
        background: var(--brand-light);
        color: var(--brand);
        font-weight: 600;
        border-left: 3px solid var(--brand);
        padding-left: 9px;
      }
      .nav-icon {
        width: 18px; height: 18px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        opacity: 0.7;
      }
      .nav-item.active .nav-icon { opacity: 1; }
      .nav-badge {
        margin-left: auto;
        background: var(--brand);
        color: #fff;
        font-size: 10px; font-weight: 600;
        padding: 1px 6px;
        border-radius: 9999px;
        min-width: 18px; text-align: center;
      }
      .sidebar-footer {
        margin-top: auto;
        padding: 12px 10px;
        border-top: 1px solid var(--border-soft);
        display: flex; align-items: center; gap: 10px;
        flex-shrink: 0;
      }
      .avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: var(--brand);
        color: #fff;
        font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
      }
      .avatar-name  { font-size: 13px; font-weight: 600; color: var(--text-1); }
      .avatar-role  { font-size: 11px; color: var(--text-4); }
      .logout-btn {
        margin-left: auto;
        color: var(--text-4);
        cursor: pointer;
        transition: color 0.12s;
        background: none; border: none; padding: 0;
        display: flex; align-items: center;
      }
      .logout-btn:hover { color: var(--red); }

      /* ─── MAIN SHELL ─── */
      .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        min-width: 0;
      }

      /* ─── TOP BAR ─── */
      .topbar {
        height: 56px; min-height: 56px;
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 0 24px;
        display: flex; align-items: center; gap: 16px;
        flex-shrink: 0;
      }
      .topbar-back {
        display: flex; align-items: center; gap: 6px;
        font-size: 13px; color: var(--text-3);
        cursor: pointer;
        transition: color 0.12s;
        text-decoration: none;
      }
      .topbar-back:hover { color: var(--brand); }
      .topbar-divider { width: 1px; height: 18px; background: var(--border); flex-shrink: 0; }
      .topbar-title {
        font-size: 16px; font-weight: 600;
        color: var(--text-1);
        letter-spacing: -0.02em;
      }
      .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
      .topbar-search {
        display: flex; align-items: center; gap: 8px;
        background: var(--page-bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 13px; color: var(--text-4);
        cursor: pointer;
        width: 180px;
      }
      .topbar-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--brand);
        color: #fff;
        font-size: 13px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
      }
      .user-info { text-align: right; }
      .user-name { font-size: 13px; font-weight: 600; color: var(--text-1); }
      .user-role { font-size: 11px; color: var(--text-4); }

      /* ─── CONTENT AREA ─── */
      .main-scroll {
        flex: 1;
        overflow-y: auto;
        padding: 20px 24px;
        background: var(--page-bg);
      }

      /* ─── KPI CARDS ─── */
      .kpi-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 20px 24px;
        box-shadow: var(--shadow-sm);
      }
      .kpi-label { font-size: 11px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-4); margin-bottom: 8px; }
      .kpi-value { font-size: 32px; font-weight: 700; letter-spacing: -0.03em; color: var(--text-1); }
      .kpi-value.orange { color: #d97706; }
      .kpi-value.green  { color: #15803d; }
      .kpi-value.red    { color: #b91c1c; }

      /* ─── SECTION CARD ─── */
      .section-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 16px;
        box-shadow: var(--shadow-sm);
      }
      .section-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 14px;
      }
      .section-title { font-size: 14px; font-weight: 600; color: var(--text-1); }
      .section-more  { font-size: 12px; color: var(--brand); cursor: pointer; font-weight: 500; text-decoration: none; }
      .section-more:hover { text-decoration: underline; }

      /* ─── DATA TABLE ─── */
      .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
      .data-table th {
        font-size: 11px; font-weight: 600;
        letter-spacing: 0.04em; text-transform: uppercase;
        color: var(--text-4);
        padding: 8px 12px;
        border-bottom: 1px solid var(--border);
        text-align: left;
      }
      .data-table td {
        padding: 10px 12px;
        border-bottom: 1px solid var(--border-soft);
        color: var(--text-2);
      }
      .data-table tr:last-child td { border-bottom: none; }
      .data-table tr:hover td { background: var(--border-soft); }

      /* ─── CHIPS ─── */
      .chip {
        font-size: 10px; font-weight: 600;
        padding: 3px 8px;
        border-radius: 9999px;
        letter-spacing: 0.01em;
        display: inline-flex; align-items: center;
      }
      .chip-brand  { background: var(--brand-light); color: var(--brand); }
      .chip-green  { background: #dcfce7; color: #15803d; }
      .chip-amber  { background: var(--gold-light); color: #92400e; }
      .chip-red    { background: var(--red-light); color: #b91c1c; }
      .chip-blue   { background: var(--blue-light); color: #1d4ed8; }
      .chip-gray   { background: #f3f4f6; color: #6b7280; }
      .chip-teal   { background: var(--teal-light); color: #0d9488; }

      /* ─── BADGE (dashboard table) ─── */
      .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 500; }
      .badge-diluluskan   { background: #dcfce7; color: #15803d; }
      .badge-ditolak      { background: var(--red-light); color: #b91c1c; }
      .badge-dalam-proses { background: var(--gold-light); color: #a16207; }
      .badge-draf         { background: #f3f4f6; color: #6b7280; }
      .badge-dihantar     { background: var(--blue-light); color: #1d4ed8; }
      .badge-semakan      { background: #fff7ed; color: #c2410c; }

      /* scroll */
      ::-webkit-scrollbar { width: 4px; }
      ::-webkit-scrollbar-track { background: transparent; }
      ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

      input, select, textarea { font-family: var(--font); font-feature-settings: 'cv01', 'ss03'; }
    </style>
    @livewireStyles
</head>
<body>

{{-- ═══ SIDEBAR ═══ --}}
<nav class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('industri.dashboard') }}" class="sidebar-brand-logo">
            <div class="sidebar-brand-icon">ML</div>
            <div>
                <div class="sidebar-brand-text">myLRMP</div>
                <div class="sidebar-brand-sub">Jabatan Pertanian</div>
            </div>
        </a>
    </div>

    <div style="flex: 1; padding: 8px 0; overflow-y: auto;">
        <div class="sidebar-section">Utama</div>
        <a href="{{ route('industri.dashboard') }}"
           class="nav-item {{ request()->routeIs('industri.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"/>
                </svg>
            </span>
            <span>Papan Pemuka</span>
        </a>
        <a href="{{ route('industri.applications.index') }}"
           class="nav-item {{ request()->routeIs('industri.applications.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                </svg>
            </span>
            <span>Permohonan</span>
        </a>

        <div class="sidebar-section">Akaun</div>
        <a href="{{ route('industri.profile') }}"
           class="nav-item {{ request()->routeIs('industri.profile') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </span>
            <span>Profil Syarikat</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="avatar" style="font-size:11px">
            {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 2)) }}
        </div>
        <div style="min-width:0;flex:1">
            <div class="avatar-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                {{ auth()->user()?->name }}
            </div>
            <div class="avatar-role">Industri</div>
        </div>
        <form method="POST" action="{{ route('industri.logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="logout-btn" title="Log Keluar">
                <svg viewBox="0 0 20 20" fill="currentColor" width="15" height="15">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                </svg>
            </button>
        </form>
    </div>
</nav>

{{-- ═══ MAIN ═══ --}}
<div class="main">

    {{-- Top bar --}}
    <div class="topbar">
        @if(request()->routeIs('industri.applications.show'))
            <a class="topbar-back" href="{{ route('industri.applications.index') }}">
                <svg viewBox="0 0 16 16" fill="currentColor" width="14" height="14"><path d="M10.5 3L5 8l5.5 5" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kembali
            </a>
            <div class="topbar-divider"></div>
        @endif
        <span class="topbar-title">{{ $title ?? 'Portal Industri' }}</span>

        <div class="topbar-right">
            <div class="topbar-search">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13">
                    <circle cx="6.5" cy="6.5" r="4.5"/><path d="M11 11l3 3" stroke-linecap="round"/>
                </svg>
                Cari sesuatu...
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()?->name }}</div>
                    <div class="user-role">{{ auth()->user()?->company?->name ?? 'Portal Industri' }}</div>
                </div>
                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 2)) }}
                </div>
            </div>
        </div>
    </div>

    {{-- Page content --}}
    <main class="main-scroll">
        {{ $slot }}
    </main>

</div>

@livewireScripts
</body>
</html>
