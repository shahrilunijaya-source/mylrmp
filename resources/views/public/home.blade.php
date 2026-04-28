<x-layouts.public title="Laman Utama">

    {{-- Hero section --}}
    <section class="hero-section">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>
        <div class="hero-content" style="max-width: 1280px; margin: 0 auto; padding: 64px 16px 80px; text-align: center;">
            <p style="color: #FFCC00; font-size: 12px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; margin: 0 0 12px;">Portal Rasmi</p>
            <h1 style="color: white; font-size: clamp(28px, 5vw, 48px); font-weight: 700; letter-spacing: -0.03em; line-height: 1.1; margin: 0 0 16px;">
                {{ __('app.home.hero_title') }}
            </h1>
            <p style="color: #86efac; font-size: 18px; font-weight: 400; margin: 0 0 40px; letter-spacing: -0.01em;">{{ __('app.home.hero_subtitle') }}</p>

            {{-- Hero search bar --}}
            <div style="max-width: 600px; margin: 0 auto;">
                <form action="{{ route('products.search') }}" method="GET" style="display: flex; gap: 8px;">
                    <input
                        type="text"
                        name="q"
                        placeholder="{{ __('app.home.search_placeholder') }}"
                        class="search-input"
                        style="flex: 1; background: rgba(255,255,255,0.95); border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);"
                    />
                    <button type="submit"
                            style="padding: 12px 24px; background: #FFCC00; color: #003d20; font-size: 14px; font-weight: 600; border-radius: 10px; border: none; cursor: pointer; white-space: nowrap; box-shadow: 0 4px 20px rgba(0,0,0,0.15); letter-spacing: -0.01em; transition: background 0.15s;"
                            onmouseover="this.style.background='#f5c200'"
                            onmouseout="this.style.background='#FFCC00'">
                        Cari Produk
                    </button>
                </form>
                <p style="color: #86efac; font-size: 12px; margin-top: 10px;">Contoh: Glyphosate, BKRPB-001, Roundup</p>
            </div>

            {{-- Stats strip --}}
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; max-width: 640px; margin: 48px auto 0;">
                <div class="stat-card" style="text-align: center;">
                    <p style="font-size: 30px; font-weight: 700; color: #FFCC00; letter-spacing: -0.03em; margin: 0 0 4px;">{{ number_format($stats['total_registered_products']) }}</p>
                    <p style="color: #86efac; font-size: 12px; font-weight: 400; margin: 0;">Produk Berdaftar Aktif</p>
                </div>
                <div class="stat-card" style="text-align: center;">
                    <p style="font-size: 30px; font-weight: 700; color: #FFCC00; letter-spacing: -0.03em; margin: 0 0 4px;">{{ number_format($stats['total_companies']) }}</p>
                    <p style="color: #86efac; font-size: 12px; font-weight: 400; margin: 0;">Syarikat Berdaftar</p>
                </div>
                <div class="stat-card" style="text-align: center;">
                    <p style="font-size: 30px; font-weight: 700; color: #FFCC00; letter-spacing: -0.03em; margin: 0 0 4px;">{{ number_format($stats['total_applications_this_year']) }}</p>
                    <p style="color: #86efac; font-size: 12px; font-weight: 400; margin: 0;">Permohonan Tahun Ini</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Livewire real-time search --}}
    <section style="max-width: 1280px; margin: 0 auto; padding: 40px 16px;">
        <h2 style="font-size: 20px; font-weight: 600; color: #111827; letter-spacing: -0.02em; margin: 0 0 16px;">Carian Pantas Produk Berdaftar</h2>
        <livewire:public.product-search />
    </section>

    {{-- Feature cards --}}
    <section style="background: white; padding: 56px 0; border-top: 1px solid #f3f4f6; border-bottom: 1px solid #f3f4f6;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 16px;">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 class="section-heading">Perkhidmatan myLRMP</h2>
                <p class="section-subheading">Akses semua perkhidmatan Jabatan Pertanian dalam satu platform</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">

                {{-- Card 1 --}}
                <a href="{{ route('products.search') }}" class="feature-card" style="display: block; padding: 24px; text-decoration: none;">
                    <div style="width: 44px; height: 44px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                        <svg style="width: 22px; height: 22px; color: #006837;" fill="none" stroke="#006837" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 600; color: #111827; letter-spacing: -0.01em; margin: 0 0 8px;">Cari Produk Berdaftar</h3>
                    <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0 0 16px;">Semak status pendaftaran, bahan aktif dan butiran sijil produk racun makhluk perosak.</p>
                    <span style="font-size: 14px; font-weight: 500; color: #006837;">Cari sekarang &rarr;</span>
                </a>

                {{-- Card 2 --}}
                <a href="{{ route('industri.register') }}" class="feature-card" style="display: block; padding: 24px; text-decoration: none;">
                    <div style="width: 44px; height: 44px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                        <svg style="width: 22px; height: 22px;" fill="none" stroke="#006837" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 600; color: #111827; letter-spacing: -0.01em; margin: 0 0 8px;">Mohon Pendaftaran</h3>
                    <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0 0 16px;">Daftarkan syarikat dan mohon pendaftaran produk racun makhluk perosak baharu.</p>
                    <span style="font-size: 14px; font-weight: 500; color: #006837;">Daftar sekarang &rarr;</span>
                </a>

                {{-- Card 3 --}}
                <a href="{{ route('calculator') }}" class="feature-card" style="display: block; padding: 24px; text-decoration: none;">
                    <div style="width: 44px; height: 44px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                        <svg style="width: 22px; height: 22px;" fill="none" stroke="#006837" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 600; color: #111827; letter-spacing: -0.01em; margin: 0 0 8px;">Kalkulator Dos</h3>
                    <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0 0 16px;">Kira jumlah racun yang diperlukan berdasarkan keluasan kawasan dan kadar disyorkan.</p>
                    <span style="font-size: 14px; font-weight: 500; color: #006837;">Kira sekarang &rarr;</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Pautan Berguna --}}
    <section style="max-width: 1280px; margin: 0 auto; padding: 48px 16px;">
        <h2 style="font-size: 20px; font-weight: 600; color: #111827; letter-spacing: -0.02em; margin: 0 0 24px;">Pautan Berguna</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">

            <a href="https://www.doa.gov.my" target="_blank" rel="noopener" class="pautan-link">
                <img src="https://www.google.com/s2/favicons?domain=doa.gov.my&sz=64" alt="DOA" onerror="this.style.display='none'">
                Laman Web DOA
                <svg class="ext-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>

            <a href="https://www.moa.gov.my" target="_blank" rel="noopener" class="pautan-link">
                <img src="https://www.google.com/s2/favicons?domain=moa.gov.my&sz=64" alt="MOA" onerror="this.style.display='none'">
                Kementerian Pertanian
                <svg class="ext-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>

            <a href="https://www.myipo.gov.my" target="_blank" rel="noopener" class="pautan-link">
                <img src="https://www.google.com/s2/favicons?domain=myipo.gov.my&sz=64" alt="MyIPO" onerror="this.style.display='none'">
                MyIPO
                <svg class="ext-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>

            <a href="https://www.ssm.com.my" target="_blank" rel="noopener" class="pautan-link">
                <img src="https://www.google.com/s2/favicons?domain=ssm.com.my&sz=64" alt="SSM" onerror="this.style.display='none'">
                SSM Malaysia
                <svg class="ext-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>

        </div>
    </section>

</x-layouts.public>
