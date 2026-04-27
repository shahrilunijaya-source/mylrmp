<x-layouts.industri>
    <x-slot name="title">Butiran Permohonan</x-slot>

    {{-- Back + header --}}
    <div class="mb-5">
        <a href="{{ route('industri.applications.index') }}"
           class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Senarai
        </a>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $application->application_no }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $application->product?->name ?? 'Tiada nama produk' }}</p>
            </div>
            @php
                $colorMap = [
                    'gray'    => 'bg-gray-100 text-gray-700',
                    'info'    => 'bg-blue-100 text-blue-700',
                    'warning' => 'bg-yellow-100 text-yellow-700',
                    'primary' => 'bg-indigo-100 text-indigo-700',
                    'success' => 'bg-green-100 text-green-700',
                    'danger'  => 'bg-red-100 text-red-700',
                ];
                $color = $colorMap[$application->current_stage->color()] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full flex-shrink-0 {{ $color }}">
                {{ $application->current_stage->label() }}
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- Left column: Application info + stage timeline --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Application details --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Maklumat Permohonan</h3>
                <dl class="space-y-3 text-sm">
                    <div class="grid grid-cols-2 gap-2">
                        <dt class="text-gray-500">No. Permohonan</dt>
                        <dd class="font-mono font-medium">{{ $application->application_no }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <dt class="text-gray-500">Kategori</dt>
                        <dd>{{ $application->category?->name ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <dt class="text-gray-500">Sub-Kategori</dt>
                        <dd>{{ $application->subcategory?->name ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <dt class="text-gray-500">Nama Produk</dt>
                        <dd class="font-medium">{{ $application->product?->name ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <dt class="text-gray-500">Jenis Formulasi</dt>
                        <dd>{{ $application->product?->formulationType?->name_ms ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <dt class="text-gray-500">Tarikh Dihantar</dt>
                        <dd>{{ $application->submitted_at?->format('d/m/Y H:i') ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <dt class="text-gray-500">Keputusan Pada</dt>
                        <dd>{{ $application->decided_at?->format('d/m/Y H:i') ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Active ingredients --}}
            @if ($application->product?->activeIngredients->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">Perawis Aktif</h3>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50">
                                <th class="px-3 py-2 font-medium text-gray-600">Nama</th>
                                <th class="px-3 py-2 font-medium text-gray-600">CAS No.</th>
                                <th class="px-3 py-2 font-medium text-gray-600 text-right">Kepekatan (%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($application->product->activeIngredients as $ai)
                                <tr>
                                    <td class="px-3 py-2">{{ $ai->name }}</td>
                                    <td class="px-3 py-2 text-gray-500 font-mono text-xs">{{ $ai->cas_no ?? '-' }}</td>
                                    <td class="px-3 py-2 text-right">{{ $ai->pivot->concentration_percent ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Stage timeline --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Sejarah Semakan</h3>
                @if ($application->reviews->isEmpty())
                    <p class="text-sm text-gray-400">Tiada rekod semakan lagi.</p>
                @else
                    <ol class="relative border-l border-gray-200 ml-3 space-y-4">
                        @foreach ($application->reviews->sortByDesc('reviewed_at') as $review)
                            <li class="ml-5">
                                <span class="absolute -left-2 flex items-center justify-center w-4 h-4 rounded-full bg-green-100 border border-green-400"></span>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-semibold text-gray-700">{{ $review->stage instanceof \App\Enums\ApplicationStage ? $review->stage->label() : $review->stage }}</span>
                                        <span class="text-xs text-gray-400">{{ $review->reviewed_at?->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if ($review->comments)
                                        <p class="text-sm text-gray-600 mt-1">{{ $review->comments }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">Oleh: {{ $review->reviewer?->name ?? '-' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>

            {{-- Certificate --}}
            @if ($application->certificate)
                <div class="bg-green-50 rounded-xl border border-green-200 p-5">
                    <h3 class="font-semibold text-green-800 mb-3">Sijil Pendaftaran</h3>
                    <dl class="space-y-2 text-sm mb-4">
                        <div class="grid grid-cols-2 gap-2">
                            <dt class="text-green-700">No. Pendaftaran</dt>
                            <dd class="font-mono font-bold text-green-900">{{ $application->certificate->registration_no }}</dd>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <dt class="text-green-700">Tarikh Dikeluarkan</dt>
                            <dd>{{ $application->certificate->issued_at?->format('d/m/Y') ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <dt class="text-green-700">Tarikh Luput</dt>
                            <dd>{{ $application->certificate->expires_at?->format('d/m/Y') ?? '-' }}</dd>
                        </div>
                    </dl>
                    @if ($application->certificate->pdf_path)
                        <a href="{{ route('industri.certificates.download', $application->certificate) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Muat Turun Sijil (PDF)
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- Right column: Documents --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Document list --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Dokumen Sokongan</h3>

                @if ($application->documents->isEmpty())
                    <p class="text-sm text-gray-400 mb-4">Tiada dokumen dimuat naik lagi.</p>
                @else
                    <ul class="space-y-2 mb-4">
                        @foreach ($application->documents as $doc)
                            <li class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 truncate">{{ $doc->original_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $doc->document_type }} &middot; {{ number_format($doc->size / 1024, 1) }} KB</p>
                                </div>
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Upload form --}}
                <form action="{{ route('industri.applications.upload-document', $application) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Muat Naik Dokumen</h4>

                    @if ($errors->has('file') || $errors->has('document_type'))
                        <div class="mb-2 p-2 bg-red-50 border border-red-200 rounded text-xs text-red-700">
                            @foreach ($errors->get('file') as $e) <p>{{ $e }}</p> @endforeach
                            @foreach ($errors->get('document_type') as $e) <p>{{ $e }}</p> @endforeach
                        </div>
                    @endif

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Dokumen</label>
                            <select name="document_type"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Label Produk">Label Produk</option>
                                <option value="Data Teknikal">Data Teknikal</option>
                                <option value="Laporan Makmal">Laporan Makmal</option>
                                <option value="Sijil Analisis">Sijil Analisis</option>
                                <option value="Lain-lain">Lain-lain</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Fail (PDF, JPG, PNG, DOCX, XLSX — maks 10MB)</label>
                            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.docx,.xlsx"
                                   class="w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>
                        <button type="submit"
                                class="w-full py-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium rounded-lg transition-colors">
                            Muat Naik
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.industri>
