<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Syarikat — myLRMP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#006837',
                            600: '#005a2f',
                            700: '#004d28',
                            900: '#052e16',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg">
        {{-- Logo / brand --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-green-700 rounded-full flex items-center justify-center">
                    <span class="text-white font-black text-sm">ML</span>
                </div>
                <span class="text-2xl font-bold text-green-900">myLRMP</span>
            </div>
            <p class="text-sm text-gray-500">Sistem Permohonan Pendaftaran Racun Makhluk Perosak</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <h1 class="text-lg font-bold text-gray-800 mb-1">Pendaftaran Syarikat Baharu</h1>
            <p class="text-sm text-gray-500 mb-5">Buat akaun untuk menghantar permohonan pendaftaran produk.</p>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('industri.register.store') }}" class="space-y-4">
                @csrf

                <div class="border-t border-gray-100 pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Maklumat Syarikat</p>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Syarikat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}"
                                   placeholder="Contoh: Agro Kimia Sdn Bhd"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('company_name') border-red-400 @enderror">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                No. SSM <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="ssm_no" value="{{ old('ssm_no') }}"
                                   placeholder="Contoh: 1234567-X"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('ssm_no') border-red-400 @enderror">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat Syarikat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="2"
                                      placeholder="Alamat penuh syarikat"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('address') border-red-400 @enderror">{{ old('address') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Orang Hubungi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                                       placeholder="Nama penuh"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('contact_person') border-red-400 @enderror">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telefon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       placeholder="mis: 0123456789"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Maklumat Log Masuk</p>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat E-mel <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   placeholder="nama@syarikat.com"
                                   autocomplete="email"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-400 @enderror">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Kata Laluan <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password"
                                   placeholder="Sekurang-kurangnya 8 aksara"
                                   autocomplete="new-password"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-400 @enderror">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Sahkan Kata Laluan <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation"
                                   placeholder="Ulangi kata laluan"
                                   autocomplete="new-password"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg transition-colors text-sm">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-4">
                Sudah ada akaun?
                <a href="{{ route('industri.login') }}" class="text-green-700 hover:text-green-900 font-medium">Log Masuk</a>
            </p>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4">myLRMP &copy; Jabatan Pertanian Malaysia</p>
    </div>

</body>
</html>
