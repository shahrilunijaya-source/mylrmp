<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a1a; }
        .header { text-align: center; border-bottom: 3px solid #006837; padding-bottom: 15px; margin-bottom: 20px; }
        .cert-title { font-size: 18px; font-weight: bold; color: #006837; text-transform: uppercase; }
        .reg-no { font-size: 24px; font-weight: bold; color: #006837; margin: 10px 0; }
        .section { margin-bottom: 15px; }
        .section-title { font-weight: bold; color: #006837; border-bottom: 1px solid #006837; margin-bottom: 8px; font-size: 11px; text-transform: uppercase; }
        .row { display: flex; margin-bottom: 5px; }
        .label { width: 200px; font-weight: 600; color: #555; }
        .value { flex: 1; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #006837; color: white; padding: 6px; text-align: left; font-size: 11px; }
        td { padding: 5px 6px; border-bottom: 1px solid #ddd; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
        .watermark { position: fixed; top: 40%; left: 20%; opacity: 0.05; font-size: 80px; color: #006837; transform: rotate(-30deg); font-weight: bold; }
    </style>
</head>
<body>
<div class="watermark">myLRMP</div>
<div class="header">
    <div style="font-size:13px; font-weight:bold;">JABATAN PERTANIAN MALAYSIA</div>
    <div style="font-size:11px; color:#555;">Bahagian Kawalan Racun Perosak dan Baja (BKRPB)</div>
    <div class="cert-title" style="margin-top:12px;">Sijil Pendaftaran Produk Racun Makhluk Perosak</div>
    <div style="font-size:11px; color:#555;">Certificate of Registration — Pesticide Product</div>
    <div class="reg-no">{{ $certificate->registration_no }}</div>
</div>

<div class="section">
    <div class="section-title">Butiran Produk / Product Details</div>
    <div class="row"><div class="label">Nama Produk:</div><div class="value">{{ $certificate->application->product?->name ?? 'N/A' }}</div></div>
    <div class="row"><div class="label">Jenis Formulasi:</div><div class="value">{{ $certificate->application->product?->formulationType?->name_ms ?? 'N/A' }}</div></div>
    <div class="row"><div class="label">Kategori:</div><div class="value">{{ $certificate->application->category?->name_ms ?? 'N/A' }}</div></div>
</div>

<div class="section">
    <div class="section-title">Maklumat Pendaftaran / Registration Information</div>
    <div class="row"><div class="label">No. Pendaftaran:</div><div class="value"><strong>{{ $certificate->registration_no }}</strong></div></div>
    <div class="row"><div class="label">Tarikh Keluaran:</div><div class="value">{{ \Carbon\Carbon::parse($certificate->issued_at)->format('d F Y') }}</div></div>
    <div class="row"><div class="label">Tarikh Tamat:</div><div class="value">{{ \Carbon\Carbon::parse($certificate->expires_at)->format('d F Y') }}</div></div>
    <div class="row"><div class="label">Syarikat Pemegang:</div><div class="value">{{ $certificate->application->company?->name ?? 'N/A' }}</div></div>
    <div class="row"><div class="label">No. Permohonan:</div><div class="value">{{ $certificate->application->application_no }}</div></div>
</div>

@if($certificate->application->product?->activeIngredients->count())
<div class="section">
    <div class="section-title">Perawis Aktif / Active Ingredients</div>
    <table>
        <tr><th>Nama Perawis Aktif</th><th>No. CAS</th><th>Kepekatan (%)</th></tr>
        @foreach($certificate->application->product->activeIngredients as $ai)
        <tr>
            <td>{{ $ai->name }}</td>
            <td>{{ $ai->cas_no ?? '-' }}</td>
            <td>{{ $ai->pivot->concentration_percent ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endif

<div class="section" style="margin-top:30px;">
    <table style="width:100%; border:none;">
        <tr>
            <td style="width:50%; text-align:center; border:none; padding-top:40px;">
                <div style="border-top:1px solid #333; display:inline-block; width:200px; padding-top:5px;">Pendaftar / Registrar</div>
            </td>
            <td style="width:50%; text-align:center; border:none; padding-top:40px;">
                <div style="border-top:1px solid #333; display:inline-block; width:200px; padding-top:5px;">Ketua Bahagian / Head of Division</div>
            </td>
        </tr>
    </table>
</div>

<div class="footer">
    <p>Sijil ini dikeluarkan mengikut Akta Racun Makhluk Perosak 1974 (Akta 149). This certificate is issued under the Pesticides Act 1974 (Act 149).</p>
    <p>Jabatan Pertanian Malaysia | Aras 2, Wisma Tani, No. 28, Persiaran Perdana, Presint 4, 62624 Putrajaya | Tel: 03-8870 1000</p>
    <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
</div>
</body>
</html>
