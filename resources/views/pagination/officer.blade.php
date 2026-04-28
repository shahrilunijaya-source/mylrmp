@if ($paginator->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border);background:var(--surface-2);font-size:12.5px;flex-wrap:wrap;gap:10px;">

    {{-- Info text --}}
    <span style="color:var(--text-4);">
        Memaparkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} daripada {{ $paginator->total() }} rekod
    </span>

    {{-- Page buttons --}}
    <div style="display:flex;align-items:center;gap:4px;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="min-width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid var(--border);color:var(--text-4);font-size:13px;cursor:default;background:var(--surface-2);">
                ‹
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="min-width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid var(--border);color:var(--text-3);font-size:13px;text-decoration:none;background:#fff;transition:background .1s,border-color .1s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='#fff'">
                ‹
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="min-width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;font-size:13px;color:var(--text-4);">…</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="min-width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid var(--navy);background:var(--navy);color:#fff;font-size:13px;font-weight:600;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="min-width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid var(--border);color:var(--text-3);font-size:13px;text-decoration:none;background:#fff;transition:background .1s,border-color .1s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='#fff'">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="min-width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid var(--border);color:var(--text-3);font-size:13px;text-decoration:none;background:#fff;transition:background .1s,border-color .1s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='#fff'">
                ›
            </a>
        @else
            <span style="min-width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid var(--border);color:var(--text-4);font-size:13px;cursor:default;background:var(--surface-2);">
                ›
            </span>
        @endif

    </div>
</div>
@endif
