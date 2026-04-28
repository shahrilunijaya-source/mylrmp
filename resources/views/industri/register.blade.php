<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/png" href="/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Daftar Syarikat — myLRMP</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --accent:      #006837;
  --accent-dark: #004d28;
  --accent-bg:   #f0fdf4;
  --accent-mid:  #16a34a;
  --navy:        #061B31;
  --slate:       #64748D;
  --border:      #E5EDF5;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; }
body {
  font-family: 'Poppins', sans-serif;
  -webkit-font-smoothing: antialiased;
  color: var(--navy);
  min-height: 100vh;
  display: flex;
}

/* ── Left panel ── */
.panel-left {
  position: relative;
  flex: 0 0 42%;
  background: linear-gradient(155deg, #003d20 0%, #006837 45%, #008545 100%);
  display: flex; flex-direction: column; justify-content: center;
  padding: 3rem 2.75rem; overflow: hidden;
}
.deco { position: absolute; border-radius: 50%; opacity: .10; pointer-events: none; }
.deco-1 { width: 420px; height: 420px; background: #fff; top: -120px; right: -140px; }
.deco-2 { width: 260px; height: 260px; background: #fff; bottom: 60px; left: -80px; }
.deco-3 { width: 140px; height: 140px; background: #86efac; bottom: 180px; right: 40px; opacity: .15; }
.deco-4 { width: 60px;  height: 60px;  background: #bbf7d0; top: 200px; left: 30px; opacity: .20; }
.dot-grid {
  position: absolute; inset: 0; pointer-events: none;
  background-image: radial-gradient(circle, rgba(255,255,255,.10) 1px, transparent 1px);
  background-size: 28px 28px;
}
.left-inner { position: relative; z-index: 1; }
.portal-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,.10); border: 1px solid rgba(255,255,255,.20);
  border-radius: 4px; padding: 5px 10px; margin-bottom: 1.5rem;
  font-size: .6875rem; font-weight: 600; letter-spacing: .06em;
  text-transform: uppercase; color: rgba(255,255,255,.75);
}
.portal-dot { width: 6px; height: 6px; background: #FFCC00; border-radius: 50%; flex-shrink: 0; }
.left-title { color: white; font-size: 1.875rem; font-weight: 800; line-height: 1.25; letter-spacing: -.02em; margin-bottom: 1rem; }
.left-desc { color: rgba(255,255,255,.65); font-size: .9375rem; line-height: 1.6; margin-bottom: 2.5rem; max-width: 280px; }
.features { display: flex; flex-direction: column; gap: .75rem; }
.feature { display: flex; align-items: center; gap: .75rem; color: rgba(255,255,255,.80); font-size: .875rem; }
.feature-dot { width: 8px; height: 8px; background: #FFCC00; border-radius: 50%; flex-shrink: 0; }
.left-footer { position: absolute; bottom: 1.5rem; left: 2.75rem; right: 2.75rem; z-index: 1; font-size: .75rem; color: rgba(255,255,255,.35); }

/* ── Right panel ── */
.panel-right {
  flex: 1; background: #f4fbf7;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  padding: 40px 16px; overflow-y: auto;
}
.panel-right::before {
  content: '';
  position: fixed; inset: 0;
  background:
    radial-gradient(ellipse 70% 60% at 10% 20%, rgba(0,104,55,.07) 0%, transparent 55%),
    radial-gradient(ellipse 50% 50% at 90% 80%, rgba(0,104,55,.05) 0%, transparent 50%);
  pointer-events: none; z-index: 0;
}
.page-wrap {
  position: relative; z-index: 1;
  width: 100%; max-width: 480px;
}

/* Back link */
.back-link {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 13px; color: var(--slate);
  text-decoration: none; margin-bottom: 20px; transition: color .15s;
}
.back-link:hover { color: var(--accent); }
.back-link svg { transition: transform .15s; }
.back-link:hover svg { transform: translateX(-2px); }

/* Card */
.card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: rgba(50,50,93,0.12) 0px 10px 30px -8px, rgba(0,0,0,0.06) 0px 4px 12px -4px;
  overflow: hidden;
}
.card-top { height: 3px; background: linear-gradient(90deg, var(--accent) 0%, var(--accent-mid) 100%); }
.card-body { padding: 28px 32px 24px; }

.card-title { font-size: 18px; font-weight: 600; color: var(--navy); margin-bottom: 4px; letter-spacing: -0.3px; }
.card-sub   { font-size: 13px; color: var(--slate); margin-bottom: 20px; }

/* Errors */
.error-box {
  background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px;
  padding: 10px 14px; margin-bottom: 16px; font-size: 13px; color: #b91c1c;
}

/* Section divider */
.section-label {
  font-size: 10.5px; font-weight: 700; color: #9aabbc;
  text-transform: uppercase; letter-spacing: .08em;
  border-top: 1px solid #f3f4f6; padding-top: 16px; margin-bottom: 12px;
}
.section-label:first-of-type { border-top: none; padding-top: 0; }

/* Fields */
.field { margin-bottom: 13px; }
.field label {
  display: block; font-size: 12px; font-weight: 500;
  color: var(--navy); margin-bottom: 5px; letter-spacing: 0.2px;
}
.field label .req { color: #ef4444; }
.field input, .field textarea {
  width: 100%;
  border: 1px solid var(--border);
  border-radius: 6px;
  padding: 9px 13px;
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  color: var(--navy);
  background: #fff;
  outline: none;
  transition: border-color 150ms ease, box-shadow 150ms ease;
}
.field textarea { resize: vertical; min-height: 64px; line-height: 1.5; }
.field input::placeholder, .field textarea::placeholder { color: #9aabbc; }
.field input:focus, .field textarea:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(0,104,55,.12);
}
.field input.is-error { border-color: #f87171; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

/* Submit */
.submit-btn {
  width: 100%; padding: 11px;
  background: var(--accent); color: #fff;
  font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
  border: none; border-radius: 4px; cursor: pointer;
  transition: background 150ms ease, transform 150ms ease;
  margin-top: 4px;
}
.submit-btn:hover { background: var(--accent-dark); transform: translateY(-1px); }
.submit-btn:active { transform: translateY(0); }

/* Card footer */
.card-foot {
  border-top: 1px solid #f3f4f6;
  padding: 14px 32px;
  text-align: center;
  font-size: 13px; color: var(--slate);
}
.card-foot a { color: var(--accent); font-weight: 600; text-decoration: none; }
.card-foot a:hover { text-decoration: underline; }

/* Mobile */
@media (max-width: 768px) {
  .panel-left { display: none; }
  body { flex-direction: column; }
  .field-row { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<div class="panel-left">
    <div class="deco deco-1"></div>
    <div class="deco deco-2"></div>
    <div class="deco deco-3"></div>
    <div class="deco deco-4"></div>
    <div class="dot-grid"></div>
    <div class="left-inner">
        <div class="portal-badge">
            <div class="portal-dot"></div>
            Portal Syarikat
        </div>
        <h1 class="left-title">Portal<br>Industri</h1>
        <p class="left-desc">Platform bagi syarikat industri untuk mengurus permohonan pendaftaran dan pelesenan label racun makhluk perosak.</p>
        <div class="features">
            <div class="feature"><div class="feature-dot"></div><span>Hantar permohonan pendaftaran label</span></div>
            <div class="feature"><div class="feature-dot"></div><span>Semak status permohonan masa nyata</span></div>
            <div class="feature"><div class="feature-dot"></div><span>Urus profil dan dokumen syarikat</span></div>
            <div class="feature"><div class="feature-dot"></div><span>Muat turun sijil dan kelulusan</span></div>
        </div>
    </div>
    <p class="left-footer">myLRMP &copy; {{ date('Y') }} Jabatan Pertanian Malaysia</p>
</div>

<div class="panel-right">
<div class="page-wrap">

    <a href="{{ route('industri.login') }}" class="back-link">
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.5 3L5 8l5.5 5"/>
        </svg>
        Kembali ke Log Masuk
    </a>

    <div class="card">
        <div class="card-top"></div>
        <div class="card-body">

            <div class="card-title">Pendaftaran Syarikat Baharu</div>
            <div class="card-sub">Buat akaun untuk menghantar permohonan pendaftaran produk.</div>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('industri.register.store') }}" novalidate>
                @csrf

                <p class="section-label">Maklumat Syarikat</p>

                <div class="field">
                    <label>Nama Syarikat <span class="req">*</span></label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                           placeholder="Contoh: Agro Kimia Sdn Bhd"
                           class="{{ $errors->has('company_name') ? 'is-error' : '' }}">
                </div>

                <div class="field">
                    <label>No. SSM <span class="req">*</span></label>
                    <input type="text" name="ssm_no" value="{{ old('ssm_no') }}"
                           placeholder="Contoh: 1234567-X"
                           class="{{ $errors->has('ssm_no') ? 'is-error' : '' }}">
                </div>

                <div class="field">
                    <label>Alamat Syarikat <span class="req">*</span></label>
                    <textarea name="address" placeholder="Alamat penuh syarikat"
                              class="{{ $errors->has('address') ? 'is-error' : '' }}">{{ old('address') }}</textarea>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>Orang Hubungi <span class="req">*</span></label>
                        <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                               placeholder="Nama penuh"
                               class="{{ $errors->has('contact_person') ? 'is-error' : '' }}">
                    </div>
                    <div class="field">
                        <label>No. Telefon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               placeholder="mis: 0123456789">
                    </div>
                </div>

                <p class="section-label">Maklumat Log Masuk</p>

                <div class="field">
                    <label>Alamat E-mel <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="nama@syarikat.com" autocomplete="email"
                           class="{{ $errors->has('email') ? 'is-error' : '' }}">
                </div>

                <div class="field">
                    <label>Kata Laluan <span class="req">*</span></label>
                    <input type="password" name="password"
                           placeholder="Sekurang-kurangnya 8 aksara" autocomplete="new-password"
                           class="{{ $errors->has('password') ? 'is-error' : '' }}">
                </div>

                <div class="field">
                    <label>Sahkan Kata Laluan <span class="req">*</span></label>
                    <input type="password" name="password_confirmation"
                           placeholder="Ulangi kata laluan" autocomplete="new-password">
                </div>

                <button type="submit" class="submit-btn">Daftar Sekarang</button>
            </form>
        </div>

        <div class="card-foot">
            Sudah ada akaun? <a href="{{ route('industri.login') }}">Log Masuk</a>
        </div>
    </div>

</div>
</div>{{-- end panel-right --}}

</body>
</html>
