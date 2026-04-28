<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* ── Base font ─────────────────────────────────────────── */
    body, .fi-simple-layout, .fi-simple-main, .fi-simple-main * {
        font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
    }

    /* ── Split layout ──────────────────────────────────────── */
    .fi-simple-layout {
        display: flex !important;
        flex-direction: row !important;
        min-height: 100vh !important;
        align-items: stretch !important;
        background: #f4f5f7 !important;
        padding: 0 !important;
    }

    /* ── Right panel (Filament's main content area) ────────── */
    .fi-simple-main-ctn {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: flex-start !important;
        padding: 2.5rem 1.5rem !important;
        background: #f4f5f7 !important;
        min-height: 100vh !important;
    }

    /* ── White card: strip Filament's defaults, let ours show ─ */
    .fi-simple-main {
        width: 100% !important;
        max-width: 400px !important;
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
    }

    /* ── Inner card wrapping the actual form ─────────────────── */
    .fi-auth-login-form-wrapper,
    form.fi-form,
    .fi-simple-main > .fi-form,
    .fi-simple-main > div > .fi-form,
    [wire\:id] .fi-form {
        background: #fff !important;
        border: 1px solid #E5EDF5 !important;
        border-radius: 10px !important;
        box-shadow: rgba(50,50,93,0.12) 0px 8px 24px -8px, rgba(0,0,0,0.06) 0px 4px 12px -4px !important;
        padding: 1.875rem !important;
        margin-bottom: 1rem !important;
    }

    /* ── Form heading (Log Masuk title) ──────────────────────── */
    .fi-simple-main h1,
    .fi-simple-header-heading {
        font-size: 1.125rem !important;
        font-weight: 600 !important;
        color: #061B31 !important;
        letter-spacing: -0.2px !important;
        margin-bottom: 4px !important;
    }
    .fi-simple-header-subheading {
        font-size: 0.8125rem !important;
        color: #64748D !important;
        margin-bottom: 1.25rem !important;
    }
    .fi-simple-header {
        align-items: flex-start !important;
        margin-bottom: 1.375rem !important;
    }

    /* ── Labels ──────────────────────────────────────────────── */
    label, .fi-label, .fi-fo-field-wrp-label label {
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        color: #061B31 !important;
        margin-bottom: 0.375rem !important;
        letter-spacing: 0.2px !important;
    }

    /* ── Input wrapper ───────────────────────────────────────── */
    .fi-input-wrp {
        border-radius: 6px !important;
        background: #fff !important;
        box-shadow: none !important;
        border: 1px solid #E5EDF5 !important;
    }
    .fi-input-wrp:focus-within {
        border-color: #006837 !important;
        box-shadow: 0 0 0 3px rgba(0,104,55,0.10) !important;
    }

    /* ── Actual input element ────────────────────────────────── */
    .fi-input,
    .fi-input-wrp input[type="email"],
    .fi-input-wrp input[type="password"],
    .fi-input-wrp input[type="text"] {
        padding: 0.625rem 0.875rem !important;
        font-size: 0.875rem !important;
        font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
        color: #061B31 !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        ring: none !important;
    }
    .fi-input::placeholder,
    .fi-input-wrp input::placeholder {
        color: #9aabbc !important;
    }

    /* ── Checkbox ────────────────────────────────────────────── */
    input[type="checkbox"] {
        accent-color: #006837 !important;
        width: 15px !important;
        height: 15px !important;
        cursor: pointer !important;
    }

    /* ── Submit button ───────────────────────────────────────── */
    .fi-btn.fi-btn-color-primary.fi-btn-style-filled,
    button[type="submit"],
    .fi-auth-login-form button.fi-btn {
        width: 100% !important;
        background: #006837 !important;
        color: #fff !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 0.6875rem 1rem !important;
        font-size: 0.9375rem !important;
        font-weight: 500 !important;
        font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
        cursor: pointer !important;
        transition: background 150ms ease, transform 150ms ease !important;
        justify-content: center !important;
        box-shadow: none !important;
        text-align: center !important;
    }
    .fi-btn.fi-btn-color-primary.fi-btn-style-filled:hover,
    button[type="submit"]:hover {
        background: #004d28 !important;
        transform: translateY(-1px) !important;
    }
    .fi-btn.fi-btn-color-primary.fi-btn-style-filled:active,
    button[type="submit"]:active {
        transform: translateY(0) !important;
    }

    /* ── Forgot password link ────────────────────────────────── */
    .fi-link,
    a.fi-link {
        color: #006837 !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
        text-decoration: none !important;
        transition: color 150ms ease !important;
    }
    .fi-link:hover { color: #004d28 !important; text-decoration: underline !important; }

    /* ── Field spacing ───────────────────────────────────────── */
    .fi-fo-field-wrp { margin-bottom: 1rem !important; }
    .fi-fo-cmp { margin-bottom: 1rem !important; }

    /* ── Logo area in the card (from login-panel hook) ───────── */
    .fi-simple-header .fi-logo,
    .fi-simple-layout .fi-logo { display: none !important; }

    /* ── Left green panel ────────────────────────────────────── */
    .fil-login-left {
        flex: 0 0 42%;
        position: relative;
        background: linear-gradient(155deg, #004d28 0%, #006837 45%, #005a2f 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 3rem 2.75rem;
        overflow: hidden;
    }
    .fil-deco { position: absolute; border-radius: 50%; opacity: .12; pointer-events: none; }
    .fil-deco-1 { width: 420px; height: 420px; background: #fff;    top: -120px; right: -140px; }
    .fil-deco-2 { width: 260px; height: 260px; background: #fff;    bottom: 60px; left: -80px; }
    .fil-deco-3 { width: 140px; height: 140px; background: #86efac; bottom: 180px; right: 40px; opacity: .18; }
    .fil-deco-4 { width:  60px; height:  60px; background: #bbf7d0; top: 200px;   left: 30px;  opacity: .25; }
    .fil-dot-grid {
        position: absolute; inset: 0; pointer-events: none;
        background-image: radial-gradient(circle, rgba(255,255,255,.15) 1px, transparent 1px);
        background-size: 28px 28px;
    }
    .fil-left-inner { position: relative; z-index: 1; }
    .fil-brand { display: inline-flex; align-items: center; gap: .625rem; margin-bottom: 2.5rem; }
    .fil-brand-ring {
        width: 44px; height: 44px;
        background: rgba(255,255,255,.2); border: 2px solid rgba(255,255,255,.35);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-weight: 900; font-size: .8rem; letter-spacing: .04em; color: white;
    }
    .fil-brand-name { color: white; font-size: 1.25rem; font-weight: 800; }
    .fil-left-title {
        color: white; font-size: 1.875rem; font-weight: 800;
        line-height: 1.25; letter-spacing: -.02em; margin-bottom: 1rem;
    }
    .fil-left-desc {
        color: rgba(255,255,255,.75); font-size: .9375rem;
        line-height: 1.6; margin-bottom: 2.5rem; max-width: 280px;
    }
    .fil-features { display: flex; flex-direction: column; gap: .75rem; }
    .fil-feature { display: flex; align-items: center; gap: .75rem; color: rgba(255,255,255,.85); font-size: .875rem; }
    .fil-dot { width: 8px; height: 8px; background: #86efac; border-radius: 50%; flex-shrink: 0; }
    .fil-left-foot {
        position: absolute; bottom: 1.5rem; left: 2.75rem; right: 2.75rem; z-index: 1;
        font-size: .75rem; color: rgba(255,255,255,.45);
    }

    /* ── Back link ───────────────────────────────────────────── */
    .fil-back-link {
        display: inline-flex; align-items: center; gap: .375rem;
        color: #64748D; font-size: .8125rem; text-decoration: none;
        transition: color .15s;
    }
    .fil-back-link:hover { color: #006837; }
    .fil-back-wrap { margin-bottom: 1.25rem; }

    /* ── Demo trigger ────────────────────────────────────────── */
    .fil-demo-trigger-wrap { text-align: center; margin: .75rem 0 1.5rem; }
    .fil-demo-trigger {
        background: none; border: none; cursor: pointer;
        font-size: .8125rem; color: #64748D; font-family: 'Poppins', sans-serif;
        text-decoration: underline; text-underline-offset: 3px; transition: color .15s; padding: 0;
    }
    .fil-demo-trigger:hover { color: #006837; }
    .fil-page-footer { text-align: center; font-size: .75rem; color: #9ca3af; }

    /* ── Demo modal ──────────────────────────────────────────── */
    .fil-demo-dialog {
        border: none; border-radius: 14px; padding: 0;
        max-width: 560px; width: 92vw; max-height: 80vh;
        overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.18);
    }
    .fil-demo-dialog::backdrop { background: rgba(0,0,0,.45); }
    .fil-demo-modal-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.375rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb;
    }
    .fil-demo-modal-title { font-size: .9375rem; font-weight: 700; color: #111827; }
    .fil-demo-badge-pill { background: #dcfce7; color: #15803d; font-size: .6875rem; font-weight: 600; padding: .125rem .5rem; border-radius: 9999px; margin-left: .5rem; }
    .fil-demo-close {
        width: 28px; height: 28px; border-radius: 6px; border: none;
        background: #f3f4f6; cursor: pointer; display: flex; align-items: center;
        justify-content: center; color: #6b7280; font-size: 1rem; transition: background .15s;
    }
    .fil-demo-close:hover { background: #e5e7eb; color: #111827; }
    .fil-demo-modal-body { overflow-y: auto; max-height: calc(80vh - 56px); }
    .fil-demo-tbl { width: 100%; border-collapse: collapse; font-size: .8125rem; }
    .fil-demo-tbl th {
        padding: .45rem 1.25rem; text-align: left; font-size: .7rem; font-weight: 600;
        color: #9ca3af; text-transform: uppercase; letter-spacing: .05em;
        background: #f9fafb; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0;
    }
    .fil-demo-tbl td { padding: .5rem 1.25rem; border-bottom: 1px solid #f3f4f6; color: #374151; vertical-align: middle; }
    .fil-demo-tbl tr:last-child td { border-bottom: none; }
    .fil-demo-tbl tr:hover td { background: #f9fafb; }
    .fil-grp-row td {
        background: #f9fafb; padding: .3rem 1.25rem; font-size: .7rem; font-weight: 700;
        color: #6b7280; text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid #e5e7eb;
    }
    .fil-pill { display: inline-block; font-size: .6875rem; font-weight: 500; padding: .125rem .5rem; border-radius: 9999px; white-space: nowrap; }
    .fil-pill-admin   { background: #fee2e2; color: #b91c1c; }
    .fil-pill-officer { background: #dbeafe; color: #1d4ed8; }
    .fil-pw { font-family: 'Courier New', monospace; font-size: .75rem; background: #f3f4f6; padding: .1rem .4rem; border-radius: 4px; color: #374151; white-space: nowrap; }

    /* ── Mobile ──────────────────────────────────────────────── */
    @media (max-width: 768px) {
        .fil-login-left { display: none !important; }
        .fi-simple-layout { flex-direction: column !important; }
    }
</style>
