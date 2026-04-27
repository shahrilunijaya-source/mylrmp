<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'myLRMP' }} — Portal Industri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#006837',
                            600: '#005a2f',
                            700: '#004d28',
                            800: '#003f20',
                            900: '#052e16',
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">

<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-green-900 text-white transform transition-transform duration-200 ease-in-out lg:relative lg:translate-x-0 flex flex-col"
    >
        {{-- Brand --}}
        <div class="flex items-center justify-between h-16 px-4 bg-green-950 flex-shrink-0">
            <a href="{{ route('industri.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <span class="text-green-900 font-black text-xs">ML</span>
                </div>
                <span class="font-bold text-lg tracking-tight">myLRMP</span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('industri.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                      {{ request()->routeIs('industri.dashboard') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-800' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('industri.applications.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                      {{ request()->routeIs('industri.applications.*') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-800' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Permohonan Saya
            </a>

            <a href="{{ route('industri.profile') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                      {{ request()->routeIs('industri.profile') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-800' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil
            </a>
        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-green-800 flex-shrink-0">
            <form method="POST" action="{{ route('industri.logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full px-3 py-2 rounded-md text-sm font-medium text-green-100 hover:bg-green-800 transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Log Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" x-cloak></div>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top bar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'Portal Industri' }}</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800">{{ auth()->user()?->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()?->company?->name ?? 'Tiada Syarikat' }}</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-green-700 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t border-gray-200 px-6 py-3 flex-shrink-0">
            <p class="text-xs text-gray-400 text-center">myLRMP &copy; Jabatan Pertanian Malaysia</p>
        </footer>
    </div>
</div>

@livewireScripts
</body>
</html>
