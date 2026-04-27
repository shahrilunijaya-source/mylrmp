<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk — myLRMP Portal Industri</title>
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

    <div class="w-full max-w-sm">
        {{-- Brand --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-green-700 rounded-full flex items-center justify-center">
                    <span class="text-white font-black text-sm">ML</span>
                </div>
                <span class="text-2xl font-bold text-green-900">myLRMP</span>
            </div>
            <p class="text-sm text-gray-500">Portal Syarikat Industri</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <h1 class="text-lg font-bold text-gray-800 mb-5">Log Masuk</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('industri.login.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-mel</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           autofocus autocomplete="email"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan</label>
                    <input type="password" name="password" autocomplete="current-password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg transition-colors text-sm">
                    Log Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-4">
                Belum ada akaun?
                <a href="{{ route('industri.register') }}" class="text-green-700 hover:text-green-900 font-medium">Daftar Syarikat</a>
            </p>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4">myLRMP &copy; Jabatan Pertanian Malaysia</p>
    </div>

</body>
</html>
