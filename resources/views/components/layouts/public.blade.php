<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'myLRMP' }} | Jabatan Pertanian Malaysia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        :root {
            --navy:      #061B31;
            --slate:     #64748D;
            --border:    #E5EDF5;
            --off-white: #F8FAFC;
            --brand:     #006837;
            --brand-dark:#004d28;
            --gold:      #FFCC00;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; -webkit-font-smoothing: antialiased; background: var(--off-white); color: var(--navy); zoom: 1.07; }

        /* Nav */
        .nav-link { font-size: 14px; font-weight: 400; color: var(--navy); transition: color 0.15s; text-decoration: none; }
        .nav-link:hover { color: var(--brand); }
        .nav-link.active { color: var(--brand); font-weight: 500; }
        .nav-link.is-disabled {
            opacity: 0.40; cursor: not-allowed; pointer-events: auto;
            position: relative; display: inline-block;
        }
        .nav-link.is-disabled:hover { color: var(--navy); opacity: 0.55; }
        .nav-link.is-disabled[data-tip]::after {
            content: attr(data-tip);
            position: absolute;
            left: 50%; top: calc(100% + 10px);
            transform: translateX(-50%);
            background: #0F172A; color: #fff;
            font-size: 11px; font-weight: 500;
            padding: 5px 10px; border-radius: 6px;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            opacity: 0; pointer-events: none;
            transition: opacity 150ms ease;
            z-index: 100;
        }
        .nav-link.is-disabled[data-tip]:hover::after { opacity: 1; }

        /* Buttons */
        .btn-primary { background: var(--brand); color: #fff; border-radius: 4px; padding: 11px 22px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; transition: background 150ms ease, transform 150ms ease; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary:hover { background: var(--brand-dark); transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-secondary { background: transparent; color: var(--navy); border: 1px solid var(--border); border-radius: 4px; padding: 11px 22px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 400; transition: border-color 150ms ease, color 150ms ease, transform 150ms ease; text-decoration: none; display: inline-block; cursor: pointer; }
        .btn-secondary:hover { border-color: #c0ccd8; color: var(--brand); transform: translateY(-1px); }

        /* Portal access floating widget — fixed below sticky nav, right-aligned */
        .portal-float {
            position: fixed;
            top: 64px; /* height of sticky nav */
            right: 0;
            display: flex; flex-direction: column; gap: 0;
            z-index: 400;
            overflow: hidden;
            border-radius: 0 0 0 10px;
            box-shadow: rgba(0,0,0,0.18) 0px 8px 24px -4px;
        }
        .portal-float-btn {
            display: flex; align-items: center; gap: 9px;
            padding: 11px 18px;
            font-family: 'Poppins', sans-serif; font-size: 12.5px; font-weight: 500;
            text-decoration: none; cursor: pointer; border: none;
            transition: filter 120ms ease;
            white-space: nowrap;
        }
        .portal-float-btn:hover { filter: brightness(1.12); }
        .portal-float-btn.pegawai { background: var(--navy); color: #fff; border-bottom: 1px solid rgba(255,255,255,0.10); }
        .portal-float-btn.industri { background: var(--brand); color: #fff; }
        .portal-float-icon {
            width: 20px; height: 20px; border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.15); flex-shrink: 0;
        }

        /* Cards */
        .feature-card { background: #fff; border: 1px solid var(--border); border-radius: 8px; transition: transform 200ms ease-out, box-shadow 200ms ease-out; }
        .feature-card:hover { transform: translateY(-3px); box-shadow: rgba(50,50,93,0.25) 0px 13px 27px -5px, rgba(0,0,0,0.10) 0px 8px 16px -8px; }
        .stat-card { background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.25); border-radius: 8px; padding: 20px 24px; }

        /* Hero section */
        .hero-section { position: relative; overflow: hidden; background: linear-gradient(135deg, #006837 0%, #004d28 60%, #003d20 100%); }
        .hero-section::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none; z-index: 0;
        }
        .hero-content { position: relative; z-index: 1; }
        .hero-orb { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
        .hero-orb-1 { width: 480px; height: 480px; background: #00c060; opacity: 0.13; top: -140px; left: -120px; animation: orb-drift 14s ease-in-out infinite; }
        .hero-orb-2 { width: 360px; height: 360px; background: #FFCC00; opacity: 0.07; bottom: -80px; right: 8%; animation: orb-drift 11s ease-in-out infinite reverse; }
        .hero-orb-3 { width: 240px; height: 240px; background: #86efac; opacity: 0.10; top: 25%; right: -60px; animation: orb-drift 16s ease-in-out infinite 3s; }
        @keyframes orb-drift {
            0%,  100% { transform: translate(0px,   0px)  scale(1);    }
            33%        { transform: translate(30px, -25px) scale(1.06); }
            66%        { transform: translate(-20px, 18px) scale(0.94); }
        }

        /* Pautan Berguna links */
        .pautan-link { display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: white; border: 1px solid var(--border); border-radius: 10px; font-size: 13px; font-weight: 500; color: #374151; text-decoration: none; transition: border-color 200ms ease, color 200ms ease, transform 200ms ease, box-shadow 200ms ease; }
        .pautan-link:hover { border-color: var(--brand); color: var(--brand); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,104,55,0.12); }
        .pautan-link img { width: 20px; height: 20px; border-radius: 4px; object-fit: contain; flex-shrink: 0; }
        .pautan-link .ext-icon { width: 12px; height: 12px; flex-shrink: 0; margin-left: auto; opacity: 0.4; transition: opacity 200ms ease; }
        .pautan-link:hover .ext-icon { opacity: 0.8; }

        /* Typography */
        .eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--brand); }
        .section-heading { font-size: 32px; font-weight: 700; color: var(--navy); letter-spacing: -0.3px; }
        .section-subheading { font-size: 17px; font-weight: 400; color: var(--slate); margin-top: 10px; }

        /* Status badges */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 4px; font-size: 12px; font-weight: 500; }
        .badge-success { background: #f0fdf4; color: #15803d; }
        .badge-warning { background: #fffbeb; color: #a16207; }
        .badge-danger  { background: #fef2f2; color: #b91c1c; }
        .badge-info    { background: #eff6ff; color: #1d4ed8; }
        .badge-gray    { background: var(--off-white); color: var(--slate); border: 1px solid var(--border); }

        /* Search */
        .search-input { background: #fff; border: 1px solid var(--border); border-radius: 6px; padding: 13px 18px; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 400; color: var(--navy); width: 100%; transition: border-color 150ms ease, box-shadow 150ms ease; }
        .search-input:focus { outline: none; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(0,104,55,0.12); }
        .search-input::placeholder { color: #9aabbc; }

        /* Lang toggle */
        .lang-toggle { display: inline-flex; align-items: center; background: #fff; border: 1px solid var(--border); border-radius: 6px; padding: 2px; gap: 0; }
        .lang-btn { background: transparent; border: none; cursor: pointer; padding: 5px 10px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; color: var(--slate); border-radius: 4px; transition: background 150ms ease, color 150ms ease; }
        .lang-btn:hover { color: var(--navy); }
        .lang-btn.active { background: var(--navy); color: #fff; }

        /* Stripe shadow */
        .stripe-shadow    { box-shadow: rgba(50,50,93,0.25) 0px 13px 27px -5px, rgba(0,0,0,0.10) 0px 8px 16px -8px; }
        .stripe-shadow-sm { box-shadow: rgba(50,50,93,0.15) 0px 8px 18px -6px, rgba(0,0,0,0.06) 0px 4px 10px -4px; }

        input, select, textarea { font-family: 'Poppins', sans-serif; }
    </style>
    @livewireStyles
</head>
<body>

{{-- Gov strip --}}
<div style="height: 3px; background: #006837; width: 100%;"></div>

{{-- Gov bar --}}
<div style="background: #fff; border-bottom: 1px solid var(--border);">
    <div style="max-width: 1280px; margin: 0 auto; padding: 7px 24px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="/images/jata-malaysia.png" alt="Jata Malaysia" style="height: 40px; width: auto; flex-shrink: 0; border-radius: 3px;">
            <div>
                <p style="font-weight: 600; color: #004d28; font-size: 12px; letter-spacing: 0.06em; text-transform: uppercase; margin: 0;">Jabatan Pertanian Malaysia</p>
                <p style="font-size: 10.5px; color: var(--slate); margin: 0; font-weight: 400;">Kementerian Pertanian &amp; Keterjaminan Makanan</p>
            </div>
        </div>
        <div class="lang-toggle">
            <button type="button" class="lang-btn active">BM</button>
            <button type="button" class="lang-btn">EN</button>
        </div>
    </div>
</div>

{{-- Main navigation --}}
<nav style="position: sticky; top: 0; z-index: 50; background: rgba(255,255,255,0.92); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid var(--border);" x-data="{ open: false }">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between; height: 64px;">
            {{-- Brand --}}
            <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 9px; text-decoration: none; flex-shrink: 0;">
                <img src="/images/mylrmp-logo.png" alt="myLRMP" style="height: 36px; width: auto; flex-shrink: 0;">
            </a>

            {{-- Desktop nav links --}}
            <div class="hidden md:flex" style="align-items: center; gap: 28px;">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Laman Utama</a>
                <a href="{{ route('products.search') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Carian Produk</a>
                <a href="{{ route('calculator') }}" class="nav-link {{ request()->routeIs('calculator') ? 'active' : '' }}">Kalkulator</a>
                <span class="nav-link is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">Direktori BKRPB</span>
                <span class="nav-link is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">Harga Pasaran</span>
                <span class="nav-link is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">Aduan</span>
                <span class="nav-link is-disabled" aria-disabled="true" tabindex="-1" data-tip="Modul ini belum tersedia dalam prototaip ini">Bayaran Dalam Talian</span>
                <a href="#hubungi" class="nav-link">Hubungi Kami</a>
            </div>


            {{-- Mobile hamburger --}}
            <button @click="open = !open" style="color: var(--navy); padding: 8px; border-radius: 4px; background: none; border: none; cursor: pointer;" class="md:hidden">
                <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-cloak style="padding-bottom: 16px; border-top: 1px solid var(--border);">
            <a href="{{ route('home') }}" style="display: block; padding: 10px 4px; font-size: 14px; font-weight: 400; color: var(--navy); text-decoration: none; border-bottom: 1px solid var(--border);">Laman Utama</a>
            <a href="{{ route('products.search') }}" style="display: block; padding: 10px 4px; font-size: 14px; font-weight: 400; color: var(--navy); text-decoration: none; border-bottom: 1px solid var(--border);">Carian Produk</a>
            <a href="{{ route('calculator') }}" style="display: block; padding: 10px 4px; font-size: 14px; font-weight: 400; color: var(--navy); text-decoration: none; border-bottom: 1px solid var(--border);">Kalkulator</a>
            <a href="#hubungi" style="display: block; padding: 10px 4px; font-size: 14px; font-weight: 400; color: var(--navy); text-decoration: none; border-bottom: 1px solid var(--border);">Hubungi Kami</a>
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

{{-- ═══ FLOATING PORTAL ACCESS ═══ --}}
<div class="portal-float">
    <a href="{{ route('officer.login') }}" class="portal-float-btn pegawai">
        <span class="portal-float-icon">
            <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
        </span>
        Portal Pegawai
    </a>
    <a href="{{ route('industri.login') }}" class="portal-float-btn industri">
        <span class="portal-float-icon">
            <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
            </svg>
        </span>
        Log Masuk Industri
    </a>
</div>

@livewireScripts
</body>
</html>
