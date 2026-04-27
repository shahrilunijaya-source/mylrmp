<x-layouts.industri title="Butiran Permohonan">

{{-- Override main-scroll to flex-1 with no padding so 3-panel takes full height --}}
<style>
  .main-scroll { padding: 0 !important; display: flex !important; flex-direction: column !important; }

  /* Left panel */
  .left-panel {
    width: 220px; min-width: 220px;
    overflow-y: auto;
    padding: 16px 12px;
    border-right: 1px solid var(--border);
    background: #fff;
    display: flex; flex-direction: column; gap: 16px;
  }
  .profile-card {
    display: flex; flex-direction: column; align-items: center;
    padding: 16px 8px 12px; text-align: center;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: var(--radius-md);
  }
  .profile-photo {
    width: 64px; height: 64px; border-radius: 14px;
    background: linear-gradient(135deg, #006837 0%, #2e7d52 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; font-weight: 700; color: #fff; letter-spacing: -1px;
    margin-bottom: 10px;
  }
  .profile-name { font-size: 13px; font-weight: 700; color: var(--text-1); letter-spacing: -0.02em; line-height: 1.3; }
  .profile-role { font-size: 11px; color: var(--text-3); margin-top: 2px; }
  .profile-badges { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; margin-top: 8px; }
  .stage-circles { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
  .stage-circle-card {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: var(--radius-sm); padding: 10px 6px 8px;
    text-align: center; display: flex; flex-direction: column; align-items: center; gap: 4px;
  }
  .donut-wrap { position: relative; width: 52px; height: 52px; }
  .donut-wrap svg { width: 52px; height: 52px; }
  .donut-label {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%,-50%);
    display: flex; flex-direction: column; align-items: center;
  }
  .donut-num { font-size: 13px; font-weight: 700; color: var(--text-1); line-height: 1; }
  .stage-circle-name { font-size: 10px; font-weight: 500; color: var(--text-3); }
  .app-stats { display: flex; flex-direction: column; gap: 6px; }
  .stat-row { display: flex; align-items: center; justify-content: space-between; font-size: 12px; }
  .stat-row-label { color: var(--text-3); }
  .stat-row-value { font-weight: 600; color: var(--text-1); }
  .stat-row-value.green { color: #15803d; }
  .stat-row-value.amber { color: #d97706; }
  .stat-row-value.red   { color: #b91c1c; }
  .mini-chart-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 10px 8px; }
  .mini-chart-title { font-size: 11px; font-weight: 600; color: var(--text-2); margin-bottom: 8px; }
  .mini-chart-val { font-size: 18px; font-weight: 700; color: var(--text-1); letter-spacing: -0.03em; }
  .mini-chart-sub { font-size: 10px; color: #15803d; font-weight: 500; margin-top: 1px; margin-bottom: 8px; }
  .bar-chart { display: flex; align-items: flex-end; gap: 3px; height: 36px; }
  .bar { flex: 1; background: var(--brand-light); border-radius: 2px; transition: background 0.15s; }
  .bar.active { background: var(--brand); }

  /* Center panel */
  .center-panel {
    flex: 1; overflow-y: auto; padding: 20px;
    display: flex; flex-direction: column; gap: 16px;
  }
  .page-header { display: flex; align-items: flex-start; justify-content: space-between; }
  .page-header-left h1 { font-size: 20px; font-weight: 700; color: var(--text-1); letter-spacing: -0.03em; }
  .page-header-left .breadcrumb-inline { font-size: 12px; color: var(--text-4); margin-top: 4px; }
  .page-header-left .breadcrumb-inline span { color: var(--brand); font-weight: 500; }
  .action-row { display: flex; gap: 8px; flex-wrap: wrap; }
  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: var(--radius-sm);
    font-size: 13px; font-weight: 500; cursor: pointer;
    border: none; transition: all 0.12s; text-decoration: none;
  }
  .btn-primary   { background: var(--brand); color: #fff; }
  .btn-primary:hover { background: var(--brand-mid); }
  .btn-secondary { background: #fff; color: var(--text-2); border: 1px solid var(--border); }
  .btn-secondary:hover { background: var(--border-soft); }
  .btn-danger    { background: var(--red-light); color: var(--red); }
  .btn-danger:hover { background: #fca5a5; }
  .applicant-block { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .applicant-card {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: var(--radius-md); padding: 16px; box-shadow: var(--shadow-sm);
  }
  .applicant-card-header {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 14px; padding-bottom: 12px;
    border-bottom: 1px solid var(--border-soft);
  }
  .co-logo {
    width: 44px; height: 44px; border-radius: 10px;
    background: linear-gradient(135deg, #006837, #2e7d52);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 14px; font-weight: 800; flex-shrink: 0;
  }
  .co-name { font-size: 14px; font-weight: 700; color: var(--text-1); letter-spacing: -0.01em; }
  .co-type { font-size: 12px; color: var(--text-3); margin-top: 1px; }
  .info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 5px 0; font-size: 13px;
    border-bottom: 1px solid var(--border-soft);
  }
  .info-row:last-child { border-bottom: none; }
  .info-label { color: var(--text-4); font-weight: 400; }
  .info-value { color: var(--text-1); font-weight: 500; text-align: right; }
  .info-value.mono { font-family: 'SF Mono','Courier New',monospace; font-size: 12px; letter-spacing: 0.02em; }
  .ing-table { width: 100%; border-collapse: collapse; }
  .ing-table th {
    font-size: 11px; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase;
    color: var(--text-4); padding: 6px 10px; border-bottom: 1px solid var(--border); text-align: left;
  }
  .ing-table td {
    font-size: 13px; color: var(--text-2); padding: 9px 10px;
    border-bottom: 1px solid var(--border-soft);
  }
  .ing-table tr:last-child td { border-bottom: none; }
  .ing-table tr:hover td { background: var(--border-soft); }
  .timeline { display: flex; flex-direction: column; gap: 0; }
  .timeline-item { display: flex; gap: 14px; padding: 10px 0; position: relative; }
  .timeline-item::before {
    content: ''; position: absolute; left: 14px; top: 32px;
    width: 2px; height: calc(100% - 8px); background: var(--border);
  }
  .timeline-item:last-child::before { display: none; }
  .timeline-dot {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 12px;
    border: 2px solid var(--border); background: #fff; z-index: 1; margin-top: 2px;
  }
  .timeline-dot.done    { background: var(--brand); border-color: var(--brand); color: #fff; }
  .timeline-dot.active  { background: var(--gold); border-color: var(--gold); color: #fff; }
  .timeline-dot.pending { background: #fff; border-color: var(--border); color: var(--text-4); }
  .timeline-content { flex: 1; }
  .timeline-stage { font-size: 13px; font-weight: 600; color: var(--text-1); }
  .timeline-meta  { font-size: 12px; color: var(--text-4); margin-top: 2px; }
  .timeline-comment {
    font-size: 12px; color: var(--text-3);
    background: var(--border-soft); border-radius: 6px;
    padding: 6px 10px; margin-top: 6px;
    border-left: 3px solid var(--brand);
  }
  .doc-item {
    display: flex; align-items: center; gap: 12px;
    padding: 8px 0; border-bottom: 1px solid var(--border-soft);
    transition: background 0.12s;
  }
  .doc-item:last-child { border-bottom: none; }
  .doc-icon {
    width: 36px; height: 36px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; flex-shrink: 0;
  }
  .doc-icon.pdf  { background: #fee2e2; color: #dc2626; }
  .doc-icon.docx { background: #dbeafe; color: #2563eb; }
  .doc-icon.xlsx { background: #dcfce7; color: #16a34a; }
  .doc-icon.file { background: #f3f4f6; color: #6b7280; }
  .doc-name { font-size: 13px; font-weight: 500; color: var(--text-1); }
  .doc-size { font-size: 11px; color: var(--text-4); margin-top: 1px; }
  .notes-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .note-card { background: var(--border-soft); border-radius: 8px; padding: 10px 12px; font-size: 12px; }
  .note-title { font-weight: 600; color: var(--text-1); font-size: 12px; margin-bottom: 4px; }
  .note-date  { color: var(--text-4); font-size: 11px; margin-bottom: 6px; }
  .note-body  { color: var(--text-2); line-height: 1.5; }

  /* Right panel */
  .right-panel {
    width: 280px; min-width: 280px; overflow-y: auto;
    padding: 16px 14px; border-left: 1px solid var(--border);
    background: #fff; display: flex; flex-direction: column; gap: 16px;
  }
  .calendar-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px; }
  .cal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .cal-month { font-size: 13px; font-weight: 600; color: var(--text-1); }
  .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
  .cal-day-header { font-size: 10px; font-weight: 500; color: var(--text-4); text-align: center; padding: 3px 0; }
  .cal-day {
    font-size: 11px; color: var(--text-3);
    text-align: center; padding: 4px 2px; border-radius: 6px;
    cursor: pointer; position: relative;
  }
  .cal-day:hover { background: var(--border-soft); }
  .cal-day.today { background: var(--brand); color: #fff; font-weight: 600; }
  .cal-day.has-event::after {
    content: ''; position: absolute; bottom: 1px; left: 50%;
    transform: translateX(-50%); width: 3px; height: 3px;
    border-radius: 50%; background: var(--brand);
  }
  .cal-day.today.has-event::after { background: #fff; }
  .cal-day.other { color: var(--text-4); opacity: 0.5; }
  .attend-row { display: flex; gap: 6px; margin-top: 10px; }
  .attend-chip { flex: 1; text-align: center; background: var(--border-soft); border-radius: 6px; padding: 6px 4px; }
  .attend-chip-val { font-size: 14px; font-weight: 700; color: var(--text-1); }
  .attend-chip-lbl { font-size: 9px; color: var(--text-4); font-weight: 500; margin-top: 1px; }
  .attend-chip.present .attend-chip-val { color: var(--brand); }
  .attend-chip.late    .attend-chip-val { color: var(--gold); }
  .attend-chip.leave   .attend-chip-val { color: var(--blue); }
  .attend-chip.absent  .attend-chip-val { color: var(--red); }
  .review-table { width: 100%; border-collapse: collapse; }
  .review-table tr { border-bottom: 1px solid var(--border-soft); }
  .review-table tr:last-child { border-bottom: none; }
  .review-table td { padding: 7px 4px; font-size: 12px; }
  .review-table .rlabel { color: var(--text-4); }
  .review-table .rvalue { color: var(--text-1); font-weight: 500; text-align: right; }
  .progress-item { margin-bottom: 10px; }
  .progress-header { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px; }
  .progress-name { color: var(--text-2); font-weight: 500; }
  .progress-val  { color: var(--text-3); }
  .progress-track { height: 6px; background: var(--border-soft); border-radius: 9999px; overflow: hidden; }
  .progress-fill  { height: 100%; border-radius: 9999px; background: var(--brand); transition: width 0.6s ease; }
  .progress-fill.gold { background: var(--gold); }
  .progress-fill.red  { background: var(--red); }
</style>

@php
    // Stage determination helpers
    $reviews      = $application->reviews;
    $currentStage = $application->current_stage;

    // Pra-Semak: done if any review with stage=submitted exists
    $praSelesai = $reviews->contains('stage', \App\Enums\ApplicationStage::Submitted);

    // Teknikal: done if approved review with tech_review stage exists, active if current=tech_review
    $teknikalSelesai = $reviews->where('stage', \App\Enums\ApplicationStage::TechReview)
        ->where('decision', \App\Enums\ApplicationDecision::Approved)->isNotEmpty();
    $teknikalAktif = $currentStage === \App\Enums\ApplicationStage::TechReview && !$teknikalSelesai;

    // Label: done if approved label_review exists, active if current=label_review
    $labelSelesai = $reviews->where('stage', \App\Enums\ApplicationStage::LabelReview)
        ->where('decision', \App\Enums\ApplicationDecision::Approved)->isNotEmpty();
    $labelAktif = $currentStage === \App\Enums\ApplicationStage::LabelReview && !$labelSelesai;

    // Keputusan
    $keputusanSelesai = $currentStage === \App\Enums\ApplicationStage::Approved;
    $keputusanTolak   = $currentStage === \App\Enums\ApplicationStage::Rejected;

    // Progress percentage for right panel
    $progressPct = match($currentStage) {
        \App\Enums\ApplicationStage::Submitted,
        \App\Enums\ApplicationStage::NeedsRevision => 20,
        \App\Enums\ApplicationStage::TechReview    => 40,
        \App\Enums\ApplicationStage::LabelReview   => 60,
        \App\Enums\ApplicationStage::Decision      => 80,
        \App\Enums\ApplicationStage::Approved,
        \App\Enums\ApplicationStage::Rejected      => 100,
        default                                    => 10,
    };

    // Company stats
    $companyTotal    = \App\Models\RegistrationApplication::where('applicant_company_id', $application->applicant_company_id)->count();
    $companyApproved = \App\Models\RegistrationApplication::where('applicant_company_id', $application->applicant_company_id)->where('current_stage', \App\Enums\ApplicationStage::Approved)->count();
    $companyInProc   = \App\Models\RegistrationApplication::where('applicant_company_id', $application->applicant_company_id)->whereIn('current_stage', [\App\Enums\ApplicationStage::TechReview, \App\Enums\ApplicationStage::LabelReview, \App\Enums\ApplicationStage::Decision, \App\Enums\ApplicationStage::Submitted])->count();
    $companyRejected = \App\Models\RegistrationApplication::where('applicant_company_id', $application->applicant_company_id)->where('current_stage', \App\Enums\ApplicationStage::Rejected)->count();

    // Company initials
    $companyName     = $application->company?->name ?? 'Syarikat';
    $companyInitials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', $companyName), 0, 2)));

    // Status badge chip class
    $chipClass = match($currentStage->color()) {
        'success' => 'chip-green',
        'danger'  => 'chip-red',
        'warning' => 'chip-amber',
        'info'    => 'chip-blue',
        'primary' => 'chip-brand',
        default   => 'chip-gray',
    };

    // SLA
    $submittedAt   = $application->submitted_at;
    $daysElapsed   = $submittedAt ? (int) $submittedAt->diffInDays(now()) : 0;
    $slaTarget     = 60;
    $slaRemaining  = max(0, $slaTarget - $daysElapsed);

    // Calendar: highlight submitted month
    $calYear  = $submittedAt ? $submittedAt->year  : now()->year;
    $calMonth = $submittedAt ? $submittedAt->month : now()->month;
    $calDay   = $submittedAt ? $submittedAt->day   : null;
    $calMonthName = \Carbon\Carbon::create($calYear, $calMonth)->translatedFormat('F Y');
    $firstDayOfWeek = \Carbon\Carbon::create($calYear, $calMonth, 1)->dayOfWeek; // 0=Sun
    $daysInMonth = \Carbon\Carbon::create($calYear, $calMonth)->daysInMonth;
@endphp

<div style="display:flex;height:100%;overflow:hidden;">

    {{-- ═══ LEFT PANEL ═══ --}}
    <div class="left-panel">

        {{-- Profile card --}}
        <div class="profile-card">
            <div class="profile-photo">{{ $companyInitials }}</div>
            <div class="profile-name">{{ $companyName }}</div>
            <div class="profile-role">Pemohon Pendaftaran</div>
            <div class="profile-badges">
                <span class="chip chip-brand">{{ $application->application_no }}</span>
                <span class="chip {{ $chipClass }}">{{ $currentStage->label() }}</span>
            </div>
        </div>

        {{-- Stage circles --}}
        <div style="font-size:11px;font-weight:600;color:var(--text-4);text-transform:uppercase;letter-spacing:0.06em;">Peringkat</div>
        <div class="stage-circles">
            {{-- Pra-Semak --}}
            <div class="stage-circle-card">
                <div class="donut-wrap">
                    <svg viewBox="0 0 52 52">
                        <circle cx="26" cy="26" r="21" fill="none" stroke="#f3f4f6" stroke-width="5"/>
                        @if($praSelesai)
                            <circle cx="26" cy="26" r="21" fill="none" stroke="#006837" stroke-width="5" stroke-dasharray="131.9 131.9" stroke-dashoffset="0" stroke-linecap="round" transform="rotate(-90 26 26)"/>
                        @endif
                    </svg>
                    <div class="donut-label">
                        @if($praSelesai)
                            <span class="donut-num" style="color:#006837">&#10003;</span>
                        @else
                            <span class="donut-num" style="color:#9ca3af">&mdash;</span>
                        @endif
                    </div>
                </div>
                <div class="stage-circle-name">Pra-Semak</div>
            </div>

            {{-- Teknikal --}}
            <div class="stage-circle-card">
                <div class="donut-wrap">
                    <svg viewBox="0 0 52 52">
                        <circle cx="26" cy="26" r="21" fill="none" stroke="#f3f4f6" stroke-width="5"/>
                        @if($teknikalSelesai)
                            <circle cx="26" cy="26" r="21" fill="none" stroke="#006837" stroke-width="5" stroke-dasharray="131.9 131.9" stroke-linecap="round" transform="rotate(-90 26 26)"/>
                        @elseif($teknikalAktif)
                            <circle cx="26" cy="26" r="21" fill="none" stroke="#f59e0b" stroke-width="5" stroke-dasharray="66 131.9" stroke-linecap="round" transform="rotate(-90 26 26)"/>
                        @endif
                    </svg>
                    <div class="donut-label">
                        @if($teknikalSelesai)
                            <span class="donut-num" style="color:#006837">&#10003;</span>
                        @elseif($teknikalAktif)
                            <span class="donut-num" style="color:#d97706">50%</span>
                        @else
                            <span class="donut-num" style="color:#9ca3af">&mdash;</span>
                        @endif
                    </div>
                </div>
                <div class="stage-circle-name">Teknikal</div>
            </div>

            {{-- Label --}}
            <div class="stage-circle-card">
                <div class="donut-wrap">
                    <svg viewBox="0 0 52 52">
                        <circle cx="26" cy="26" r="21" fill="none" stroke="#f3f4f6" stroke-width="5"/>
                        @if($labelSelesai)
                            <circle cx="26" cy="26" r="21" fill="none" stroke="#006837" stroke-width="5" stroke-dasharray="131.9 131.9" stroke-linecap="round" transform="rotate(-90 26 26)"/>
                        @elseif($labelAktif)
                            <circle cx="26" cy="26" r="21" fill="none" stroke="#f59e0b" stroke-width="5" stroke-dasharray="99 131.9" stroke-linecap="round" transform="rotate(-90 26 26)"/>
                        @endif
                    </svg>
                    <div class="donut-label">
                        @if($labelSelesai)
                            <span class="donut-num" style="color:#006837">&#10003;</span>
                        @elseif($labelAktif)
                            <span class="donut-num" style="color:#d97706">75%</span>
                        @else
                            <span class="donut-num" style="color:#9ca3af">&mdash;</span>
                        @endif
                    </div>
                </div>
                <div class="stage-circle-name">Label</div>
            </div>

            {{-- Keputusan --}}
            <div class="stage-circle-card">
                <div class="donut-wrap">
                    <svg viewBox="0 0 52 52">
                        <circle cx="26" cy="26" r="21" fill="none" stroke="#f3f4f6" stroke-width="5"/>
                        @if($keputusanSelesai)
                            <circle cx="26" cy="26" r="21" fill="none" stroke="#006837" stroke-width="5" stroke-dasharray="131.9 131.9" stroke-linecap="round" transform="rotate(-90 26 26)"/>
                        @elseif($keputusanTolak)
                            <circle cx="26" cy="26" r="21" fill="none" stroke="#ef4444" stroke-width="5" stroke-dasharray="131.9 131.9" stroke-linecap="round" transform="rotate(-90 26 26)"/>
                        @endif
                    </svg>
                    <div class="donut-label">
                        @if($keputusanSelesai)
                            <span class="donut-num" style="color:#006837">&#10003;</span>
                        @elseif($keputusanTolak)
                            <span class="donut-num" style="color:#ef4444">&#10007;</span>
                        @else
                            <span class="donut-num" style="color:#9ca3af">&mdash;</span>
                        @endif
                    </div>
                </div>
                <div class="stage-circle-name">Keputusan</div>
            </div>
        </div>

        {{-- Company stats --}}
        <div class="section-card" style="padding:12px;">
            <div class="section-header" style="margin-bottom:8px;">
                <div class="section-title" style="font-size:12px;">Maklumat Syarikat</div>
            </div>
            <div class="app-stats">
                <div class="stat-row">
                    <span class="stat-row-label">Jumlah Permohonan</span>
                    <span class="stat-row-value">{{ $companyTotal }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-row-label">Diluluskan</span>
                    <span class="stat-row-value green">{{ $companyApproved }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-row-label">Dalam Proses</span>
                    <span class="stat-row-value amber">{{ $companyInProc }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-row-label">Ditolak</span>
                    <span class="stat-row-value red">{{ $companyRejected }}</span>
                </div>
            </div>
        </div>

        {{-- Mini chart (stub) --}}
        <div class="mini-chart-card">
            <div class="mini-chart-title">Aktiviti 7 Hari</div>
            <div class="mini-chart-val">{{ $application->documents->count() }}</div>
            <div class="mini-chart-sub">&#8593; dokumen dimuat naik</div>
            <div class="bar-chart">
                <div class="bar" style="height:40%"></div>
                <div class="bar" style="height:70%"></div>
                <div class="bar" style="height:50%"></div>
                <div class="bar" style="height:90%"></div>
                <div class="bar active" style="height:100%"></div>
                <div class="bar" style="height:60%"></div>
                <div class="bar" style="height:30%"></div>
            </div>
        </div>

    </div>

    {{-- ═══ CENTER PANEL ═══ --}}
    <div class="center-panel">

        {{-- Session flash --}}
        @if(session('success'))
            <div style="padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;color:#15803d;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Page header --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1>Butiran Permohonan</h1>
                <div class="breadcrumb-inline">
                    Papan Pemuka › Permohonan › <span>{{ $application->application_no }}</span>
                </div>
            </div>
            <div class="action-row">
                {{-- Upload document button always available --}}
                <a href="#dokumen" class="btn btn-secondary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13">
                        <path stroke-linecap="round" d="M8 2v8m-4-4l4 4 4-4M2 14h12"/>
                    </svg>
                    Muat Naik
                </a>
                @if($application->current_stage === \App\Enums\ApplicationStage::Approved && $application->certificate)
                    <a href="{{ route('industri.certificates.download', $application->certificate) }}" class="btn btn-primary">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13">
                            <path stroke-linecap="round" d="M8 2v8m-4-4l4 4 4-4M2 14h12"/>
                        </svg>
                        Muat Turun Sijil
                    </a>
                @endif
            </div>
        </div>

        {{-- Applicant + Product block --}}
        <div class="applicant-block">
            {{-- Applicant card --}}
            <div class="applicant-card">
                <div class="applicant-card-header">
                    <div class="co-logo">{{ $companyInitials }}</div>
                    <div style="min-width:0;flex:1">
                        <div class="co-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $companyName }}</div>
                        <div class="co-type">Pihak Industri</div>
                    </div>
                    <span class="chip chip-green" style="margin-left:auto;flex-shrink:0;">Aktif</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Permohonan</span>
                    <span class="info-value mono">{{ $application->application_no }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kategori</span>
                    <span class="info-value">{{ $application->category?->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sub-Kategori</span>
                    <span class="info-value">{{ $application->subcategory?->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tarikh Hantar</span>
                    <span class="info-value">{{ $application->submitted_at?->format('d M Y') ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="chip {{ $chipClass }}">{{ $currentStage->label() }}</span>
                </div>
            </div>

            {{-- Product card --}}
            <div class="applicant-card">
                <div class="applicant-card-header">
                    <div class="co-logo" style="background:linear-gradient(135deg,#0d9488,#2dd4bf);font-size:11px;">PRD</div>
                    <div style="min-width:0;flex:1">
                        <div class="co-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $application->product?->name ?? 'Tiada Produk' }}</div>
                        <div class="co-type">{{ $application->category?->name ?? '' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <span class="info-label">Kategori</span>
                    <span class="info-value">{{ $application->category?->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sub-Kategori</span>
                    <span class="info-value">{{ $application->subcategory?->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Formulasi</span>
                    <span class="info-value">{{ $application->product?->formulationType?->name_ms ?? '-' }}</span>
                </div>
                @if($application->decided_at)
                    <div class="info-row">
                        <span class="info-label">Tarikh Keputusan</span>
                        <span class="info-value">{{ $application->decided_at->format('d M Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Active ingredients --}}
        @if($application->product?->activeIngredients?->isNotEmpty())
            <div class="section-card">
                <div class="section-header">
                    <div class="section-title">Perawis Aktif</div>
                    <div style="font-size:12px;color:var(--text-4);">{{ $application->product->activeIngredients->count() }} bahan</div>
                </div>
                <table class="ing-table">
                    <thead>
                        <tr>
                            <th>Nama Perawis</th>
                            <th>No. CAS</th>
                            <th>Kepekatan (%)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($application->product->activeIngredients as $ai)
                            <tr>
                                <td style="font-weight:500">{{ $ai->name }}</td>
                                <td style="font-family:monospace;font-size:12px;color:var(--text-3)">{{ $ai->cas_no ?? '-' }}</td>
                                <td>{{ $ai->pivot->concentration_percent ?? '-' }}</td>
                                <td><span class="chip chip-green">Berdaftar</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Stage timeline --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">Sejarah Peringkat</div>
                <span class="chip {{ $chipClass }}">{{ $currentStage->label() }}</span>
            </div>
            <div class="timeline">
                {{-- Submitted --}}
                <div class="timeline-item">
                    <div class="timeline-dot {{ $application->submitted_at ? 'done' : 'pending' }}">
                        {{ $application->submitted_at ? '✓' : '1' }}
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-stage">Dihantar (Submitted)</div>
                        <div class="timeline-meta">
                            {{ $application->submitted_at?->format('d M Y') ?? 'Belum dihantar' }}
                            @if($application->applicant)
                                &middot; {{ $application->applicant->name }}
                            @endif
                        </div>
                    </div>
                </div>

                @foreach($application->reviews->sortBy('reviewed_at') as $review)
                    @php
                        $isDone   = isset($review->decision) && $review->decision?->value === 'approved';
                        $dotClass = $isDone ? 'done' : ($review->stage === $currentStage ? 'active' : 'pending');
                        $dotLabel = $isDone ? '✓' : ($review->stage === $currentStage ? '⋯' : '');
                    @endphp
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $dotClass }}">{{ $dotLabel }}</div>
                        <div class="timeline-content">
                            <div class="timeline-stage">
                                {{ $review->stage instanceof \App\Enums\ApplicationStage ? $review->stage->label() : $review->stage }}
                                @if($review->decision && $review->decision?->value === 'rejected')
                                    &mdash; <span style="color:var(--red);">Ditolak</span>
                                @elseif($review->stage === $currentStage && !$isDone)
                                    &mdash; <span style="color:var(--gold);">Sedang Dalam Semakan</span>
                                @endif
                            </div>
                            <div class="timeline-meta">
                                {{ $review->reviewed_at?->format('d M Y') ?? '' }}
                                @if($review->reviewer)
                                    &middot; {{ $review->reviewer->name }}
                                @endif
                            </div>
                            @if($review->comments)
                                <div class="timeline-comment">{{ $review->comments }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Final decision if not yet reached --}}
                @if(!in_array($currentStage, [\App\Enums\ApplicationStage::Approved, \App\Enums\ApplicationStage::Rejected]))
                    <div class="timeline-item">
                        <div class="timeline-dot pending">4</div>
                        <div class="timeline-content">
                            <div class="timeline-stage" style="color:var(--text-4);">Keputusan Akhir</div>
                            <div class="timeline-meta" style="color:var(--text-4);">Menunggu siap semakan</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Certificate (if approved) --}}
        @if($application->certificate)
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius-md);padding:16px;box-shadow:var(--shadow-sm);">
                <div class="section-header">
                    <div class="section-title" style="color:#15803d;">Sijil Pendaftaran</div>
                    <span class="chip chip-green">Diluluskan</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Pendaftaran</span>
                    <span class="info-value mono" style="font-weight:700;color:#15803d;">{{ $application->certificate->registration_no }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tarikh Dikeluarkan</span>
                    <span class="info-value">{{ $application->certificate->issued_at?->format('d M Y') ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tarikh Luput</span>
                    <span class="info-value">{{ $application->certificate->expires_at?->format('d M Y') ?? '-' }}</span>
                </div>
                @if($application->certificate->pdf_path)
                    <div style="margin-top:12px;">
                        <a href="{{ route('industri.certificates.download', $application->certificate) }}" class="btn btn-primary">
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13">
                                <path stroke-linecap="round" d="M8 2v8m-4-4l4 4 4-4M2 14h12"/>
                            </svg>
                            Muat Turun Sijil (PDF)
                        </a>
                    </div>
                @endif
            </div>
        @endif

        {{-- Documents --}}
        <div class="section-card" id="dokumen">
            <div class="section-header">
                <div class="section-title">Dokumen Sokongan</div>
                <div style="font-size:12px;color:var(--text-4);">{{ $application->documents->count() }} fail</div>
            </div>

            @if($application->documents->isEmpty())
                <p style="font-size:13px;color:var(--text-4);margin-bottom:16px;">Tiada dokumen dimuat naik lagi.</p>
            @else
                @foreach($application->documents as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc->original_name, PATHINFO_EXTENSION));
                        $iconClass = match($ext) { 'pdf' => 'pdf', 'docx','doc' => 'docx', 'xlsx','xls' => 'xlsx', default => 'file' };
                        $iconLabel = match($ext) { 'pdf' => 'PDF', 'docx','doc' => 'DOC', 'xlsx','xls' => 'XLS', default => strtoupper($ext) };
                    @endphp
                    <div class="doc-item">
                        <div class="doc-icon {{ $iconClass }}">{{ $iconLabel }}</div>
                        <div style="flex:1;min-width:0;">
                            <div class="doc-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $doc->original_name }}</div>
                            <div class="doc-size">{{ $doc->document_type }} &middot; {{ number_format($doc->size / 1024, 1) }} KB</div>
                        </div>
                        <div style="color:var(--text-4);font-size:12px;">&#8595;</div>
                    </div>
                @endforeach
            @endif

            {{-- Upload form --}}
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border-soft);">
                <div style="font-size:13px;font-weight:600;color:var(--text-1);margin-bottom:10px;">Muat Naik Dokumen Baharu</div>
                <form action="{{ route('industri.applications.upload-document', $application) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($errors->has('file') || $errors->has('document_type'))
                        <div style="margin-bottom:8px;padding:8px 10px;background:#fee2e2;border:1px solid #fca5a5;border-radius:6px;font-size:12px;color:#b91c1c;">
                            @foreach($errors->get('file') as $e) <p>{{ $e }}</p> @endforeach
                            @foreach($errors->get('document_type') as $e) <p>{{ $e }}</p> @endforeach
                        </div>
                    @endif
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <div>
                            <label style="display:block;font-size:11px;font-weight:500;color:var(--text-3);margin-bottom:4px;">Jenis Dokumen</label>
                            <select name="document_type" style="width:100%;border:1px solid var(--border);border-radius:6px;padding:7px 10px;font-size:13px;color:var(--text-1);background:#fff;outline:none;">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Label Produk">Label Produk</option>
                                <option value="Data Teknikal">Data Teknikal</option>
                                <option value="Laporan Makmal">Laporan Makmal</option>
                                <option value="Sijil Analisis">Sijil Analisis</option>
                                <option value="Lain-lain">Lain-lain</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block;font-size:11px;font-weight:500;color:var(--text-3);margin-bottom:4px;">Fail (PDF, JPG, PNG, DOCX, XLSX — maks 10MB)</label>
                            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.docx,.xlsx"
                                   style="width:100%;font-size:13px;color:var(--text-2);">
                        </div>
                        <button type="submit" class="btn btn-primary" style="justify-content:center;">
                            Muat Naik
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Notes (review comments) --}}
        @php
            $reviewsWithComments = $application->reviews->filter(fn($r) => !empty($r->comments));
        @endphp
        @if($reviewsWithComments->isNotEmpty())
            <div class="section-card">
                <div class="section-header">
                    <div class="section-title">Nota Semakan</div>
                    <div style="font-size:12px;color:var(--text-4);">{{ $reviewsWithComments->count() }} nota</div>
                </div>
                <div class="notes-grid">
                    @foreach($reviewsWithComments as $review)
                        <div class="note-card">
                            <div class="note-title">{{ $review->stage instanceof \App\Enums\ApplicationStage ? $review->stage->label() : $review->stage }}</div>
                            <div class="note-date">{{ $review->reviewed_at?->format('d M Y') }} &middot; {{ $review->reviewer?->name ?? '-' }}</div>
                            <div class="note-body">{{ $review->comments }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- ═══ RIGHT PANEL ═══ --}}
    <div class="right-panel">

        {{-- Calendar --}}
        <div class="calendar-card">
            <div class="cal-header">
                <div class="cal-month">{{ $calMonthName }}</div>
            </div>
            <div class="cal-grid">
                <div class="cal-day-header">A</div>
                <div class="cal-day-header">I</div>
                <div class="cal-day-header">S</div>
                <div class="cal-day-header">R</div>
                <div class="cal-day-header">K</div>
                <div class="cal-day-header">J</div>
                <div class="cal-day-header">S</div>
                @php
                    // Adjust: 0=Sun, we want 0=Ahad(Sun), so no change needed
                    // PHP dayOfWeek: 0=Sun,1=Mon,...,6=Sat — matches Ahad,Isnin,...,Sabtu
                    for ($blank = 0; $blank < $firstDayOfWeek; $blank++):
                @endphp
                    <div class="cal-day other"></div>
                @php endfor; @endphp

                @for($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $isSubmitted = ($d === $calDay);
                        $classes = $isSubmitted ? 'cal-day today has-event' : 'cal-day';
                    @endphp
                    <div class="{{ $classes }}">{{ $d }}</div>
                @endfor
            </div>
            <div class="attend-row">
                <div class="attend-chip present">
                    <div class="attend-chip-val">{{ $application->documents->count() }}</div>
                    <div class="attend-chip-lbl">Dokumen</div>
                </div>
                <div class="attend-chip late">
                    <div class="attend-chip-val">{{ $application->reviews->count() }}</div>
                    <div class="attend-chip-lbl">Semakan</div>
                </div>
                <div class="attend-chip leave">
                    <div class="attend-chip-val">{{ $reviewsWithComments->count() }}</div>
                    <div class="attend-chip-lbl">Nota</div>
                </div>
                <div class="attend-chip absent">
                    <div class="attend-chip-val">{{ $daysElapsed > $slaTarget ? 1 : 0 }}</div>
                    <div class="attend-chip-lbl">Tertangguh</div>
                </div>
            </div>
        </div>

        {{-- Progress bars --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">Kemajuan Semakan</div>
            </div>
            @php
                $praProgress  = ($praSelesai || $teknikalSelesai || $labelSelesai || $keputusanSelesai) ? 100 : ($currentStage === \App\Enums\ApplicationStage::Submitted ? 50 : 0);
                $techProgress = $teknikalSelesai ? 100 : ($teknikalAktif ? 50 : 0);
                $labelProgress = $labelSelesai ? 100 : ($labelAktif ? 75 : 0);
                $finalProgress = ($keputusanSelesai || $keputusanTolak) ? 100 : ($currentStage === \App\Enums\ApplicationStage::Decision ? 50 : 0);
                $finalColor = $keputusanTolak ? 'red' : '';
                $techColor  = $techProgress === 100 ? '' : 'gold';
                $labelColor = $labelProgress === 100 ? '' : 'gold';
            @endphp
            <div class="progress-item">
                <div class="progress-header">
                    <span class="progress-name">Pra-Semak</span>
                    <span class="progress-val">{{ $praProgress }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width:{{ $praProgress }}%"></div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-header">
                    <span class="progress-name">Penilaian Teknikal</span>
                    <span class="progress-val">{{ $techProgress }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill {{ $techColor }}" style="width:{{ $techProgress }}%"></div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-header">
                    <span class="progress-name">Penilaian Label</span>
                    <span class="progress-val">{{ $labelProgress }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill {{ $labelColor }}" style="width:{{ $labelProgress }}%"></div>
                </div>
            </div>
            <div class="progress-item" style="margin-bottom:0;">
                <div class="progress-header">
                    <span class="progress-name">Keputusan Akhir</span>
                    <span class="progress-val">{{ $finalProgress }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill {{ $finalColor }}" style="width:{{ $finalProgress }}%"></div>
                </div>
            </div>
        </div>

        {{-- Review summary table --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">Ringkasan Semakan</div>
            </div>
            <table class="review-table">
                <tr>
                    <td class="rlabel" colspan="2" style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;color:var(--text-4);padding-bottom:6px;">Pegawai Penilai</td>
                </tr>
                @php
                    $reviewersByStage = $application->reviews->keyBy(fn($r) => $r->stage?->value ?? '');
                    $stageNames = [
                        \App\Enums\ApplicationStage::Submitted->value    => 'Pra-Semak',
                        \App\Enums\ApplicationStage::TechReview->value   => 'Teknikal',
                        \App\Enums\ApplicationStage::LabelReview->value  => 'Label',
                        \App\Enums\ApplicationStage::Decision->value     => 'Keputusan',
                    ];
                @endphp
                @foreach($stageNames as $stageVal => $stageName)
                    @php
                        $r = $reviewersByStage[$stageVal] ?? null;
                    @endphp
                    <tr>
                        <td class="rlabel">{{ $stageName }}</td>
                        <td class="rvalue">{{ $r?->reviewer?->name ?? '—' }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td class="rlabel" colspan="2" style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;color:var(--text-4);padding-top:10px;padding-bottom:6px;">Tempoh</td>
                </tr>
                <tr>
                    <td class="rlabel">Dihantar</td>
                    <td class="rvalue">{{ $application->submitted_at?->format('d M Y') ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="rlabel">Hari Berlalu</td>
                    <td class="rvalue" style="{{ $daysElapsed > 45 ? 'color:#d97706' : '' }}">{{ $daysElapsed }} hari</td>
                </tr>
                <tr>
                    <td class="rlabel">SLA (Sasaran)</td>
                    <td class="rvalue">{{ $slaTarget }} hari</td>
                </tr>
                <tr style="border-top:2px solid var(--border);">
                    <td class="rlabel" style="color:var(--brand);font-weight:700;">Baki SLA</td>
                    <td class="rvalue" style="color:var(--brand);font-weight:700;">{{ $slaRemaining }} hari</td>
                </tr>
            </table>
        </div>

        {{-- Quick actions --}}
        <div style="display:flex;flex-direction:column;gap:8px;">
            <a href="#dokumen" class="btn btn-primary" style="justify-content:center;">
                Muat Naik Dokumen
            </a>
            @if($application->current_stage === \App\Enums\ApplicationStage::Approved && $application->certificate)
                <a href="{{ route('industri.certificates.download', $application->certificate) }}" class="btn btn-secondary" style="justify-content:center;">
                    Muat Turun Sijil
                </a>
            @endif
            <a href="{{ route('industri.applications.index') }}" class="btn btn-secondary" style="justify-content:center;">
                Kembali ke Senarai
            </a>
        </div>

    </div>

</div>

</x-layouts.industri>
