<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'myLRMP' }} | Jabatan Pertanian Malaysia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    doa: { 50:'#f0fdf4', 100:'#dcfce7', 500:'#006837', 600:'#005a2f', 700:'#004d28', 800:'#003d20', 900:'#002d18' },
                    gold: { 400:'#FFCC00', 500:'#f5c200' }
                }
            }
        }
    }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, system-ui, sans-serif; font-feature-settings: 'cv01', 'ss03'; -webkit-font-smoothing: antialiased; }
        .nav-link { font-size: 14px; font-weight: 500; letter-spacing: -0.01em; color: #4b5563; transition: color 0.15s; }
        .nav-link:hover { color: #111827; }
        .nav-link.active { color: #006837; }
        .hero-gradient { background: linear-gradient(135deg, #006837 0%, #004d28 60%, #003d20 100%); }
        .stat-card { background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; padding: 20px 24px; }
        .feature-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .feature-card:hover { border-color: #006837; box-shadow: 0 4px 16px rgba(0,104,55,0.1); transform: translateY(-2px); }
        .btn-primary { background: #006837; color: white; border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 500; letter-spacing: -0.01em; transition: background 0.15s; border: none; cursor: pointer; }
        .btn-primary:hover { background: #005a2f; }
        .btn-secondary { background: transparent; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 500; transition: all 0.15s; }
        .btn-secondary:hover { border-color: #9ca3af; background: #f9fafb; }
        .badge { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef9c3; color: #a16207; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-info { background: #dbeafe; color: #1d4ed8; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }
        .section-heading { font-size: 32px; font-weight: 700; letter-spacing: -0.03em; color: #111827; }
        .section-subheading { font-size: 18px; font-weight: 400; color: #6b7280; margin-top: 8px; }
        input, select, textarea { font-family: 'Inter', sans-serif; font-feature-settings: 'cv01', 'ss03'; }
        .search-input { background: white; border: 1px solid #d1d5db; border-radius: 10px; padding: 12px 16px; font-size: 15px; font-weight: 400; color: #111827; width: 100%; transition: border-color 0.15s, box-shadow 0.15s; }
        .search-input:focus { outline: none; border-color: #006837; box-shadow: 0 0 0 3px rgba(0,104,55,0.1); }
        .lang-pill { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; transition: all 0.15s; text-decoration: none; }
        .lang-pill.active { background: #f3f4f6; color: #111827; }
        .lang-pill.inactive { color: #6b7280; }
        .lang-pill.inactive:hover { color: #374151; }
    </style>
    @livewireStyles
</head>
<body style="background: #f9fafb;">

{{-- Top gov strip --}}
<div style="height: 3px; background: #006837; width: 100%;"></div>
<div style="background: white; border-bottom: 1px solid #e5e7eb;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 8px 16px; display: flex; align-items: center; justify-content: space-between;">
        {{-- Gov logo + name --}}
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: #006837; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="color: white; font-weight: 800; font-size: 10px; letter-spacing: 0.05em;">JPM</span>
            </div>
            <div style="line-height: 1.3;">
                <p style="font-weight: 600; color: #004d28; font-size: 13px; letter-spacing: 0.03em; text-transform: uppercase; margin: 0;">Jabatan Pertanian Malaysia</p>
                <p style="font-size: 11px; color: #6b7280; margin: 0;">Kementerian Pertanian &amp; Keterjaminan Makanan</p>
            </div>
        </div>
        {{-- Language toggle --}}
        <div style="display: flex; align-items: center; gap: 4px;">
            <a href="#" class="lang-pill active">BM</a>
            <a href="#" class="lang-pill inactive">EN</a>
        </div>
    </div>
</div>

{{-- Main navigation --}}
<nav style="background: white; border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.06);" x-data="{ open: false }">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; height: 56px;">
            {{-- Brand --}}
            <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                <div style="width: 32px; height: 32px; background: #006837; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span style="color: #FFCC00; font-weight: 800; font-size: 11px;">ML</span>
                </div>
                <span style="font-weight: 600; font-size: 18px; letter-spacing: -0.02em; color: #111827;">myLRMP</span>
            </a>

            {{-- Desktop nav links --}}
            <div class="hidden md:flex" style="align-items: center; gap: 4px;">
                <a href="{{ route('home') }}"
                   style="padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.15s; {{ request()->routeIs('home') ? 'color: #006837; background: #f0fdf4;' : 'color: #4b5563;' }}"
                   onmouseover="if(!this.style.background.includes('f0fdf4')) { this.style.background='#f9fafb'; this.style.color='#111827'; }"
                   onmouseout="if(!this.style.background.includes('f0fdf4')) { this.style.background=''; this.style.color='#4b5563'; }">
                    Laman Utama
                </a>
                <a href="{{ route('products.search') }}"
                   style="padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.15s; {{ request()->routeIs('products.*') ? 'color: #006837; background: #f0fdf4;' : 'color: #4b5563;' }}"
                   onmouseover="if(!this.style.background.includes('f0fdf4')) { this.style.background='#f9fafb'; this.style.color='#111827'; }"
                   onmouseout="if(!this.style.background.includes('f0fdf4')) { this.style.background=''; this.style.color='#4b5563'; }">
                    Carian Produk
                </a>
                <a href="{{ route('calculator') }}"
                   style="padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.15s; {{ request()->routeIs('calculator') ? 'color: #006837; background: #f0fdf4;' : 'color: #4b5563;' }}"
                   onmouseover="if(!this.style.background.includes('f0fdf4')) { this.style.background='#f9fafb'; this.style.color='#111827'; }"
                   onmouseout="if(!this.style.background.includes('f0fdf4')) { this.style.background=''; this.style.color='#4b5563'; }">
                    Kalkulator
                </a>
                <a href="#hubungi"
                   style="padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; color: #4b5563; transition: all 0.15s;"
                   onmouseover="this.style.background='#f9fafb'; this.style.color='#111827';"
                   onmouseout="this.style.background=''; this.style.color='#4b5563';">
                    Hubungi Kami
                </a>
                <a href="{{ route('industri.login') }}"
                   style="margin-left: 8px; padding: 7px 16px; border-radius: 8px; background: #006837; color: white; font-size: 14px; font-weight: 500; text-decoration: none; transition: background 0.15s; letter-spacing: -0.01em;"
                   onmouseover="this.style.background='#005a2f';"
                   onmouseout="this.style.background='#006837';">
                    Log Masuk
                </a>
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open" style="color: #374151; padding: 8px; border-radius: 6px; background: none; border: none; cursor: pointer;" class="md:hidden">
                <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-cloak style="padding-bottom: 12px;">
            <a href="{{ route('home') }}" style="display: block; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none; margin-bottom: 2px;">Laman Utama</a>
            <a href="{{ route('products.search') }}" style="display: block; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none; margin-bottom: 2px;">Carian Produk</a>
            <a href="{{ route('calculator') }}" style="display: block; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none; margin-bottom: 2px;">Kalkulator</a>
            <a href="#hubungi" style="display: block; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none; margin-bottom: 2px;">Hubungi Kami</a>
            <a href="{{ route('industri.login') }}" style="display: block; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none;">Log Masuk</a>
        </div>
    </div>
</nav>

{{-- Page content --}}
<main>
    {{ $slot }}
</main>

{{-- Footer --}}
<footer style="background: #003d20; color: #f7f8f8; margin-top: 48px;" id="hubungi">
    <div style="max-width: 1280px; margin: 0 auto; padding: 40px 16px;">
        <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 32px;" class="md:grid-cols-3">
            {{-- Brand --}}
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                    <div style="width: 32px; height: 32px; background: #FFCC00; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #003d20; font-weight: 800; font-size: 11px;">ML</span>
                    </div>
                    <span style="font-weight: 600; font-size: 18px; letter-spacing: -0.02em;">myLRMP</span>
                </div>
                <p style="color: #86efac; font-size: 13px; line-height: 1.6; font-weight: 400; margin: 0;">
                    Sistem Bersepadu Racun Makhluk Perosak (myLRMP)<br>
                    Jabatan Pertanian Malaysia
                </p>
            </div>
            {{-- Links --}}
            <div>
                <h4 style="font-weight: 600; color: #d1fae5; margin-bottom: 12px; font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase;">Pautan</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px;">
                    <li><a href="#" style="color: #86efac; font-size: 13px; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#f7f8f8'" onmouseout="this.style.color='#86efac'">Dasar Privasi</a></li>
                    <li><a href="#" style="color: #86efac; font-size: 13px; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#f7f8f8'" onmouseout="this.style.color='#86efac'">Penafian</a></li>
                    <li><a href="#" style="color: #86efac; font-size: 13px; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#f7f8f8'" onmouseout="this.style.color='#86efac'">Peta Laman</a></li>
                </ul>
            </div>
            {{-- Contact --}}
            <div>
                <h4 style="font-weight: 600; color: #d1fae5; margin-bottom: 12px; font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase;">Hubungi Kami</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px;">
                    <li style="color: #86efac; font-size: 13px;">Bahagian Kawalan Racun Makhluk Perosak</li>
                    <li style="color: #86efac; font-size: 13px;">Jabatan Pertanian Malaysia</li>
                    <li style="color: #86efac; font-size: 13px;">Putrajaya, Malaysia</li>
                </ul>
            </div>
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 32px; padding-top: 24px; text-align: center;">
            <p style="color: #86efac; font-size: 13px; margin: 0 0 4px;">&copy; 2026 Jabatan Pertanian Malaysia. Hak cipta terpelihara.</p>
            <p style="color: #4ade80; font-size: 11px; margin: 0;">Dibangunkan di bawah Akta Racun Makhluk Perosak 1974 (Akta 149)</p>
        </div>
    </div>
</footer>

@livewireScripts
</body>
</html>
