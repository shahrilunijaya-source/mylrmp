<div class="fil-back-wrap">
    <a href="{{ route('industri.login') }}" class="fil-back-link">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Portal Industri
    </a>
</div>

<div class="fil-demo-trigger-wrap">
    <button class="fil-demo-trigger" onclick="document.getElementById('fil-demo-modal').showModal()">
        Lihat Akaun Demo
    </button>
</div>

<p class="fil-page-footer">myLRMP &copy; Jabatan Pertanian Malaysia</p>

{{-- Demo modal --}}
<dialog id="fil-demo-modal" class="fil-demo-dialog">
    <div class="fil-demo-modal-head">
        <span class="fil-demo-modal-title">Akaun Demo <span class="fil-demo-badge-pill">Persekitaran Ujian</span></span>
        <button class="fil-demo-close" onclick="document.getElementById('fil-demo-modal').close()">✕</button>
    </div>
    <div class="fil-demo-modal-body">
        <table class="fil-demo-tbl">
            <thead>
                <tr><th>Peranan</th><th>E-mel</th><th>Kata Laluan</th></tr>
            </thead>
            <tbody>
                <tr class="fil-grp-row"><td colspan="3">Pentadbir</td></tr>
                <tr class="fil-demo-row" data-email="admin@doa.gov.my" data-password="Password123!">
                    <td><span class="fil-pill fil-pill-admin">Super Admin</span></td>
                    <td>admin@doa.gov.my</td>
                    <td><span class="fil-pw">Password123!</span></td>
                </tr>

                <tr class="fil-grp-row"><td colspan="3">Pegawai DOA</td></tr>
                <tr class="fil-demo-row" data-email="ahmad.fadzillah@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Pendaftar</span></td><td>ahmad.fadzillah@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="noraini.hassan@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Pendaftar</span></td><td>noraini.hassan@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="zulkifli.osman@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Penilai Teknikal</span></td><td>zulkifli.osman@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="azwani.aziz@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Penilai Teknikal</span></td><td>azwani.aziz@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="hazrul.mahmud@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Penilai Teknikal</span></td><td>hazrul.mahmud@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="faridah.yusuf@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Penilai Label</span></td><td>faridah.yusuf@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="akmal.kamarudin@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Penilai Label</span></td><td>akmal.kamarudin@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="aisyah.ali@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Peg. Pendaftaran</span></td><td>aisyah.ali@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="razif.ibrahim@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Peg. Pendaftaran</span></td><td>razif.ibrahim@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr class="fil-demo-row" data-email="wei.ching@doa.gov.my" data-password="Password123!"><td><span class="fil-pill fil-pill-officer">Peg. Pendaftaran</span></td><td>wei.ching@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
            </tbody>
        </table>
        <div style="padding:.65rem 1.25rem;font-size:.75rem;color:#6b7280;border-top:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;gap:8px;">
            <span>Klik baris untuk isi e-mel secara automatik</span>
            <a href="{{ route('industri.login') }}" style="color:#006837;text-decoration:none;font-weight:500;white-space:nowrap;">Portal Industri →</a>
        </div>
    </div>
</dialog>

<style>
.fil-demo-row { cursor: pointer; transition: background .1s; }
.fil-demo-row:hover td { background: #f0fdf4 !important; }
.fil-demo-row.fil-filled td { background: #dcfce7 !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.fil-demo-row').forEach(function (row) {
        row.addEventListener('click', function () {
            var email    = row.dataset.email;
            var password = row.dataset.password;

            // Find the Livewire login component and set values
            var wireEl = document.querySelector('[wire\\:id]');
            if (wireEl) {
                var wireId = wireEl.getAttribute('wire:id');
                try {
                    Livewire.find(wireId).set('data.email',    email);
                    Livewire.find(wireId).set('data.password', password);
                } catch (e) {
                    // Fallback: native input event for older Livewire builds
                    fillNative(email, password);
                }
            } else {
                fillNative(email, password);
            }

            // Visual feedback on the clicked row
            document.querySelectorAll('.fil-demo-row').forEach(function (r) { r.classList.remove('fil-filled'); });
            row.classList.add('fil-filled');

            // Close modal after short delay so user sees the highlight
            setTimeout(function () {
                document.getElementById('fil-demo-modal').close();
            }, 220);
        });
    });

    function fillNative(email, password) {
        var setter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, 'value').set;
        var emailEl = document.querySelector('input[type="email"]');
        var passEl  = document.querySelector('input[type="password"]');
        if (emailEl) { setter.call(emailEl, email);    emailEl.dispatchEvent(new Event('input', { bubbles: true })); }
        if (passEl)  { setter.call(passEl,  password); passEl.dispatchEvent(new Event('input',  { bubbles: true })); }
    }
});
</script>
