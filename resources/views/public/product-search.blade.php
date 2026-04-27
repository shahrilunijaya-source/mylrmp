<x-layouts.public title="Carian Produk">

    {{-- Page header --}}
    <div style="background: linear-gradient(135deg, #006837 0%, #004d28 60%, #003d20 100%); padding: 32px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 16px;">
            <nav style="font-size: 12px; color: #86efac; margin-bottom: 8px;">
                <a href="{{ route('home') }}" style="color: #86efac; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#86efac'">Laman Utama</a>
                <span style="margin: 0 6px; opacity: 0.5;">/</span>
                <span style="color: #d1fae5;">Carian Produk</span>
            </nav>
            <h1 style="color: white; font-size: 26px; font-weight: 700; letter-spacing: -0.02em; margin: 0 0 4px;">Carian Produk Berdaftar</h1>
            <p style="color: #86efac; font-size: 14px; margin: 0;">Semak status pendaftaran produk racun makhluk perosak</p>
        </div>
    </div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 32px 16px;">

        {{-- Search form --}}
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 24px; margin-bottom: 32px;">
            <form action="{{ route('products.search') }}" method="GET">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;" class="grid-cols-1 md:grid-cols-3">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6b7280; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 6px;">Carian</label>
                        <input type="text" name="q" value="{{ $query }}"
                               placeholder="Nama produk, No. Pendaftaran atau Bahan Aktif..."
                               class="search-input"/>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6b7280; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 6px;">Jenis Formulasi</label>
                        <select name="formulation_type_id" class="search-input" style="cursor: pointer;">
                            <option value="">-- Semua --</option>
                            @foreach($formulationTypes as $ft)
                                <option value="{{ $ft->id }}" {{ $formulationTypeId == $ft->id ? 'selected' : '' }}>
                                    {{ $ft->name_ms }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6b7280; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 6px;">Kategori</label>
                        <select name="category_id" class="search-input" style="cursor: pointer;">
                            <option value="">-- Semua --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name_ms }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <button type="submit" class="btn-primary">
                        Cari
                    </button>
                    @if($query || $formulationTypeId || $categoryId)
                        <a href="{{ route('products.search') }}"
                           style="padding: 10px 16px; font-size: 14px; color: #6b7280; text-decoration: none; transition: color 0.15s;"
                           onmouseover="this.style.color='#111827'"
                           onmouseout="this.style.color='#6b7280'">
                            Kosongkan
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Real-time search widget --}}
        <div style="margin-bottom: 32px;">
            <livewire:public.product-search />
        </div>

        {{-- Results --}}
        @if($products->isEmpty())
            <div style="text-align: center; padding: 64px 16px; background: white; border-radius: 12px; border: 1px solid #e5e7eb;">
                <svg style="width: 48px; height: 48px; color: #d1d5db; margin: 0 auto 16px;" fill="none" stroke="#d1d5db" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p style="font-size: 15px; font-weight: 500; color: #6b7280; margin: 0 0 8px;">Tiada rekod dijumpai. Cuba carian lain.</p>
                <a href="{{ route('products.search') }}" style="font-size: 14px; color: #006837; text-decoration: none; font-weight: 500;">Lihat semua produk</a>
            </div>
        @else
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <p style="font-size: 13px; color: #6b7280; margin: 0;">
                    Menunjukkan <span style="font-weight: 600; color: #374151;">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
                    daripada <span style="font-weight: 600; color: #374151;">{{ $products->total() }}</span> rekod
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; margin-bottom: 32px;">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}"
                       style="display: block; background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; text-decoration: none; transition: all 0.2s;"
                       onmouseover="this.style.borderColor='#006837'; this.style.boxShadow='0 4px 16px rgba(0,104,55,0.1)';"
                       onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 10px;">
                            <span style="font-family: 'SF Mono', 'Fira Code', monospace; font-size: 12px; font-weight: 600; color: #006837; background: #f0fdf4; padding: 2px 8px; border-radius: 6px; border: 1px solid #dcfce7;">
                                {{ $product->registration_no }}
                            </span>
                            @php
                                $badgeClass = match($product->status->value) {
                                    'active'    => 'badge-success',
                                    'expired'   => 'badge-warning',
                                    'cancelled' => 'badge-danger',
                                    default     => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $product->status->label() }}
                            </span>
                        </div>
                        <h3 style="font-size: 15px; font-weight: 600; color: #111827; letter-spacing: -0.01em; line-height: 1.4; margin: 0 0 10px;">
                            {{ $product->name }}
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; gap: 8px; font-size: 13px; color: #6b7280;">
                                <span style="width: 72px; flex-shrink: 0; font-weight: 500; color: #9ca3af;">Pendaftar</span>
                                <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $product->registrant?->name ?? '—' }}</span>
                            </div>
                            <div style="display: flex; gap: 8px; font-size: 13px; color: #6b7280;">
                                <span style="width: 72px; flex-shrink: 0; font-weight: 500; color: #9ca3af;">Formulasi</span>
                                <span>{{ $product->formulationType?->name_ms ?? '—' }}</span>
                            </div>
                            @if($product->expires_at)
                                <div style="display: flex; gap: 8px; font-size: 13px; color: #6b7280;">
                                    <span style="width: 72px; flex-shrink: 0; font-weight: 500; color: #9ca3af;">Tamat</span>
                                    <span>{{ $product->expires_at->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div style="display: flex; justify-content: center;">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</x-layouts.public>
