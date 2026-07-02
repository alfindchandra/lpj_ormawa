<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>{{ config('app.name', 'ORMAWA Monitoring') }} - @yield('title', 'Dashboard')</title>
    <link class="rounded-full" rel="icon" type="image/png" href="{{ asset('xlogo.png') }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    [x-cloak] {
        display: none !important;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Smooth Transitions */
    * {
        transition: all 0.3s ease;
    }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white
           transform transition-transform duration-300 ease-in-out
           lg:translate-x-0">

            <div class="flex items-center justify-between h-16 px-6 bg-blue-950">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div>
                        <div class="text-sm font-bold">ORMAWA</div>
                        <div class="text-xs text-blue-300">Sistem Monitoring</div>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-4 bg-blue-800 bg-opacity-50">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-300 rounded-full flex items-center justify-center">
                            <span class="text-blue-900 font-bold text-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-300 truncate">
                            @if(Auth::user()->role === 'admin') Admin Kemahasiswaan
                            @elseif(Auth::user()->role === 'bem') BEM IKIP
                            @elseif(Auth::user()->role === 'hmp') HMP — {{ Auth::user()->ormawa_name }}
                            @elseif(Auth::user()->role === 'ukm') UKM — {{ Auth::user()->ormawa_name }}
                            @else {{ Auth::user()->ormawa_name }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <nav class="px-3 py-4 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 180px);">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('proposals.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 {{ request()->routeIs('proposals.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Proposal Kegiatan
                </a>
                

                <a href="{{ route('activities.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 {{ request()->routeIs('activities.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Monitoring Kegiatan
                </a>

               
                <a href="{{ route('kabinet.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 {{ request()->routeIs('kabinet.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Pengurus Inti
                </a>
                

                <a href="{{ route('archives.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 {{ request()->routeIs('archives.*') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    Arsip Kegiatan
                </a>
                
                <div class="pt-4 pb-2">
                    <div class="border-t border-blue-700"></div>
                </div>

                @if(in_array(Auth::user()->role, ['admin']))
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 {{ request()->routeIs('register') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Kelola Ormawa
                </a>
                @endif

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 {{ request()->routeIs('profile.edit') ? 'bg-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan Akun
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-red-600 text-left">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </nav>
        </aside>

        <div class="flex flex-col min-h-screen lg:ml-64">

            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1 min-w-0 ml-4 lg:ml-0">
                        @if (isset($header))
                        {{ $header }}
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="hidden sm:block relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                                
                                <a href="{{ route('profile.edit') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150">
                                    Pengaturan Akun
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition duration-150">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- ── CONTAINER CONTENT & BREADCRUMBS ── --}}
            <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
                
                {{-- ── LOGIKK GENERATE BREADCRUMBS DINAMIS ── --}}
                @php
                    $segments = request()->segments();
                    $url = '';
                @endphp
                <nav class="flex mb-1 px-4 py-1 text-gray-500 rounded-xl bg-white border border-gray-200/80 shadow-sm w-max max-w-full" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs font-medium tracking-wide">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                                <svg class="w-3.5 h-3.5 me-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                </svg>
                                Beranda
                            </a>
                        </li>
                        @foreach($segments as $index => $segment)
                            @php
                                $url .= '/' . $segment;
                                // Abaikan segmen berupa angka (ID) agar breadcrumbs tetap bersih dan terbaca
                                if (is_numeric($segment) || strlen($segment) > 30) continue;
                                
                                // Pemetaan nama segmen URL ke Bahasa Indonesia yang rapi
                                $replacements = [
                                    'dashboard'  => 'Dashboard',
                                    'proposals'  => 'Proposal Kegiatan',
                                    'create'     => 'Tambah Baru',
                                    'edit'       => 'Edit Data',
                                    'show'       => 'Detail',
                                    'kabinet'    => 'Pengurus Inti',
                                    'activities' => 'Monitoring Kegiatan',
                                    'archives'   => 'Arsip Kegiatan',
                                    'profile'    => 'Pengaturan Akun'
                                ];
                                $label = $replacements[$segment] ?? ucfirst(str_replace('-', ' ', $segment));
                            @endphp
                            <li>
                                <div class="flex items-center">
                                    <svg class="block w-3 h-3 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    @if($index == count($segments) - 1)
                                        <span class="ms-1 text-gray-400 font-bold select-none" aria-current="page">{{ $label }}</span>
                                    @else
                                        <a href="{{ url($url) }}" class="ms-1 text-gray-600 hover:text-blue-600 transition-colors font-medium">{{ $label }}</a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </nav>

                {{-- SLOT CONTENT VIEW HALAMAN --}}
                {{ $slot }}
            </main>

            <footer class="bg-white border-t border-gray-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-500">
                            © {{ date('Y') }} IKIP PGRI Bojonegoro. All rights reserved.
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-6 text-sm text-gray-500">
                            <a href="https://wa.me/622087865215760?text=Saya%20butuh%20bantuan" target="_blank"
                                class="hover:text-gray-700">Bantuan</a>
                            <a href="https://ikippgribojonegoro.ac.id/" class="hover:text-gray-700">Tentang</a>
                            <a href="tel:0353 881046" class="hover:text-gray-700">Kontak</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
            class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"></div>
    </div>

    @stack('scripts')
</body>

</html>