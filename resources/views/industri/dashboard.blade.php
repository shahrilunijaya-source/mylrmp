<x-layouts.industri>
    <x-slot name="title">Dashboard</x-slot>

    {{-- Session messages --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stat tiles --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Jumlah Permohonan</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-xs font-medium text-yellow-600 uppercase tracking-wide">Dalam Proses</p>
            <p class="mt-2 text-3xl font-bold text-yellow-600">{{ $pending + $inReview }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-xs font-medium text-green-600 uppercase tracking-wide">Diluluskan</p>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ $approved }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-xs font-medium text-red-600 uppercase tracking-wide">Ditolak</p>
            <p class="mt-2 text-3xl font-bold text-red-600">{{ $rejected }}</p>
        </div>
    </div>

    {{-- Recent applications --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Permohonan Terkini</h2>
            <a href="{{ route('industri.applications.index') }}"
               class="text-sm text-green-700 hover:text-green-900 font-medium">
                Lihat Semua
            </a>
        </div>

        @if ($recentApplications->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="text-gray-400 text-sm">Tiada permohonan lagi.</p>
                <a href="{{ route('industri.applications.create') }}"
                   class="mt-3 inline-block px-4 py-2 bg-green-700 text-white text-sm font-medium rounded-lg hover:bg-green-800">
                    Buat Permohonan Baharu
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-5 py-3 font-medium text-gray-600">No. Permohonan</th>
                            <th class="px-5 py-3 font-medium text-gray-600">Produk</th>
                            <th class="px-5 py-3 font-medium text-gray-600">Status</th>
                            <th class="px-5 py-3 font-medium text-gray-600">Tarikh</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recentApplications as $app)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 font-mono text-xs">{{ $app->application_no }}</td>
                                <td class="px-5 py-3">{{ $app->product?->name ?? '-' }}</td>
                                <td class="px-5 py-3">
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
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-full {{ $color }}">
                                        {{ $app->current_stage->label() }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $app->submitted_at?->format('d/m/Y') ?? $app->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('industri.applications.show', $app) }}"
                                       class="text-green-700 hover:text-green-900 text-xs font-medium">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.industri>
