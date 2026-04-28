<x-layouts.officer title="{{ $application->application_no }}">

@php
    $stClass = match($application->current_stage->value) {
        'approved'        => 'st-ok',
        'rejected'        => 'st-rej',
        'submitted'       => 'st-sub',
        'tech_review'     => 'st-tec',
        'label_review'    => 'st-lbl',
        'decision'        => 'st-dec',
        'needs_revision'  => 'st-nds',
        default           => 'st-drf',
    };
    $daysElapsed = $application->submitted_at ? (int) $application->submitted_at->diffInDays(now()) : 0;
@endphp

<style>
.show-grid { display: flex; gap: 20px; align-items: flex-start; }
.show-left  { flex: 0 0 60%; min-width: 0; }
.show-right { flex: 0 0 calc(40% - 20px); position: sticky; top: 0; }

.sec-card { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; margin-bottom: 16px; box-shadow: var(--stripe-shadow-sm); overflow: hidden; }
.sec-head { padding: 13px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.sec-title { font-size: 12.5px; font-weight: 600; color: var(--text); letter-spacing: -0.01em; }
.sec-body { padding: 16px 18px; }

.info-row { display: flex; align-items: flex-start; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid var(--border); font-size: 13px; gap: 16px; }
.info-row:last-child { border-bottom: none; }
.info-label { color: var(--text-4); flex-shrink: 0; min-width: 130px; }
.info-value { color: var(--text); font-weight: 500; text-align: right; }

.review-item { padding: 12px 0; border-bottom: 1px solid var(--border); display: flex; gap: 12px; }
.review-item:last-child { border-bottom: none; }
.review-dot { width: 28px; height: 28px; border-radius: 50%; background: var(--bg); border: 2px solid var(--border); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 10px; font-weight: 700; color: var(--text-4); margin-top: 2px; }
.review-dot.ok  { background: var(--brand); border-color: var(--brand); color: #fff; }
.review-dot.rej { background: var(--red); border-color: var(--red); color: #fff; }
.review-dot.rev { background: var(--amber-bg); border-color: #fde68a; color: var(--amber); }
.review-content { flex: 1; min-width: 0; }
.review-who { font-size: 13px; font-weight: 600; color: var(--text); }
.review-meta { font-size: 11.5px; color: var(--text-4); margin-top: 2px; }
.review-comment { font-size: 12.5px; color: var(--text-2); background: var(--surface-2); border: 1px solid var(--border); border-radius: 6px; padding: 8px 12px; margin-top: 8px; border-left: 3px solid var(--navy); line-height: 1.5; }

.doc-row { display: flex; align-items: center; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--border); }
.doc-row:last-child { border-bottom: none; }
.doc-ic { width: 34px; height: 34px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 9.5px; font-weight: 700; flex-shrink: 0; }
.doc-ic.pdf  { background: #fee2e2; color: #dc2626; }
.doc-ic.docx { background: #dbeafe; color: #2563eb; }
.doc-ic.xlsx { background: #dcfce7; color: #16a34a; }
.doc-ic.file { background: var(--bg); color: var(--text-4); border: 1px solid var(--border); }

.action-section { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 18px; margin-top: 12px; box-shadow: var(--stripe-shadow-sm); }
.action-section-title { font-size: 12px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-4); margin-bottom: 14px; }
</style>

{{-- Breadcrumb --}}
<div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-4);margin-bottom:18px;">
    <a href="{{ route('officer.applications.index') }}" style="color:var(--text-3);text-decoration:none;">Peti Masuk</a>
    <svg width="10" height="10" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 3l5 5-5 5"/></svg>
    <span class="app-chip">{{ $application->application_no }}</span>
</div>

@if(session('success'))
    <div style="margin-bottom:16px;padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;color:#15803d;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="margin-bottom:16px;padding:10px 14px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;font-size:13px;color:#b91c1c;">
        {{ session('error') }}
    </div>
@endif

<div class="show-grid">

    {{-- ═══ LEFT COLUMN ═══ --}}
    <div class="show-left">

        {{-- Maklumat Pemohon --}}
        <div class="sec-card">
            <div class="sec-head">
                <span class="sec-title">Maklumat Pemohon</span>
            </div>
            <div class="sec-body">
                <div class="eyebrow" style="margin-bottom:12px;">Syarikat</div>
                <div class="info-row">
                    <span class="info-label">Nama Syarikat</span>
                    <span class="info-value">{{ $application->company?->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. SSM</span>
                    <span class="info-value" style="font-family:var(--mono);font-size:12px;">{{ $application->company?->ssm_no ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Orang Hubungan</span>
                    <span class="info-value">{{ $application->company?->contact_person ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">E-mel Syarikat</span>
                    <span class="info-value">{{ $application->company?->email ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Telefon</span>
                    <span class="info-value">{{ $application->company?->phone ?? '—' }}</span>
                </div>

                <div class="eyebrow" style="margin-top:16px;margin-bottom:12px;">Pemohon</div>
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-value">{{ $application->applicant?->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">E-mel</span>
                    <span class="info-value">{{ $application->applicant?->email ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Butiran Produk --}}
        <div class="sec-card">
            <div class="sec-head">
                <span class="sec-title">Butiran Produk</span>
                @if($application->product?->activeIngredients?->count())
                    <span class="card-meta">{{ $application->product->activeIngredients->count() }} bahan aktif</span>
                @endif
            </div>
            <div class="sec-body">
                <div class="info-row">
                    <span class="info-label">Nama Produk</span>
                    <span class="info-value">{{ $application->product?->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Formulasi</span>
                    <span class="info-value">{{ $application->product?->formulationType?->name_ms ?? $application->product?->formulationType?->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pengeluar</span>
                    <span class="info-value">{{ $application->product?->manufacturer ?? '—' }}</span>
                </div>

                @if($application->product?->activeIngredients?->isNotEmpty())
                    <div style="margin-top:16px;">
                        <div class="eyebrow" style="margin-bottom:10px;">Bahan Aktif</div>
                        <div style="overflow-x:auto;">
                            <table class="tbl">
                                <thead>
                                    <tr>
                                        <th>Nama Bahan</th>
                                        <th>No. CAS</th>
                                        <th>Kepekatan (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($application->product->activeIngredients as $ai)
                                        <tr>
                                            <td style="font-weight:500;">{{ $ai->name }}</td>
                                            <td style="font-family:var(--mono);font-size:12px;color:var(--text-3);">{{ $ai->cas_no ?? '—' }}</td>
                                            <td>{{ $ai->pivot->concentration_percent ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Dokumen --}}
        @if($application->documents?->isNotEmpty())
            <div class="sec-card">
                <div class="sec-head">
                    <span class="sec-title">Dokumen</span>
                    <span class="card-meta">{{ $application->documents->count() }} fail</span>
                </div>
                <div class="sec-body">
                    @foreach($application->documents as $doc)
                        @php
                            $ext = strtolower(pathinfo($doc->original_name ?? $doc->filename ?? '', PATHINFO_EXTENSION));
                            $iconClass = match($ext) { 'pdf' => 'pdf', 'docx', 'doc' => 'docx', 'xlsx', 'xls' => 'xlsx', default => 'file' };
                            $iconLabel = match($ext) { 'pdf' => 'PDF', 'docx', 'doc' => 'DOC', 'xlsx', 'xls' => 'XLS', default => strtoupper($ext) ?: 'FILE' };
                        @endphp
                        <div class="doc-row">
                            <div class="doc-ic {{ $iconClass }}">{{ $iconLabel }}</div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:13px;font-weight:500;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $doc->original_name ?? $doc->filename ?? 'Dokumen' }}
                                </div>
                                <div style="font-size:11.5px;color:var(--text-4);margin-top:2px;">
                                    {{ $doc->document_type ?? $doc->type ?? '—' }}
                                    @if($doc->size ?? null)
                                        &middot; {{ number_format(($doc->size) / 1024, 1) }} KB
                                    @endif
                                    @if($doc->created_at ?? null)
                                        &middot; {{ $doc->created_at->format('d/m/Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Sejarah Semakan --}}
        <div class="sec-card">
            <div class="sec-head">
                <span class="sec-title">Sejarah Semakan</span>
                @if($application->reviews?->count())
                    <span class="card-meta">{{ $application->reviews->count() }} semakan</span>
                @endif
            </div>
            <div class="sec-body">
                @if($application->reviews?->isEmpty())
                    <div style="font-size:13px;color:var(--text-4);padding:8px 0;">Tiada semakan dilakukan lagi.</div>
                @else
                    @foreach($application->reviews->sortBy('created_at') as $review)
                        @php
                            $decisionVal = $review->decision?->value ?? '';
                            $dotClass = match($decisionVal) {
                                'approved' => 'ok',
                                'rejected' => 'rej',
                                default    => 'rev',
                            };
                            $dotLabel = match($decisionVal) {
                                'approved' => '✓',
                                'rejected' => '✕',
                                default    => '⋯',
                            };
                            $decStClass = match($decisionVal) {
                                'approved' => 'st-ok',
                                'rejected' => 'st-rej',
                                default    => 'st-rev',
                            };
                            $decLabel = match($decisionVal) {
                                'approved' => 'Diluluskan',
                                'rejected' => 'Ditolak',
                                default    => 'Dalam Semakan',
                            };
                        @endphp
                        <div class="review-item">
                            <div class="review-dot {{ $dotClass }}">{{ $dotLabel }}</div>
                            <div class="review-content">
                                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                    <span class="review-who">{{ $review->reviewer?->name ?? 'Pegawai' }}</span>
                                    <span class="st {{ $decStClass }}">{{ $decLabel }}</span>
                                    @if($review->stage)
                                        <span class="st st-drf" style="font-size:11px;">
                                            {{ $review->stage instanceof \App\Enums\ApplicationStage ? $review->stage->label() : $review->stage }}
                                        </span>
                                    @endif
                                </div>
                                <div class="review-meta">
                                    {{ $review->reviewed_at?->format('d M Y, h:i A') ?? $review->created_at?->format('d M Y, h:i A') ?? '—' }}
                                </div>
                                @if($review->comments)
                                    <div class="review-comment">{{ $review->comments }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

    {{-- ═══ RIGHT COLUMN ═══ --}}
    <div class="show-right">

        {{-- Status card --}}
        <div class="sec-card">
            <div class="sec-head">
                <span class="sec-title">Status Permohonan</span>
            </div>
            <div class="sec-body" style="text-align:center;padding:20px 18px;">
                <span class="st {{ $stClass }}" style="font-size:13.5px;padding:6px 14px 6px 12px;">
                    {{ $application->current_stage->label() }}
                </span>
                <div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;text-align:left;">
                    <div class="info-row" style="padding:6px 0;">
                        <span class="info-label">No. Permohonan</span>
                        <span class="app-chip">{{ $application->application_no }}</span>
                    </div>
                    <div class="info-row" style="padding:6px 0;">
                        <span class="info-label">Tarikh Hantar</span>
                        <span class="info-value">{{ $application->submitted_at?->format('d M Y') ?? '—' }}</span>
                    </div>
                    <div class="info-row" style="padding:6px 0;border-bottom:none;">
                        <span class="info-label">Hari Berlalu</span>
                        <span class="info-value" style="color:{{ $daysElapsed > 45 ? 'var(--red)' : ($daysElapsed > 30 ? 'var(--amber)' : 'var(--text)') }}">
                            {{ $daysElapsed }} hari
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action card --}}
        @if($canReview)
            <div class="sec-card">
                <div class="sec-head">
                    <span class="sec-title">Tindakan Semakan</span>
                </div>
                <div class="sec-body">
                    @php
                        $currentStageVal = $application->current_stage->value;
                    @endphp

                    @if($currentStageVal === 'needs_revision')
                        <div style="padding:14px;background:var(--orange-bg);border:1px solid #fed7aa;border-radius:8px;font-size:13px;color:var(--orange);text-align:center;">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" style="margin-bottom:6px;display:block;margin-left:auto;margin-right:auto;">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Menunggu semakan semula daripada pemohon.
                        </div>
                    @elseif(in_array($currentStageVal, ['approved', 'rejected']))
                        <div style="padding:14px;background:var(--surface-2);border:1px solid var(--border);border-radius:8px;font-size:13px;color:var(--text-3);text-align:center;">
                            Permohonan ini telah mendapat keputusan muktamad.
                        </div>
                    @else
                        {{-- Comments textarea (shared across forms via JS) --}}
                        <div style="margin-bottom:14px;">
                            <label class="form-label" for="shared-comments">Ulasan / Catatan</label>
                            <textarea class="form-textarea" id="shared-comments" placeholder="Masukkan ulasan semakan (wajib untuk tindakan tolak/gagal)..." rows="4"></textarea>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:10px;">
                            @if($currentStageVal === 'submitted')
                                {{-- Pass Intake --}}
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="syncComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="passIntake">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-pass" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Pass Intake
                                    </button>
                                </form>
                                {{-- Fail Intake --}}
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="return requireComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="failIntake">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-fail" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        Fail Intake
                                    </button>
                                </form>

                            @elseif($currentStageVal === 'tech_review')
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="syncComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="passTechnical">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-pass" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Lulus Teknikal
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="return requireComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="failTechnical">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-fail" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        Gagal Teknikal
                                    </button>
                                </form>

                            @elseif($currentStageVal === 'label_review')
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="syncComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="passLabel">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-pass" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Lulus Label
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="return requireComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="failLabel">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-fail" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        Gagal Label
                                    </button>
                                </form>

                            @elseif($currentStageVal === 'decision')
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="syncComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="approveFinal">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-final" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Luluskan Final
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('officer.applications.review', $application) }}" onsubmit="return requireComments(this)">
                                    @csrf
                                    <input type="hidden" name="action" value="rejectFinal">
                                    <input type="hidden" name="comments" class="comments-target">
                                    <button type="submit" class="action-btn action-reject" style="width:100%;justify-content:center;">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        Tolak
                                    </button>
                                </form>
                            @endif
                        </div>

                        @if($errors->any())
                            <div style="margin-top:12px;padding:10px 12px;background:#fef2f2;border:1px solid #fecaca;border-radius:6px;font-size:12.5px;color:#b91c1c;">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        {{-- Quick info --}}
        <div class="sec-card" style="margin-top:12px;">
            <div class="sec-head">
                <span class="sec-title">Maklumat Pantas</span>
            </div>
            <div class="sec-body">
                <div class="info-row" style="padding:6px 0;">
                    <span class="info-label">Kategori</span>
                    <span class="info-value" style="font-size:12.5px;">{{ $application->category?->name_ms ?? $application->category?->name ?? '—' }}</span>
                </div>
                <div class="info-row" style="padding:6px 0;">
                    <span class="info-label">Sub-Kategori</span>
                    <span class="info-value" style="font-size:12.5px;">{{ $application->subcategory?->name_ms ?? $application->subcategory?->name ?? '—' }}</span>
                </div>
                <div class="info-row" style="padding:6px 0;">
                    <span class="info-label">Dicipta</span>
                    <span class="info-value" style="font-size:12.5px;">{{ $application->created_at?->format('d M Y') ?? '—' }}</span>
                </div>
                @if($application->decided_at)
                    <div class="info-row" style="padding:6px 0;border-bottom:none;">
                        <span class="info-label">Keputusan</span>
                        <span class="info-value" style="font-size:12.5px;">{{ $application->decided_at->format('d M Y') }}</span>
                    </div>
                @else
                    <div class="info-row" style="padding:6px 0;border-bottom:none;">
                        <span class="info-label">Dokumen</span>
                        <span class="info-value" style="font-size:12.5px;">{{ $application->documents?->count() ?? 0 }} fail</span>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

<script>
function syncComments(form) {
    const comments = document.getElementById('shared-comments').value;
    form.querySelector('.comments-target').value = comments;
}

function requireComments(form) {
    const comments = document.getElementById('shared-comments').value.trim();
    if (!comments) {
        document.getElementById('shared-comments').style.borderColor = 'var(--red)';
        document.getElementById('shared-comments').style.boxShadow = '0 0 0 3px rgba(220,38,38,.12)';
        document.getElementById('shared-comments').focus();
        const hint = document.getElementById('comments-hint');
        if (!hint) {
            const p = document.createElement('p');
            p.id = 'comments-hint';
            p.style.cssText = 'color:var(--red);font-size:12px;margin-top:4px;';
            p.textContent = 'Ulasan wajib diisi untuk tindakan ini.';
            document.getElementById('shared-comments').insertAdjacentElement('afterend', p);
        }
        return false;
    }
    form.querySelector('.comments-target').value = comments;
    return true;
}

document.getElementById('shared-comments')?.addEventListener('input', function() {
    this.style.borderColor = '';
    this.style.boxShadow = '';
    const hint = document.getElementById('comments-hint');
    if (hint) hint.remove();
});
</script>

</x-layouts.officer>
