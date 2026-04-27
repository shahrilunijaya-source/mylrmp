<x-layouts.industri>
    <x-slot name="title">Permohonan Saya</x-slot>

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-800">Senarai Permohonan</h2>
        <a href="{{ route('industri.applications.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 hover:bg-green-800 text-white text-sm font-semibold rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Permohonan Baharu
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        @if ($applications->isEmpty())
            <div class="py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-400 text-sm">Tiada permohonan lagi.</p>
                <a href="{{ route('industri.applications.create') }}"
                   class="mt-3 inline-block px-4 py-2 bg-green-700 text-white text-sm font-medium rounded-lg hover:bg-green-800">
                    Mulakan Permohonan Pertama
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-left">
                            <th class="px-5 py-3 font-medium text-gray-600">No. Permohonan</th>
                            <th class="px-5 py-3 font-medium text-gray-600">Nama Produk</th>
                            <th class="px-5 py-3 font-medium text-gray-600">Kategori</th>
                            <th class="px-5 py-3 font-medium text-gray-600">Status</th>
                            <th class="px-5 py-3 font-medium text-gray-600">Tarikh Hantar</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($applications as $app)
                            @php
                                $colorMap = [
                                    'gray'    => 'bg-gray-100 text-gray-700',
                                    'info'    => 'bg-blue-100 text-blue-700',
                                    'warning' => 'bg-yellow-100 text-yellow-700',
                                    'primary' => 'bg-indigo-100 text-indigo-700',
                                    'success' => 'bg-green-100 text-green-700',
                                    'danger'  => 'bg-red-100 text-red-700',
                                ];
                                $color = $colorMap[$app->current_stage->color()] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 font-mono text-xs">{{ $app->application_no }}</td>
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $app->product?->name ?? '-' }}</td>
                                <td class="px-5 py-3 text-gray-500">{{ $app->category?->name ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-full {{ $color }}">
                                        {{ $app->current_stage->label() }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $app->submitted_at?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('industri.applications.show', $app) }}"
                                       class="inline-flex items-center gap-1 text-xs text-green-700 hover:text-green-900 font-medium border border-green-300 px-3 py-1.5 rounded-md hover:bg-green-50 transition-colors">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($applications->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $applications->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.industri>
