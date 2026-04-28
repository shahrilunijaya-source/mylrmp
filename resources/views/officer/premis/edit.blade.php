<x-layouts.officer title="Sunting Premis">

<div class="pg-head">
    <div>
        <div class="pg-title">Sunting Premis</div>
        <div class="pg-sub">{{ $premis->name }}</div>
    </div>
</div>

<form method="POST" action="{{ route('officer.premis.update', $premis) }}" style="max-width:760px;">
@csrf
@method('PATCH')

<div class="card" style="margin-bottom:20px;">
    <div class="card-head"><span class="card-title">Maklumat Premis</span></div>
    <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:16px;">

        <div style="grid-column:1/-1;">
            <label class="form-label">Nama Premis <span style="color:var(--red)">*</span></label>
            <input type="text" name="name" value="{{ old('name', $premis->name) }}" class="form-input" required>
            @error('name')<div style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="form-label">No. Lesen</label>
            <input type="text" name="license_no" value="{{ old('license_no', $premis->license_no) }}" class="form-input">
            @error('license_no')<div style="font-size:12px;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="form-label">Syarikat Pemilik</label>
            <select name="owner_company_id" class="form-select">
                <option value="">— Tiada —</option>
                @foreach($companies as $co)
                    <option value="{{ $co->id }}" @selected(old('owner_company_id', $premis->owner_company_id) == $co->id)>{{ $co->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="grid-column:1/-1;">
            <label class="form-label">Alamat Baris 1 <span style="color:var(--red)">*</span></label>
            <input type="text" name="address_line1" value="{{ old('address_line1', $premis->address_line1) }}" class="form-input" required>
        </div>

        <div style="grid-column:1/-1;">
            <label class="form-label">Alamat Baris 2</label>
            <input type="text" name="address_line2" value="{{ old('address_line2', $premis->address_line2) }}" class="form-input">
        </div>

        <div>
            <label class="form-label">Poskod</label>
            <input type="text" name="postcode" value="{{ old('postcode', $premis->postcode) }}" class="form-input" maxlength="10">
        </div>

        <div>
            <label class="form-label">Daerah</label>
            <input type="text" name="district" value="{{ old('district', $premis->district) }}" class="form-input">
        </div>

        <div>
            <label class="form-label">Negeri</label>
            <select name="state" class="form-select">
                <option value="">— Pilih Negeri —</option>
                @foreach($states as $s)
                    <option value="{{ $s->value }}" @selected(old('state', $premis->state?->value) === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Nama PIC</label>
            <input type="text" name="pic_name" value="{{ old('pic_name', $premis->pic_name) }}" class="form-input">
        </div>

        <div>
            <label class="form-label">No. Telefon PIC</label>
            <input type="tel" name="pic_phone" value="{{ old('pic_phone', $premis->pic_phone) }}" class="form-input">
        </div>

        <div>
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
                <option value="1" @selected(old('is_active', $premis->is_active ? '1' : '0') === '1')>Aktif</option>
                <option value="0" @selected(old('is_active', $premis->is_active ? '1' : '0') === '0')>Tidak Aktif</option>
            </select>
        </div>

    </div>
</div>

<div style="display:flex;gap:10px;">
    <button type="submit" class="btn-navy">Simpan Perubahan</button>
    <a href="{{ route('officer.premis.show', $premis) }}" class="btn-ghost">Batal</a>
</div>

</form>

</x-layouts.officer>
