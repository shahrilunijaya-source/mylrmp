<x-layouts.officer title="Papan Pemuka">

{{-- ═══ LAUNCHER HERO ═══ --}}
<div class="launcher-hero">
    <div class="launcher-hero-left">
        <div class="launcher-eyebrow">Jabatan Pertanian Malaysia</div>
        <div class="launcher-title">Sistem Bersepadu Racun Makhluk Perosak</div>
        <div class="launcher-sub">
            Selamat datang, {{ auth()->user()?->name }} &mdash;
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
</div>

{{-- ═══ MODULE GRID ═══ --}}
<div class="launcher-body">

    <div class="launcher-sec-head">
        <span class="launcher-sec-eye">Modul Sistem</span>
        <div class="launcher-sec-line"></div>
        <span class="launcher-sec-count">12 modul &bull; 3 aktif &bull; 9 dalam pembangunan</span>
    </div>

    <div class="module-grid">

        {{-- 1. e-Cert — LIVE --}}
        <div class="mod-tile live" onclick="window.location='{{ route('officer.applications.index') }}'" style="cursor:pointer;">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">e-Cert</span>
            </div>
            <div class="mod-tile-name">Pendaftaran Produk</div>
            <div class="mod-tile-desc">Permohonan, penilaian teknikal &amp; label, kelulusan dan sijil pendaftaran produk racun perosak.</div>
            <div class="tile-stats">
                <a href="{{ route('officer.applications.index') }}" class="tile-stat amber" onclick="event.stopPropagation()">
                    <div class="tile-stat-n">{{ $pendingCount }}</div>
                    <div class="tile-stat-lbl">Menunggu Tindakan</div>
                </a>
                <a href="{{ route('officer.applications.index') }}" class="tile-stat green" onclick="event.stopPropagation()">
                    <div class="tile-stat-n">{{ $approvedThisMonth }}</div>
                    <div class="tile-stat-lbl">Diluluskan Bulan Ini</div>
                </a>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status live">Aktif</span>
                <div class="mod-tile-arrow">
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </div>
            </div>
        </div>

        {{-- 2. e-Lab (deferred) --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">e-Lab</span>
            </div>
            <div class="mod-tile-name">Makmal</div>
            <div class="mod-tile-desc">Penghantaran sampel piawai dan cerakinan untuk analisis makmal bagi menentusahkan perawis aktif.</div>
            <div class="tile-stats">
                <div class="tile-stat muted"><div class="tile-stat-n">—</div><div class="tile-stat-lbl">Sampel Piawai</div></div>
                <div class="tile-stat muted"><div class="tile-stat-n">—</div><div class="tile-stat-lbl">Sampel Cerakinan</div></div>
            </div>
            <div class="mod-tile-foot"><span class="mod-status soon">Akan Datang</span></div>
        </div>

        {{-- 2b. e-Pemeriksaan — LIVE --}}
        <div class="mod-tile live" onclick="window.location='{{ route('officer.pemeriksaan.index') }}'" style="cursor:pointer;">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">e-Periksa</span>
            </div>
            <div class="mod-tile-name">Pemeriksaan</div>
            <div class="mod-tile-desc">Jadual dan jalankan pemeriksaan premis pengedar &amp; syarikat, senarai semak, penemuan, laporan PDF dan notis ketidakpatuhan.</div>
            <div class="tile-stats">
                <a href="{{ route('officer.pemeriksaan.index', ['status' => 'scheduled']) }}" class="tile-stat amber" onclick="event.stopPropagation()">
                    <div class="tile-stat-n">{{ \App\Models\Inspection::where('status', 'scheduled')->count() }}</div>
                    <div class="tile-stat-lbl">Dijadualkan</div>
                </a>
                <a href="{{ route('officer.pemeriksaan.index', ['status' => 'minor_nc']) }}" class="tile-stat red" onclick="event.stopPropagation()">
                    <div class="tile-stat-n">{{ \App\Models\Inspection::whereIn('status', ['minor_nc', 'major_nc'])->count() }}</div>
                    <div class="tile-stat-lbl">Ketidakpatuhan</div>
                </a>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status live">Aktif</span>
                <div class="mod-tile-arrow">
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </div>
            </div>
        </div>

        {{-- 3. e-Tech --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">e-Tech</span>
            </div>
            <div class="mod-tile-name">Khidmat Teknikal</div>
            <div class="mod-tile-desc">Tambah syor tanaman, tukar kelas toksisiti, lanjutan tarikh luput, tukar pembungkusan dan pemantauan MRL.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Permohonan</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Kelulusan</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 4. e-Label --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">e-Label</span>
            </div>
            <div class="mod-tile-name">Pelabelan Produk</div>
            <div class="mod-tile-desc">Permohonan tambah saiz pek dan tukar label produk racun perosak yang telah berdaftar.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Tambah Pek</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Tukar Label</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 5. e-Iklan --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"/>
                    </svg>
                </div>
                <span class="mod-code">e-Iklan</span>
            </div>
            <div class="mod-tile-name">Pengiklanan</div>
            <div class="mod-tile-desc">Permohonan, pembaharuan dan pemantauan sijil pengiklanan produk racun perosak di Malaysia.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Permohonan Iklan</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Sijil Aktif</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 6. e-Import --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
                    </svg>
                </div>
                <span class="mod-code">e-Import</span>
            </div>
            <div class="mod-tile-name">Pengimportan</div>
            <div class="mod-tile-desc">Permit import R&D, pemantauan, surat sokongan eksport dan pertanyaan perawis aktif.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Permit Import</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Sokongan Eksport</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 7. e-Lesen --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">e-Lesen</span>
            </div>
            <div class="mod-tile-name">Pelesenan</div>
            <div class="mod-tile-desc">Peperiksaan dalam talian, surat kebenaran RMPT, laporan PCO/Fumigan dan lesen PCO/PA/APA.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Calon Peperiksaan</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Lesen Dikeluarkan</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 8. i-Monitoring --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0117.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">i-Monitor</span>
            </div>
            <div class="mod-tile-name">Penguatkuasaan</div>
            <div class="mod-tile-desc">Serbuan, siasatan, pendakwaan, ekshibit, post-registration monitoring dan peta penguatkuasaan.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Kes Serbuan</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Pendakwaan</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 9. i-Services --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">i-Services</span>
            </div>
            <div class="mod-tile-name">Khidmat Awam</div>
            <div class="mod-tile-desc">Bayaran dalam talian, aduan, temujanji, mesyuarat digital, repositori dan direktori BKRPB.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Aduan Diterima</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Temujanji</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 10. Admin — LIVE --}}
        <div class="mod-tile live" onclick="window.location='{{ route('officer.companies.index') }}'" style="cursor:pointer;">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">Admin</span>
            </div>
            <div class="mod-tile-name">Pentadbiran & Pengurusan</div>
            <div class="mod-tile-desc">Syarikat industri, produk berdaftar, pengurusan pengguna, peranan &amp; kawalan akses (ACL) dan audit log.</div>
            <div class="tile-stats">
                <a href="{{ route('officer.companies.index') }}" class="tile-stat navy" onclick="event.stopPropagation()">
                    <div class="tile-stat-n">{{ $companiesCount }}</div>
                    <div class="tile-stat-lbl">Syarikat Industri</div>
                </a>
                <a href="{{ route('officer.users.index') }}" class="tile-stat navy" onclick="event.stopPropagation()">
                    <div class="tile-stat-n">{{ $usersCount }}</div>
                    <div class="tile-stat-lbl">Pengguna Sistem</div>
                </a>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status live">Aktif</span>
                <div class="mod-tile-arrow">
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </div>
            </div>
        </div>

        {{-- 11. Mobile App --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="mod-code">App</span>
            </div>
            <div class="mod-tile-name">Aplikasi Mudah Alih</div>
            <div class="mod-tile-desc">Jejak permohonan, pemantauan lapangan QR, papan pemuka statistik dan kalkulator dos racun.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Pengguna Berdaftar</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Muat Turun</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

        {{-- 12. Portal CMS — no link --}}
        <div class="mod-tile roadmap">
            <div class="mod-tile-top">
                <div class="mod-tile-icon">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                    </svg>
                </div>
                <span class="mod-code">CMS</span>
            </div>
            <div class="mod-tile-name">Portal Content Manager</div>
            <div class="mod-tile-desc">Pengurusan kandungan portal awam — pengumuman, artikel, produk dan data rujukan untuk orang awam.</div>
            <div class="tile-stats">
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Kandungan</div>
                </div>
                <div class="tile-stat muted">
                    <div class="tile-stat-n">—</div>
                    <div class="tile-stat-lbl">Pengguna Portal</div>
                </div>
            </div>
            <div class="mod-tile-foot">
                <span class="mod-status soon">Akan Datang</span>
            </div>
        </div>

    </div>{{-- /.module-grid --}}


</div>{{-- /.launcher-body --}}

</x-layouts.officer>
