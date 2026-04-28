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
        <span class="fil-demo-modal-title">Akaun Demo <span class="fil-demo-badge-pill">Ujian Sahaja</span></span>
        <button class="fil-demo-close" onclick="document.getElementById('fil-demo-modal').close()">✕</button>
    </div>
    <div class="fil-demo-modal-body">
        <table class="fil-demo-tbl">
            <thead>
                <tr><th>Peranan</th><th>E-mel</th><th>Kata Laluan</th></tr>
            </thead>
            <tbody>
                <tr class="fil-grp-row"><td colspan="3">Pentadbir</td></tr>
                <tr>
                    <td><span class="fil-pill fil-pill-admin">Super Admin</span></td>
                    <td>admin@doa.gov.my</td>
                    <td><span class="fil-pw">Password123!</span></td>
                </tr>

                <tr class="fil-grp-row"><td colspan="3">Pegawai DOA</td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Pendaftar</span></td><td>ahmad.fadzillah@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Pendaftar</span></td><td>noraini.hassan@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Penilai Teknikal</span></td><td>zulkifli.osman@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Penilai Teknikal</span></td><td>azwani.aziz@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Penilai Teknikal</span></td><td>hazrul.mahmud@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Penilai Label</span></td><td>faridah.yusuf@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Penilai Label</span></td><td>akmal.kamarudin@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Peg. Pendaftaran</span></td><td>aisyah.ali@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Peg. Pendaftaran</span></td><td>razif.ibrahim@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
                <tr><td><span class="fil-pill fil-pill-officer">Peg. Pendaftaran</span></td><td>wei.ching@doa.gov.my</td><td><span class="fil-pw">Password123!</span></td></tr>
            </tbody>
        </table>
    </div>
</dialog>
