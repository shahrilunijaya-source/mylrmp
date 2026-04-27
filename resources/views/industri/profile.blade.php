<x-layouts.industri>
    <x-slot name="title">Profil Saya</x-slot>

    <div class="max-w-2xl space-y-5">

        {{-- User info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Maklumat Pengguna</h3>
            <dl class="space-y-3 text-sm">
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">Nama</dt>
                    <dd class="col-span-2 font-medium">{{ $user->name }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">E-mel</dt>
                    <dd class="col-span-2">{{ $user->email }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">No. Telefon</dt>
                    <dd class="col-span-2">{{ $user->phone ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">Status</dt>
                    <dd class="col-span-2">
                        @if ($user->is_active)
                            <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-medium">Aktif</span>
                        @else
                            <span class="inline-block px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full font-medium">Tidak Aktif</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Company info --}}
        @if ($company)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Maklumat Syarikat</h3>
                <dl class="space-y-3 text-sm">
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Nama Syarikat</dt>
                        <dd class="col-span-2 font-medium">{{ $company->name }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">No. SSM</dt>
                        <dd class="col-span-2 font-mono">{{ $company->ssm_no }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Alamat</dt>
                        <dd class="col-span-2">{{ $company->address }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Orang Hubungi</dt>
                        <dd class="col-span-2">{{ $company->contact_person }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Telefon Syarikat</dt>
                        <dd class="col-span-2">{{ $company->phone ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Status Syarikat</dt>
                        <dd class="col-span-2">
                            <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                                {{ $company->status->value }}
                            </span>
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Tarikh Daftar</dt>
                        <dd class="col-span-2">{{ $company->registered_at?->format('d/m/Y') ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        @else
            <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-5 text-sm text-yellow-800">
                Akaun anda belum dikaitkan dengan mana-mana syarikat. Sila hubungi pentadbir sistem.
            </div>
        @endif
    </div>
</x-layouts.industri>
