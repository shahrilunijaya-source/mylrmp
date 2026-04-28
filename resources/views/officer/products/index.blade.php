<x-layouts.officer title="Produk Berdaftar">

    {{-- Page heading --}}
    <div class="pg-head">
        <div>
            <div class="pg-title">Produk Berdaftar</div>
            <div class="pg-sub">
                {{ $products->total() }} produk
                @if($search)
                    &nbsp;·&nbsp; Carian: <strong>"{{ $search }}"</strong>
                @endif
            </div>
        </div>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('officer.products.index') }}" style="margin-bottom:20px;display:flex;align-items:center;gap:8px;">
        <div style="display:flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--border);border-radius:6px;padding:7px 12px;flex:1;max-width:400px;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor" style="color:var(--text-4);flex-shrink:0;">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
            </svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama produk, no. pendaftaran, syarikat..."
                   style="border:none;outline:none;font-family:var(--font);font-size:13px;color:var(--text);background:none;width:100%;">
        </div>
        <button type="submit" class="btn-navy" style="padding:8px 14px;font-size:13px;">Cari</button>
        @if($search)
            <a href="{{ route('officer.products.index') }}" class="btn-ghost">Kosongkan</a>
        @endif
    </form>

    <div class="card">
        <div class="card-head">
            <span class="card-title">Senarai Produk</span>
            <span class="card-meta">{{ $products->total() }} rekod</span>
        </div>

        @if($products->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="empty-title">Tiada produk dijumpai</div>
                <div class="empty-sub">
                    @if($search)
                        Cuba carian lain atau kosongkan penapis.
                    @else
                        Tiada produk berdaftar dalam sistem.
                    @endif
                </div>
                @if($search)
                    <a href="{{ route('officer.products.index') }}" class="btn-ghost">Paparkan Semua</a>
                @endif
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Produk</th>
                            <th>Formulasi</th>
                            <th>Pendaftar</th>
                            <th>Bahan Aktif</th>
                            <th>Status</th>
                            <th>Tarikh Luput</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php
                                $statusEnum  = $product->status instanceof \App\Enums\ProductStatus
                                    ? $product->status
                                    : \App\Enums\ProductStatus::Active;
                                $status      = $statusEnum->value;
                                $statusLabel = $statusEnum->label();
                                $stClass = match($status) {
                                    'active'    => 'st-ok',
                                    'expired'   => 'st-rev',
                                    'cancelled' => 'st-rej',
                                    'pending'   => 'st-drf',
                                    default     => 'st-drf',
                                };

                                // Active ingredients: show up to 2, then "+N more"
                                $ingredients = $product->activeIngredients ?? collect();
                                $ingCount    = $ingredients->count();
                                $ingDisplay  = $ingredients->take(2)->pluck('name')->implode(', ');
                                $ingMore     = $ingCount > 2 ? ' +'.($ingCount - 2).' lagi' : '';
                            @endphp
                            <tr>
                                <td>
                                    <span class="app-chip">{{ $product->registration_no ?? '—' }}</span>
                                </td>
                                <td>
                                    <div class="prod-name">{{ $product->name }}</div>
                                    @if($product->formulationType?->code ?? null)
                                        <div class="prod-ing">{{ $product->formulationType->code }}</div>
                                    @endif
                                </td>
                                <td style="font-size:12.5px;color:var(--text-3);">
                                    {{ $product->formulationType?->code ?? $product->formulationType?->name_ms ?? '—' }}
                                </td>
                                <td style="font-size:13px;color:var(--text-2);">
                                    {{ $product->registrantCompany?->name ?? $product->company?->name ?? '—' }}
                                </td>
                                <td style="font-size:12.5px;color:var(--text-3);">
                                    @if($ingCount > 0)
                                        {{ $ingDisplay }}
                                        @if($ingMore)
                                            <span style="color:var(--text-4);font-size:11.5px;">{{ $ingMore }}</span>
                                        @endif
                                    @else
                                        <span style="color:var(--text-4);">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="st {{ $stClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td style="font-size:12px;color:var(--text-4);white-space:nowrap;">
                                    @if($product->expires_at ?? null)
                                        @php $isExpiringSoon = $product->expires_at->diffInDays(now()) < 30 && $product->expires_at->isFuture(); @endphp
                                        <span style="{{ $isExpiringSoon ? 'color:var(--amber);font-weight:500;' : '' }}">
                                            {{ $product->expires_at->format('d/m/Y') }}
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="pagination">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.officer>
