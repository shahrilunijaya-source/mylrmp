<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'myLRMP' }} | Jabatan Pertanian Malaysia</title>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    doa: { 50:'#f0fdf4', 100:'#dcfce7', 500:'#006837', 600:'#005a2f', 700:'#004d28', 800:'#003d20', 900:'#002d18' },
                    gold: { 400:'#FFCC00', 500:'#f5c200' }
                }
            }
        }
    }
    </script>
    <meta name="description" content="Sistem Bersepadu Racun Makhluk Perosak (myLRMP) - Portal rasmi pendaftaran dan pengurusan racun makhluk perosak Jabatan Pertanian Malaysia">
    <meta property="og:title" content="myLRMP - Jabatan Pertanian Malaysia">
    <meta property="og:type" content="website">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .doa-hero-bg { background: linear-gradient(135deg, #006837 0%, #004d28 60%, #003d20 100%); }
        .doa-card { border-left: 4px solid #006837; }
        .stage-badge { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans antialiased">

{{-- Top gov strip --}}
<div class="h-0.5 bg-red-600 w-full"></div>
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
        {{-- Gov logo + name --}}
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-doa-500 flex items-center justify-center flex-shrink-0">
                <span class="text-white font-black text-xs">JPM</span>
            </div>
            <div class="leading-tight">
                <p class="font-bold text-doa-700 text-sm tracking-wide uppercase">Jabatan Pertanian Malaysia</p>
                <p class="text-xs text-gray-500">Kementerian Pertanian &amp; Keterjaminan Makanan</p>
            </div>
        </div>
        {{-- Language toggle --}}
        <div class="flex items-center gap-2 text-xs">
            <a href="{{ route('lang.switch', 'ms') }}"
               class="{{ app()->getLocale() === 'ms' ? 'font-semibold text-doa-600 border-b-2 border-doa-500 pb-0.5' : 'text-gray-500 hover:text-doa-600 transition-colors' }}">BM</a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('lang.switch', 'en') }}"
               class="{{ app()->getLocale() === 'en' ? 'font-semibold text-doa-600 border-b-2 border-doa-500 pb-0.5' : 'text-gray-500 hover:text-doa-600 transition-colors' }}">EN</a>
        </div>
    </div>
</div>

{{-- Main navigation --}}
<nav class="bg-doa-700 shadow-lg" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-14">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gold-400 rounded flex items-center justify-center flex-shrink-0">
                    <span class="text-doa-800 font-black text-xs">ML</span>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">myLRMP</span>
            </a>

            {{-- Desktop nav links --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3 py-2 rounded text-sm font-medium transition-colors
                          {{ request()->routeIs('home') ? 'bg-doa-500 text-white' : 'text-green-100 hover:bg-doa-600 hover:text-white' }}">
                    {{ __('app.nav.home') }}
                </a>
                <a href="{{ route('products.search') }}"
                   class="px-3 py-2 rounded text-sm font-medium transition-colors
                          {{ request()->routeIs('products.*') ? 'bg-doa-500 text-white' : 'text-green-100 hover:bg-doa-600 hover:text-white' }}">
                    {{ __('app.nav.search') }}
                </a>
                <a href="{{ route('calculator') }}"
                   class="px-3 py-2 rounded text-sm font-medium transition-colors
                          {{ request()->routeIs('calculator') ? 'bg-doa-500 text-white' : 'text-green-100 hover:bg-doa-600 hover:text-white' }}">
                    {{ __('app.nav.calculator') }}
                </a>
                <a href="#hubungi"
                   class="px-3 py-2 rounded text-sm font-medium text-green-100 hover:bg-doa-600 hover:text-white transition-colors">
                    {{ __('app.nav.contact') }}
                </a>
                <a href="{{ route('industri.login') }}"
                   class="ml-3 px-4 py-1.5 rounded bg-gold-400 text-doa-800 text-sm font-semibold hover:bg-gold-500 transition-colors">
                    Log Masuk
                </a>
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open" class="md:hidden text-white p-2 rounded hover:bg-doa-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-cloak class="md:hidden pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded text-sm font-medium text-green-100 hover:bg-doa-600">{{ __('app.nav.home') }}</a>
            <a href="{{ route('products.search') }}" class="block px-3 py-2 rounded text-sm font-medium text-green-100 hover:bg-doa-600">{{ __('app.nav.search') }}</a>
            <a href="{{ route('calculator') }}" class="block px-3 py-2 rounded text-sm font-medium text-green-100 hover:bg-doa-600">{{ __('app.nav.calculator') }}</a>
            <a href="#hubungi" class="block px-3 py-2 rounded text-sm font-medium text-green-100 hover:bg-doa-600">{{ __('app.nav.contact') }}</a>
            <a href="{{ route('industri.login') }}" class="block px-3 py-2 rounded text-sm font-medium text-green-100 hover:bg-doa-600">Log Masuk</a>
        </div>
    </div>
</nav>

{{-- Page content --}}
<main>
    {{ $slot }}
</main>

{{-- Footer --}}
<footer class="bg-doa-800 text-white mt-12" id="hubungi">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-gold-400 rounded flex items-center justify-center">
                        <span class="text-doa-800 font-black text-xs">ML</span>
                    </div>
                    <span class="font-bold text-lg">myLRMP</span>
                </div>
                <p class="text-green-200 text-sm leading-relaxed">
                    Sistem Bersepadu Racun Makhluk Perosak (myLRMP)<br>
                    Jabatan Pertanian Malaysia
                </p>
            </div>
            {{-- Links --}}
            <div>
                <h4 class="font-semibold text-green-100 mb-3 uppercase text-xs tracking-wider">Pautan</h4>
                <ul class="space-y-1.5 text-sm">
                    <li><a href="#" class="text-green-300 hover:text-white transition-colors">Dasar Privasi</a></li>
                    <li><a href="#" class="text-green-300 hover:text-white transition-colors">Penafian</a></li>
                    <li><a href="#" class="text-green-300 hover:text-white transition-colors">Peta Laman</a></li>
                </ul>
            </div>
            {{-- Contact --}}
            <div>
                <h4 class="font-semibold text-green-100 mb-3 uppercase text-xs tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-1.5 text-sm text-green-300">
                    <li>Bahagian Kawalan Racun Makhluk Perosak</li>
                    <li>Jabatan Pertanian Malaysia</li>
                    <li>Putrajaya, Malaysia</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-doa-700 mt-8 pt-6 text-center space-y-1">
            <p class="text-green-300 text-sm">&copy; 2026 Jabatan Pertanian Malaysia. {{ __('app.footer.rights') }}</p>
            <p class="text-green-400 text-xs">{{ __('app.footer.act') }}</p>
        </div>
    </div>
</footer>

@livewireScripts
</body>
</html>
