<x-layouts.officer title="Jadual Pemeriksaan Baharu">

<div class="pg-head">
    <div>
        <div class="pg-title">Jadual Pemeriksaan Baharu</div>
        <div class="pg-sub">Tetapkan tarikh, sasaran dan pemeriksa</div>
    </div>
</div>

@if($errors->any())
    <div style="background:var(--red-bg);border:1px solid #fecaca;border-radius:8px;padding:12px 16px;font-size:13px;color:var(--red);margin-bottom:20px;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('officer.pemeriksaan.store') }}" style="max-width:640px;" id="insp-form">
@csrf

<div class="card" style="margin-bottom:20px;">
    <div class="card-head"><span class="card-title">Butiran Pemeriksaan</span></div>
    <div style="padding:24px;display:grid;gap:18px;">

        <div>
            <label class="form-label">Jenis Sasaran <span style="color:var(--red)">*</span></label>
            <select name="target_type" class="form-select" id="target_type_sel" required onchange="toggleTarget(this.value)">
                <option value="">— Pilih jenis sasaran —</option>
                <option value="premises" @selected(old('target_type', $preTargetType) === 'premises')>Premis (Kedai / Pengedar)</option>
                <option value="company" @selected(old('target_type', $preTargetType) === 'company')>Syarikat (Pengilang / Pemegang Daftar)</option>
            </select>
        </div>

        <div id="target_premises_div" style="display:none;">
            <label class="form-label">Pilih Premis <span style="color:var(--red)">*</span></label>
            <select name="target_id_premises" class="form-select" onchange="document.getElementById('target_id_hidden').value=this.value">
                <option value="">— Pilih Premis —</option>
                @foreach($premises as $p)
                    <option value="{{ $p->id }}" @selected(old('target_id', $preTargetType === 'premises' ? $preTargetId : '') == $p->id)>
                        {{ $p->name }} &mdash; {{ $p->state?->label() ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="target_company_div" style="display:none;">
            <label class="form-label">Pilih Syarikat <span style="color:var(--red)">*</span></label>
            <select name="target_id_company" class="form-select" onchange="document.getElementById('target_id_hidden').value=this.value">
                <option value="">— Pilih Syarikat —</option>
                @foreach($companies as $co)
                    <option value="{{ $co->id }}" @selected(old('target_id', $preTargetType === 'company' ? $preTargetId : '') == $co->id)>{{ $co->name }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="target_id" id="target_id_hidden" value="{{ old('target_id', $preTargetId) }}">

        <div>
            <label class="form-label">Pemeriksa Ditugaskan <span style="color:var(--red)">*</span></label>
            <select name="inspector_id" class="form-select" required>
                <option value="">— Pilih Pegawai —</option>
                @foreach($inspectors as $u)
                    <option value="{{ $u->id }}" @selected(old('inspector_id') == $u->id)>{{ $u->name }} ({{ $u->roles->first()?->name }})</option>
                @endforeach
            </select>
            @error('inspector_id')<div style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="form-label">Tarikh Dijadual <span style="color:var(--red)">*</span></label>
            <input type="date" name="scheduled_for" value="{{ old('scheduled_for') }}" class="form-input" required min="{{ date('Y-m-d') }}">
            @error('scheduled_for')<div style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

    </div>
</div>

<div style="display:flex;gap:10px;">
    <button type="submit" class="btn-navy">Jadualkan Pemeriksaan</button>
    <a href="{{ route('officer.pemeriksaan.index') }}" class="btn-ghost">Batal</a>
</div>

</form>

<script>
function toggleTarget(type) {
    document.getElementById('target_premises_div').style.display = type === 'premises' ? '' : 'none';
    document.getElementById('target_company_div').style.display  = type === 'company'  ? '' : 'none';
}
toggleTarget(document.getElementById('target_type_sel').value);
</script>

</x-layouts.officer>
