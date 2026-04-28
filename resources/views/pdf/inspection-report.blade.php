<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 10pt; color: #1a1a1a; margin: 0; padding: 0; }
  .page { padding: 40px 48px; }
  .header { border-bottom: 2px solid #0a2440; padding-bottom: 14px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-end; }
  .header-title { font-size: 14pt; font-weight: bold; color: #0a2440; }
  .header-sub { font-size: 8pt; color: #555; margin-top: 2px; }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 8pt; font-weight: bold; }
  .badge-ok   { background: #dcfce7; color: #166534; }
  .badge-warn { background: #fef9c3; color: #854d0e; }
  .badge-err  { background: #fee2e2; color: #991b1b; }
  .section { margin-bottom: 18px; }
  .section-title { font-size: 9pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.8px; color: #555; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; margin-bottom: 10px; }
  .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px; }
  .info-item label { font-size: 7.5pt; color: #888; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 1px; }
  .info-item span  { font-size: 9.5pt; color: #1a1a1a; }
  table { width: 100%; border-collapse: collapse; font-size: 9pt; }
  th { background: #f1f5f9; text-align: left; padding: 6px 8px; font-size: 8pt; color: #555; text-transform: uppercase; letter-spacing: 0.5px; }
  td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
  .ans-yes  { color: #166534; font-weight: bold; }
  .ans-no   { color: #991b1b; font-weight: bold; }
  .ans-na   { color: #888; }
  .finding  { background: #fef9c3; border-left: 3px solid #ca8a04; padding: 8px 10px; margin-bottom: 8px; }
  .finding.major { background: #fee2e2; border-left-color: #dc2626; }
  .footer { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 12px; display: flex; justify-content: space-between; font-size: 8pt; color: #888; }
</style>
</head>
<body>
<div class="page">

  <div class="header">
    <div>
      <div class="header-title">LAPORAN PEMERIKSAAN</div>
      <div class="header-sub">Jabatan Pertanian Malaysia — Sistem Bersepadu Racun Makhluk Perosak</div>
    </div>
    <div style="text-align:right;">
      <div style="font-size:12pt;font-weight:bold;color:#0a2440;">{{ $inspection->inspection_no }}</div>
      @php
        $badge = match($inspection->status->value) {
          'compliant' => 'badge-ok',
          'minor_nc'  => 'badge-warn',
          'major_nc'  => 'badge-err',
          default     => ''
        };
      @endphp
      <span class="badge {{ $badge }}">{{ $inspection->status->label() }}</span>
    </div>
  </div>

  <div class="section">
    <div class="section-title">Maklumat Pemeriksaan</div>
    <div class="info-grid">
      <div class="info-item"><label>Sasaran</label><span>{{ $inspection->targetLabel() }}</span></div>
      <div class="info-item"><label>Pemeriksa</label><span>{{ $inspection->inspector?->name ?? '—' }}</span></div>
      <div class="info-item"><label>Tarikh Dijadual</label><span>{{ $inspection->scheduled_for?->format('d M Y') }}</span></div>
      <div class="info-item"><label>Tarikh Dijalankan</label><span>{{ $inspection->conducted_at?->format('d M Y, g:ia') ?? '—' }}</span></div>
      @if($inspection->notice_deadline)
      <div class="info-item"><label>Tarikh Akhir Pembetulan</label><span style="color:#dc2626;font-weight:bold;">{{ $inspection->notice_deadline->format('d M Y') }}</span></div>
      @endif
    </div>
  </div>

  @if($inspection->summary)
  <div class="section">
    <div class="section-title">Rumusan Keseluruhan</div>
    <p style="font-size:9.5pt;line-height:1.65;margin:0;">{{ $inspection->summary }}</p>
  </div>
  @endif

  @if($inspection->checklistResponses->isNotEmpty())
  <div class="section">
    <div class="section-title">Senarai Semak</div>
    <table>
      <thead><tr><th style="width:8%">Kod</th><th>Perkara</th><th style="width:10%">Jawapan</th><th style="width:25%">Nota</th></tr></thead>
      <tbody>
      @foreach($inspection->checklistResponses->sortBy('item.display_order') as $resp)
      <tr>
        <td>{{ $resp->item?->code }}</td>
        <td>{{ $resp->item?->prompt_ms }}</td>
        <td class="{{ $resp->answer === 'Yes' ? 'ans-yes' : ($resp->answer === 'No' ? 'ans-no' : 'ans-na') }}">
          {{ $resp->answer === 'Yes' ? 'Ya' : ($resp->answer === 'No' ? 'Tidak' : 'T/B') }}
        </td>
        <td style="color:#555;">{{ $resp->note ?? '' }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  @endif

  @if($inspection->findings->isNotEmpty())
  <div class="section">
    <div class="section-title">Penemuan Ketidakpatuhan ({{ $inspection->findings->count() }})</div>
    @foreach($inspection->findings as $f)
    <div class="finding {{ $f->severity->value }}">
      <div style="font-size:8pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">
        {{ $f->severity->label() }} — {{ $f->category }}
        @if($f->linkedProduct) · {{ $f->linkedProduct->name }} @endif
      </div>
      <div style="font-size:9pt;">{{ $f->description }}</div>
    </div>
    @endforeach
  </div>
  @endif

  <div class="footer">
    <span>Dijana oleh myLRMP pada {{ now()->format('d M Y, g:ia') }}</span>
    <span>{{ $inspection->inspection_no }}</span>
  </div>

</div>
</body>
</html>
