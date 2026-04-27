<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'myLRMP' }} — Portal Industri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#006837',
                            600: '#005a2f',
                            700: '#004d28',
                            800: '#003f20',
                            900: '#052e16',
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, system-ui, sans-serif; font-feature-settings: 'cv01', 'ss03'; -webkit-font-smoothing: antialiased; margin: 0; }
        .sidebar { background: #0f1011; border-right: 1px solid rgba(255,255,255,0.08); color: #f7f8f8; }
        .sidebar-brand { font-size: 18px; font-weight: 600; letter-spacing: -0.02em; color: #f7f8f8; }
        .sidebar-brand-sub { font-size: 12px; font-weight: 400; color: #62666d; margin-top: 2px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; color: #8a8f98; text-decoration: none; transition: all 0.15s; cursor: pointer; border: none; background: none; width: 100%; text-align: left; }
        .nav-item:hover { background: rgba(255,255,255,0.04); color: #d0d6e0; }
        .nav-item.active { background: rgba(255,255,255,0.08); color: #f7f8f8; border-left: 2px solid #5e6ad2; padding-left: 14px; }
        .nav-group-label { font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: #62666d; padding: 16px 16px 6px; }
        .main-content { background: #f7f8f9; min-height: 100vh; }
        .topbar { background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; }
        .page-title { font-size: 20px; font-weight: 600; letter-spacing: -0.02em; color: #111827; }
        .content-area { padding: 24px; }
        .kpi-card { background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px 24px; }
        .kpi-label { font-size: 12px; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: #9ca3af; margin-bottom: 8px; }
        .kpi-value { font-size: 32px; font-weight: 700; letter-spacing: -0.03em; color: #111827; }
        .kpi-value.orange { color: #d97706; }
        .kpi-value.green { color: #15803d; }
        .kpi-value.red { color: #b91c1c; }
        .data-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .data-table th { font-size: 12px; font-weight: 500; letter-spacing: 0.04em; text-transform: uppercase; color: #9ca3af; padding: 10px 16px; text-align: left; border-bottom: 1px solid #f3f4f6; }
        .data-table td { padding: 12px 16px; border-bottom: 1px solid #f9fafb; color: #374151; }
        .data-table tr:hover td { background: #f9fafb; }
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .badge-diluluskan { background: #dcfce7; color: #15803d; }
        .badge-ditolak { background: #fee2e2; color: #b91c1c; }
        .badge-dalam-proses { background: #fef9c3; color: #a16207; }
        .badge-draf { background: #f3f4f6; color: #6b7280; }
        .badge-dihantar { background: #dbeafe; color: #1d4ed8; }
        .badge-semakan { background: #fff7ed; color: #c2410c; }
        input, select, textarea { font-family: 'Inter', sans-serif; font-feature-settings: 'cv01', 'ss03'; }
    </style>
    @livewireStyles
</head>
<body>

<div x-data="{ sidebarOpen: false }" style="display: flex; height: 100vh; overflow: hidden;">

    {{-- Sidebar --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="sidebar fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-200 ease-in-out lg:relative lg:translate-x-0 flex flex-col"
        style="width: 256px; flex-shrink: 0;"
    >
        {{-- Brand --}}
        <div style="display: flex; align-items: center; justify-content: space-between; height: 56px; padding: 0 20px; border-bottom: 1px solid rgba(255,255,255,0.06); flex-shrink: 0;">
            <a href="{{ route('industri.dashboard') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <div style="width: 30px; height: 30px; background: #5e6ad2; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span style="color: white; font-weight: 800; font-size: 11px;">ML</span>
                </div>
                <div>
                    <div class="sidebar-brand">myLRMP</div>
                    <div class="sidebar-brand-sub">Portal Industri</div>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden" style="color: #8a8f98; background: none; border: none; cursor: pointer; padding: 4px;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav style="flex: 1; padding: 12px 8px; overflow-y: auto;">
            <div class="nav-group-label">Menu</div>
            <a href="{{ route('industri.dashboard') }}"
               class="nav-item {{ request()->routeIs('industri.dashboard') ? 'active' : '' }}">
                <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('industri.applications.index') }}"
               class="nav-item {{ request()->routeIs('industri.applications.*') ? 'active' : '' }}">
                <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Permohonan Saya
            </a>

            <a href="{{ route('industri.profile') }}"
               class="nav-item {{ request()->routeIs('industri.profile') ? 'active' : '' }}">
                <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil
            </a>
        </nav>

        {{-- User + Logout at bottom --}}
        <div style="padding: 12px 8px 16px; border-top: 1px solid rgba(255,255,255,0.06); flex-shrink: 0;">
            <div style="padding: 8px 16px; margin-bottom: 4px;">
                <p style="font-size: 13px; font-weight: 500; color: #d0d6e0; margin: 0 0 2px;">{{ auth()->user()?->name }}</p>
                <p style="font-size: 12px; color: #62666d; margin: 0;">{{ auth()->user()?->company?->name ?? 'Tiada Syarikat' }}</p>
            </div>
            <form method="POST" action="{{ route('industri.logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="border-radius: 6px;">
                    <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Log Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" x-cloak></div>

    {{-- Main content --}}
    <div class="main-content" style="flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden;">

        {{-- Top bar --}}
        <header class="topbar" style="flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <button @click="sidebarOpen = true" class="lg:hidden" style="color: #6b7280; background: none; border: none; cursor: pointer; padding: 4px;">
                    <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="page-title">{{ $title ?? 'Portal Industri' }}</h1>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="text-align: right;" class="hidden sm:block">
                    <p style="font-size: 14px; font-weight: 500; color: #111827; margin: 0;">{{ auth()->user()?->name }}</p>
                    <p style="font-size: 12px; color: #6b7280; margin: 0;">{{ auth()->user()?->company?->name ?? 'Tiada Syarikat' }}</p>
                </div>
                <div style="width: 36px; height: 36px; border-radius: 50%; background: #5e6ad2; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; flex-shrink: 0;">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main style="flex: 1; overflow-y: auto;">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer style="background: white; border-top: 1px solid #e5e7eb; padding: 10px 24px; flex-shrink: 0;">
            <p style="font-size: 12px; color: #9ca3af; text-align: center; margin: 0;">myLRMP &copy; Jabatan Pertanian Malaysia</p>
        </footer>
    </div>
</div>

@livewireScripts
</body>
</html>
