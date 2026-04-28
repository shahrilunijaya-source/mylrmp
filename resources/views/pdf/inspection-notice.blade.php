<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 10pt; color: #1a1a1a; margin: 0; padding: 0; }
  .page { padding: 40px 48px; }
  .header { border-bottom: 2px solid #dc2626; padding-bottom: 14px; margin-bottom: 24px; }
  .header-title { font-size: 14pt; font-weight: bold; color: #dc2626; }
  .header-ref   { font-size: 9pt; color: #555; margin-top: 4px; }
  .section { margin-bottom: 20px; }
  .section-title { font-size: 9pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.8px; color: #555; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; margin-bottom: 10px; }
  .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px; }
  .info-item label { font-size: 7.5pt; color: #888; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 1px; }
  .info-item span  { font-size: 9.5pt; }
  .finding-row { background: #fef2f2; border-left: 3px solid #dc2626; padding: 8px 10px; margin-bottom: 6px; }
  .deadline-box { background: #fef2f2; border: 1.5px solid #dc2626; border-radius: 6px; padding: 14px 16px; margin: 18px 0; text-align: center; }
  .deadline-lbl { font-size: 9pt; color: #dc2626; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
  .deadline-val { font-size: 16pt; font-weight: bold; color: #dc2626; }
  .footer { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 12px; font-size: 8pt; color: #888; }
  .sig-box { margin-top: 40px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
  .sig-line { border-top: 1px solid #1a1a1a; padding-top: 6px; font-size: 8.5pt; color: #333; margin-top: 40px; }
</style>
</head>
<body>
<div class="page">

  <div class="header">
    <div class="header-title">NOTIS KETIDAKPATUHAN</div>
    <div class="header-ref">Ruj: {{ $inspection->inspection_no }} | Jabatan Pertanian Malaysia</div>
  </div>

  <div class="section">
    <div class="section-title">Kepada</div>
    @php $target = $inspection->target; @endphp
    @if($target)
    <p style="font-size:10pt;font-weight:bold;margin:0 0 4px;">{{ $target->name }}</p>
    @if($target instanceof \App\Models\Premises)
    <p style="font-size:9pt;color:#555;margin:0;">{{ $target->address_line1 }}{{ $target->address_line2 ? ', ' . $target->address_line2 : '' }}, {{ $target->postcode }} {{ $target->district }}, {{ $target->state?->label() }}</p>
    @else
    <p style="font-size:9pt;color:#555;margin:0;">No. SSM: {{ $target->ssm_no ?? '—' }}</p>
    @endif
    @endif
  </div>

  <p style="font-size:9.5pt;line-height:1.7;">
    Dengan hormatnya, pihak kami memaklumkan bahawa pemeriksaan yang dijalankan pada
    <strong>{{ $inspection->conducted_at?->format('d M Y') }}</strong> telah mendapati
    <strong>{{ $inspection->findings->count() }} ketidakpatuhan</strong>
    ({{ $inspection->status->label() }}) di premis / syarikat anda.
  </p>

  @if($inspection->summary)
  <div class="section">
    <div class="section-title">Rumusan Pegawai Pemeriksa</div>
    <p style="font-size:9.5pt;line-height:1.65;margin:0;">{{ $inspection->summary }}</p>
  </div>
  @endif

  @if($inspection->findings->isNotEmpty())
  <div class="section">
    <div class="section-title">Senarai Ketidakpatuhan Yang Perlu Diperbetulkan</div>
    @foreach($inspection->findings as $i => $f)
    <div class="finding-row">
      <div style="font-size:8pt;font-weight:bold;margin-bottom:3px;">{{ $i + 1 }}. {{ strtoupper($f->severity->label()) }} — {{ $f->category }} @if($f->linkedProduct)({{ $f->linkedProduct->name }})@endif</div>
      <div style="font-size:9pt;">{{ $f->description }}</div>
    </div>
    @endforeach
  </div>
  @endif

  @if($inspection->notice_deadline)
  <div class="deadline-box">
    <div class="deadline-lbl">Semua ketidakpatuhan mesti diperbetulkan sebelum</div>
    <div class="deadline-val">{{ $inspection->notice_deadline->format('d M Y') }}</div>
  </div>
  @endif

  <p style="font-size:9.5pt;line-height:1.7;">
    Kegagalan mematuhi notis ini dalam tempoh yang ditetapkan boleh mengakibatkan tindakan penguatkuasaan lanjut mengikut Akta Racun Makanan 1974.
  </p>

  <div class="sig-box">
    <div>
      <div style="font-size:9pt;margin-bottom:4px;">Dikeluarkan oleh:</div>
      <div class="sig-line">
        <strong>{{ $inspection->inspector?->name ?? '—' }}</strong><br>
        Pegawai Pemeriksaan<br>
        Jabatan Pertanian Malaysia
      </div>
    </div>
    <div>
      <div style="font-size:9pt;margin-bottom:4px;">Tarikh:</div>
      <div class="sig-line">{{ now()->format('d M Y') }}</div>
    </div>
  </div>

  <div class="footer">
    Dijana oleh myLRMP pada {{ now()->format('d M Y, g:ia') }} | {{ $inspection->inspection_no }}
  </div>

</div>
</body>
</html>
