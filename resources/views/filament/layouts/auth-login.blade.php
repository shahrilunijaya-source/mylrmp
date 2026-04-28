@php $livewire ??= null; @endphp
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk — Portal Pegawai myLRMP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @livewireStyles
    @filamentStyles
    <style>
        /* ── EXACT same tokens as industri login, navy accent ── */
        :root {
            --accent:      #061B31;
            --accent-dark: #030f1c;
            --accent-bg:   #f0f4f9;
            --accent-mid:  #1e3a5f;
            --navy:        #061B31;
            --slate:       #64748D;
            --border:      #E5EDF5;
            --off-white:   #F8FAFC;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Poppins', sans-serif; -webkit-font-smoothing: antialiased; color: var(--navy); }

        /* ── Split layout ── */
        .split { display: flex; min-height: 100vh; }

        /* ── Left panel: dark navy (internal) ── */
        .panel-left {
            position: relative;
            flex: 0 0 42%;
            background: linear-gradient(155deg, #030f1c 0%, #061B31 45%, #0a2240 100%);
            display: flex; flex-direction: column; justify-content: center;
            padding: 3rem 2.75rem; overflow: hidden;
        }
        .deco { position: absolute; border-radius: 50%; opacity: .09; pointer-events: none; }
        .deco-1 { width: 420px; height: 420px; background: #fff; top: -120px; right: -140px; }
        .deco-2 { width: 260px; height: 260px; background: #fff; bottom: 60px; left: -80px; }
        .deco-3 { width: 140px; height: 140px; background: #93c5fd; bottom: 180px; right: 40px; opacity: .14; }
        .deco-4 { width: 60px;  height: 60px;  background: #bfdbfe; top: 200px; left: 30px; opacity: .18; }
        .dot-grid {
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, rgba(255,255,255,.11) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .left-inner { position: relative; z-index: 1; }
        .left-brand { display: inline-flex; align-items: center; gap: .625rem; margin-bottom: 1.75rem; }
        .left-brand-ring {
            width: 44px; height: 44px;
            background: rgba(255,255,255,.14); border: 2px solid rgba(255,255,255,.22);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: .8rem; letter-spacing: .04em; color: white;
        }
        .left-brand-name { color: white; font-size: 1.25rem; font-weight: 800; }
        .internal-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15);
            border-radius: 4px; padding: 5px 10px; margin-bottom: 1.5rem;
            font-size: .6875rem; font-weight: 600; letter-spacing: .06em;
            text-transform: uppercase; color: rgba(255,255,255,.70);
        }
        .internal-dot { width: 6px; height: 6px; background: #FFCC00; border-radius: 50%; flex-shrink: 0; }
        .left-title { color: white; font-size: 1.875rem; font-weight: 800; line-height: 1.25; letter-spacing: -.02em; margin-bottom: 1rem; }
        .left-desc { color: rgba(255,255,255,.60); font-size: .9375rem; line-height: 1.6; margin-bottom: 2.5rem; max-width: 280px; }
        .features { display: flex; flex-direction: column; gap: .75rem; }
        .feature { display: flex; align-items: center; gap: .75rem; color: rgba(255,255,255,.78); font-size: .875rem; }
        .feature-dot { width: 8px; height: 8px; background: #FFCC00; border-radius: 50%; flex-shrink: 0; }
        .left-footer { position: absolute; bottom: 1.5rem; left: 2.75rem; right: 2.75rem; z-index: 1; font-size: .75rem; color: rgba(255,255,255,.30); }

        /* ── Right panel: EXACT same as industri ── */
        .panel-right {
            flex: 1; background: #f3f6fb;
            display: flex; flex-direction: column; align-items: center;
            padding: 28px 16px 48px; overflow-y: auto;
        }

        /* Subtle mesh bg — industri uses green tint, we use navy tint */
        .panel-right::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 10% 20%, rgba(6,27,49,.06) 0%, transparent 55%),
                radial-gradient(ellipse 50% 50% at 90% 80%, rgba(30,58,95,.05) 0%, transparent 50%);
            pointer-events: none; z-index: 0;
        }
        .right-inner {
            position: relative; z-index: 1;
            width: 100%; max-width: 440px;
            display: flex; flex-direction: column; align-items: stretch; flex: 1;
        }

        /* Back link — EXACT copy from industri */
        .back-link {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 13px; color: var(--slate);
            text-decoration: none; margin-bottom: 24px; transition: color .15s;
        }
        .back-link:hover { color: var(--accent); }
        .back-link svg { transition: transform .15s; }
        .back-link:hover svg { transform: translateX(-2px); }

        /* Card — EXACT copy from industri */
        .card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: rgba(50,50,93,0.12) 0px 10px 30px -8px, rgba(0,0,0,0.06) 0px 4px 12px -4px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        /* Navy top bar instead of green */
        .card-top { height: 3px; background: linear-gradient(90deg, var(--accent) 0%, var(--accent-mid) 100%); }
        .card-body { padding: 32px 32px 28px; }

        /* Logo — EXACT copy from industri */
        .logo-row { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .logo-mark {
            width: 38px; height: 38px; background: var(--navy);
            border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .logo-mark span { color: #FFCC00; font-weight: 800; font-size: 13px; letter-spacing: -0.5px; }
        .logo-text { font-size: 17px; font-weight: 700; color: var(--navy); letter-spacing: -0.3px; }
        .logo-sub  { font-size: 11px; color: var(--slate); margin-top: 1px; }

        .card-title { font-size: 19px; font-weight: 600; color: var(--navy); margin-bottom: 6px; letter-spacing: -0.3px; }
        .card-sub   { font-size: 13px; color: var(--slate); margin-bottom: 24px; }

        .gov-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--accent-bg); border: 1px solid #dde3ec; border-radius: 6px;
            padding: 8px 12px; margin-bottom: 20px; font-size: 11.5px; color: var(--slate);
        }
        .gov-badge-dot { width: 7px; height: 7px; background: #006837; border-radius: 50%; flex-shrink: 0; }

        /* ── Error box ── */
        .error-box {
            background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px;
            padding: 10px 14px; margin-bottom: 16px; font-size: 13px; color: #b91c1c;
        }

        /* ── Form fields — EXACT copy from industri login ── */
        .field { margin-bottom: 16px; }
        .field label {
            display: block; font-size: 12px; font-weight: 500;
            color: var(--navy); margin-bottom: 6px; letter-spacing: 0.2px;
        }
        .field-wrap { position: relative; }
        .field-wrap input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 10px 38px 10px 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            color: var(--navy);
            background: #fff;
            outline: none;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }
        .field-wrap input::placeholder { color: #9aabbc; }
        .field-wrap input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(6,27,49,.12);
        }
        .field-icon {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            color: #9aabbc; pointer-events: none;
        }

        /* ── Remember / forgot row ── */
        .remember-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }
        .remember-label {
            display: flex; align-items: center; gap: 7px;
            font-size: 13px; color: var(--slate); cursor: pointer;
        }
        .remember-label input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--accent); cursor: pointer; }
        .forgot-link { font-size: 13px; color: var(--accent); text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }

        /* ── Submit button — EXACT copy from industri ── */
        .submit-btn {
            width: 100%; padding: 11px;
            background: var(--accent); color: #fff;
            font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
            border: none; border-radius: 4px; cursor: pointer;
            transition: background 150ms ease, transform 150ms ease;
        }
        .submit-btn:hover { background: var(--accent-dark); transform: translateY(-1px); }
        .submit-btn:active { transform: translateY(0); }
        .submit-btn:disabled { opacity: .75; cursor: not-allowed; transform: none; }

        /* Demo link */
        .demo-link-wrap { text-align: center; margin-bottom: 20px; }
        .demo-link {
            background: none; border: none; cursor: pointer;
            font-family: 'Poppins', sans-serif; font-size: 12.5px; color: var(--slate);
            text-decoration: underline; text-underline-offset: 3px; transition: color .15s; padding: 0;
        }
        .demo-link:hover { color: var(--navy); }
        .page-footer { text-align: center; font-size: 12px; color: #9aabbc; margin-top: auto; padding-top: 16px; }

        /* ── Demo modal ── */
        .modal-backdrop {
            position: fixed; inset: 0; background: rgba(6,27,49,.55);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999; opacity: 0; pointer-events: none; transition: opacity 200ms ease;
        }
        .modal-backdrop.open { opacity: 1; pointer-events: auto; }
        .modal {
            background: #fff; border-radius: 10px; width: 92vw; max-width: 600px; max-height: 85vh;
            overflow: hidden; display: flex; flex-direction: column;
            box-shadow: rgba(6,27,49,.28) 0px 24px 64px -8px;
            transform: scale(0.95) translateY(12px); transition: transform 200ms ease;
        }
        .modal-backdrop.open .modal { transform: scale(1) translateY(0); }
        .modal-head { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: var(--navy); flex-shrink: 0; }
        .modal-title { font-size: 14px; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 8px; }
        .modal-badge { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 9999px; background: rgba(255,255,255,.15); color: #fff; }
        .modal-close { width: 28px; height: 28px; border-radius: 6px; border: none; background: rgba(255,255,255,.12); color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 15px; transition: background .15s; }
        .modal-close:hover { background: rgba(255,255,255,.22); }
        .modal-body { overflow-y: auto; }
        .demo-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .demo-table th { padding: 8px 16px; font-size: 10px; font-weight: 700; color: #9aabbc; text-transform: uppercase; letter-spacing: .06em; background: #f9fafb; border-bottom: 1px solid var(--border); text-align: left; position: sticky; top: 0; }
        .demo-table td { padding: 10px 16px; border-bottom: 1px solid #f3f4f6; color: var(--navy); vertical-align: middle; }
        .demo-table tr:last-child td { border-bottom: none; }
        .demo-table tr.demo-row { cursor: pointer; }
        .demo-table tr.demo-row:hover td { background: var(--accent-bg); }
        .demo-group td { background: #f9fafb; padding: 6px 16px; font-size: 10px; font-weight: 700; color: #9aabbc; text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid var(--border); }
        .role-pill { display: inline-block; font-size: 10.5px; font-weight: 500; padding: 2px 8px; border-radius: 4px; white-space: nowrap; }
        .pill-admin   { background: #fef2f2; color: #b91c1c; }
        .pill-officer { background: var(--accent-bg); color: var(--navy); }
        .demo-pw { font-family: 'SF Mono', ui-monospace, monospace; font-size: 11.5px; background: #f3f4f6; padding: 2px 7px; border-radius: 4px; color: var(--navy); white-space: nowrap; }
        .modal-foot { padding: 12px 16px; background: #f9fafb; border-top: 1px solid var(--border); font-size: 12px; color: var(--slate); text-align: center; flex-shrink: 0; }

        /* ── Mobile ── */
        @media (max-width: 768px) {
            .panel-left { display: none; }
            .split { flex-direction: column; }
        }
    </style>
</head>
<body>
<div class="split">

    {{-- ── Left panel: navy (internal staff) ─────────────── --}}
    <div class="panel-left">
        <div class="deco deco-1"></div>
        <div class="deco deco-2"></div>
        <div class="deco deco-3"></div>
        <div class="deco deco-4"></div>
        <div class="dot-grid"></div>
        <div class="left-inner">
            <div class="left-brand">
                <div class="left-brand-ring">ML</div>
                <span class="left-brand-name">myLRMP</span>
            </div>
            <div class="internal-badge">
                <div class="internal-dot"></div>
                Akses Dalaman Sahaja
            </div>
            <h1 class="left-title">Portal<br>Pegawai DOA</h1>
            <p class="left-desc">Sistem eksklusif untuk pegawai Jabatan Pertanian Malaysia bagi mengurus permohonan, penilaian teknikal, dan kelulusan label racun.</p>
            <div class="features">
                <div class="feature"><div class="feature-dot"></div><span>Semakan dan kelulusan permohonan</span></div>
                <div class="feature"><div class="feature-dot"></div><span>Penilaian teknikal dan penilaian label</span></div>
                <div class="feature"><div class="feature-dot"></div><span>Pengurusan pengguna dan syarikat</span></div>
                <div class="feature"><div class="feature-dot"></div><span>Laporan dan jejak audit penuh</span></div>
            </div>
        </div>
        <p class="left-footer">myLRMP &copy; {{ date('Y') }} Jabatan Pertanian Malaysia</p>
    </div>

    {{-- ── Right panel ────────────────────────────────────── --}}
    <div class="panel-right">
        <div class="right-inner">

            <a href="{{ route('home') }}" class="back-link">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.5 3L5 8l5.5 5"/>
                </svg>
                Kembali ke Laman Utama
            </a>

            <div class="card">
                <div class="card-top"></div>
                <div class="card-body">

                    <div class="logo-row">
                        <div class="logo-mark"><span>ML</span></div>
                        <div>
                            <div class="logo-text">myLRMP</div>
                            <div class="logo-sub">Portal Pegawai DOA</div>
                        </div>
                    </div>

                    <div class="gov-badge">
                        <div class="gov-badge-dot"></div>
                        Bahagian Kawalan Racun Makhluk Perosak (BKRPB)
                    </div>

                    <div class="card-title">Log Masuk</div>
                    <div class="card-sub">Akses terhad kepada pegawai Jabatan Pertanian Malaysia sahaja.</div>

                    {{-- Filament renders form here --}}
                    {{ $slot }}

                </div>{{-- end card-body --}}
            </div>{{-- end card --}}

            <div class="demo-link-wrap">
                <button class="demo-link" onclick="openDemo()">Lihat Akaun Demo →</button>
            </div>

            <p class="page-footer">myLRMP &copy; {{ date('Y') }} Jabatan Pertanian Malaysia &nbsp;·&nbsp; Akta 149</p>

        </div>
    </div>

</div>

{{-- ── Demo modal ──────────────────────────────────────────── --}}
<div class="modal-backdrop" id="demoBackdrop" onclick="if(event.target===this)closeDemo()">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-title">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                Akaun Demo Pegawai
                <span class="modal-badge">Persekitaran Ujian</span>
            </div>
            <button class="modal-close" onclick="closeDemo()">✕</button>
        </div>
        <div class="modal-body">
            <table class="demo-table">
                <thead><tr><th>Peranan</th><th>E-mel</th><th>Kata Laluan</th></tr></thead>
                <tbody>
                    <tr class="demo-group"><td colspan="3">Pentadbir</td></tr>
                    <tr class="demo-row" onclick="fillDemo('admin@doa.gov.my','Password123!')"><td><span class="role-pill pill-admin">Super Admin</span></td><td style="font-size:12.5px">admin@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-group"><td colspan="3">Pegawai DOA</td></tr>
                    <tr class="demo-row" onclick="fillDemo('ahmad.fadzillah@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Pendaftar</span></td><td style="font-size:12.5px">ahmad.fadzillah@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('noraini.hassan@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Pendaftar</span></td><td style="font-size:12.5px">noraini.hassan@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('zulkifli.osman@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Penilai Teknikal</span></td><td style="font-size:12.5px">zulkifli.osman@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('azwani.aziz@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Penilai Teknikal</span></td><td style="font-size:12.5px">azwani.aziz@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('hazrul.mahmud@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Penilai Teknikal</span></td><td style="font-size:12.5px">hazrul.mahmud@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('faridah.yusuf@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Penilai Label</span></td><td style="font-size:12.5px">faridah.yusuf@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('akmal.kamarudin@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Penilai Label</span></td><td style="font-size:12.5px">akmal.kamarudin@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('aisyah.ali@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Peg. Pendaftaran</span></td><td style="font-size:12.5px">aisyah.ali@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('razif.ibrahim@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Peg. Pendaftaran</span></td><td style="font-size:12.5px">razif.ibrahim@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                    <tr class="demo-row" onclick="fillDemo('wei.ching@doa.gov.my','Password123!')"><td><span class="role-pill pill-officer">Peg. Pendaftaran</span></td><td style="font-size:12.5px">wei.ching@doa.gov.my</td><td><span class="demo-pw">Password123!</span></td></tr>
                </tbody>
            </table>
        </div>
        <div class="modal-foot">Klik baris untuk isi e-mel &amp; kata laluan secara automatik &nbsp;·&nbsp; Persekitaran ujian sahaja</div>
    </div>
</div>

{{-- Hidden form for demo quick-login — bypasses Livewire entirely --}}
<form id="demo-login-form" action="{{ route('demo.login') }}" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="email"    id="demo-fill-email">
    <input type="hidden" name="password" id="demo-fill-password">
</form>

@livewireScripts
@filamentScripts
<script>
function openDemo()  { document.getElementById('demoBackdrop').classList.add('open');    document.body.style.overflow='hidden'; }
function closeDemo() { document.getElementById('demoBackdrop').classList.remove('open'); document.body.style.overflow=''; }
document.addEventListener('keydown', function(e) { if(e.key==='Escape') closeDemo(); });

function fillDemo(email, password) {
    document.getElementById('demo-fill-email').value    = email;
    document.getElementById('demo-fill-password').value = password;
    document.getElementById('demo-login-form').submit();
}
</script>
</body>
</html>
