<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <head>
        <script>
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
            }
        </script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Zimnat Policy System') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            tailwind.config = {
                darkMode: 'selector',
                theme: {
                    extend: {
                        colors: {
                            zimnat: {
                                blue: '#004a99',
                                'blue-dark': '#002d6b',
                                'blue-light': '#1a6abf',
                                green: '#7fb13b',
                                'green-dark': '#5f8a27',
                            }
                        },
                        fontFamily: {
                            sans: ['Figtree', 'ui-sans-serif', 'system-ui']
                        }
                    }
                }
            }
        </script>
        <style>
            .nav-item { transition: all 200ms ease-in-out; }
            .stat-card { transition: transform 200ms ease, box-shadow 200ms ease; }
            .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
            @keyframes pulse-dot {
                0%, 100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.5; transform: scale(1.4); }
            }
            .pulse-dot { animation: pulse-dot 1.5s ease-in-out infinite; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-950">
        <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">

            <!-- Sidebar overlay (mobile) -->
            <div
                x-show="sidebarOpen"
                @click="sidebarOpen = false"
                class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
                style="display:none;"
                x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>

            <!-- Sidebar -->
            <aside
                :class="[
                    sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                    sidebarCollapsed ? 'lg:w-24' : 'lg:w-72'
                ]"
                class="fixed inset-y-0 left-0 z-50 flex flex-col transition-all duration-300 ease-in-out bg-white dark:bg-gray-900 border-r border-gray-100 dark:border-gray-800 lg:translate-x-0 lg:static lg:inset-0"
                aria-label="Sidebar navigation"
            >
                <!-- Logo Section -->
                <div class="relative flex items-center h-20 px-8 border-b border-gray-50 dark:border-gray-800 flex-shrink-0">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-zimnat-blue flex items-center justify-center flex-shrink-0 shadow-lg shadow-zimnat-blue/20">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L3 7V17L12 22L21 17V7L12 2Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div x-show="!sidebarCollapsed" x-transition class="overflow-hidden whitespace-nowrap">
                            <span class="text-gray-900 dark:text-white font-black text-xl tracking-tight block">Zimnat</span>
                            <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block -mt-1">Policy System</span>
                        </div>
                    </div>
                </div>

                <!-- User Context -->
                <div x-show="!sidebarCollapsed" x-transition class="px-8 py-8">
                    <div class="p-5 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:scale-110 transition-transform">
                            <svg class="w-12 h-12 text-zimnat-blue" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="relative flex flex-col gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-zimnat-blue font-black text-lg shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white font-black text-sm uppercase tracking-tight">{{ Auth::user()->name }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zimnat-green/10 text-[9px] font-black text-zimnat-green uppercase tracking-wider mt-1">
                                    {{ str_replace('_', ' ', Auth::user()->role) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation List -->
                <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group {{ request()->routeIs('dashboard') ? 'bg-gray-50 dark:bg-gray-800 text-zimnat-blue border-l-4 border-zimnat-blue rounded-l-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-zimnat-blue' }}"
                    >
                        <div class="w-5 h-5 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span x-show="!sidebarCollapsed" class="font-black text-[11px] uppercase tracking-widest">Dashboard</span>
                    </a>

                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'policy_officer')
                        <a href="{{ route('policies.index') }}"
                           class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group {{ request()->routeIs('policies.*') ? 'bg-gray-50 dark:bg-gray-800 text-zimnat-blue border-l-4 border-zimnat-blue rounded-l-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-zimnat-blue' }}"
                        >
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <span x-show="!sidebarCollapsed" class="font-black text-[11px] uppercase tracking-widest">Policies</span>
                        </a>

                        <a href="{{ route('queries.index') }}"
                           class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group {{ request()->routeIs('queries.*') ? 'bg-gray-50 dark:bg-gray-800 text-zimnat-blue border-l-4 border-zimnat-blue rounded-l-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-zimnat-blue' }}"
                        >
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            </div>
                            <span x-show="!sidebarCollapsed" class="font-black text-[11px] uppercase tracking-widest">Queries</span>
                        </a>
                    @endif

                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('users.index') }}"
                           class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all group {{ request()->routeIs('users.*') ? 'bg-gray-50 dark:bg-gray-800 text-zimnat-blue border-l-4 border-zimnat-blue rounded-l-none' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-zimnat-blue' }}"
                        >
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <span x-show="!sidebarCollapsed" class="font-black text-[11px] uppercase tracking-widest">Management</span>
                        </a>
                    @endif
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-6 border-t border-gray-50 dark:border-gray-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-4 px-4 py-4 w-full rounded-2xl text-red-500 hover:bg-red-50 transition-all font-black text-[11px] uppercase tracking-widest group">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span x-show="!sidebarCollapsed">Sign Out</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden min-w-0">

                <!-- Top Navbar -->
                <header class="h-16 flex items-center justify-between px-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 z-10">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg lg:hidden">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6H20M4 12H20M4 18H20"/></svg>
                        </button>
                        <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:flex p-2 text-gray-400 dark:text-gray-500 hover:text-zimnat-blue hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path x-show="!sidebarCollapsed" d="M11 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                                <path x-show="sidebarCollapsed" d="M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 12H9" x-show="!sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 12h12" x-show="sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center">
                        @isset($header)
                            <h2 class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.3em]">{{ $header }}</h2>
                        @endisset
                    </div>

                    <div class="flex items-center gap-5">
                        <button @click="darkMode = !darkMode" class="p-2.5 text-gray-400 hover:text-zimnat-blue hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-400 dark:hover:text-yellow-400 rounded-xl transition-all" :title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </button>
                        <div class="relative hidden sm:block">
                            <button class="p-2.5 text-gray-400 hover:text-zimnat-green hover:bg-gray-50 rounded-xl transition-all relative group">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                <span class="absolute top-2.5 right-2.5 flex h-2 w-2 rounded-full bg-red-500 border-2 border-white shadow-sm"></span>
                            </button>
                        </div>

                        <div x-data="{ userMenu: false }" class="relative">
                            <button @click="userMenu = !userMenu" class="flex items-center gap-3 p-1.5 pr-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all border border-transparent hover:border-gray-100 dark:hover:border-gray-700 shadow-sm hover:shadow-md group">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-zimnat-green font-black text-xs shadow-inner group-hover:bg-white dark:group-hover:bg-gray-700 transition-colors">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-[11px] font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ Auth::user()->name }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest -mt-0.5">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>

                            <div x-show="userMenu" 
                                 x-cloak
                                 @click.away="userMenu = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-800 py-3 z-50 overflow-hidden" 
                            >
                                <div class="px-5 py-3 border-b border-gray-50 dark:border-gray-800 mb-2">
                                    <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] font-bold text-zimnat-green uppercase tracking-widest mt-0.5">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-2.5 text-xs font-black text-gray-600 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-zimnat-blue transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    My Profile
                                </a>
                                <hr class="my-2 border-gray-50 dark:border-gray-800">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full text-left px-5 py-2.5 text-xs font-black text-red-500 uppercase tracking-widest hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-950">
                    <div class="max-w-7xl mx-auto px-8 py-10">
                        @if (session('success'))
                            <div class="mb-8 flex items-center gap-4 px-6 py-4 rounded-xl border-l-4 font-black text-xs uppercase tracking-[0.1em] shadow-sm animate-fade-in" style="background: #f0fdf4; border-color: #7fb13b; color: #166534;" role="alert">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-8 flex items-center gap-4 px-6 py-4 rounded-xl border-l-4 font-black text-xs uppercase tracking-[0.1em] shadow-sm animate-fade-in" style="background: #fef2f2; border-color: #fca5a5; color: #991b1b;" role="alert">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
