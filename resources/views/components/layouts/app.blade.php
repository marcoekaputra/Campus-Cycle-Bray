<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc] antialiased selection:bg-[#611827] selection:text-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CampusCycle - Marketplace Pre-loved Mahasiswa Untirta' }}</title>

    <link rel="icon" type="image/png" href="/images/campuscycle-logo.png">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            maroon: '#641E28',
                            'maroon-dark': '#4A151D',
                            'maroon-light': '#852835',
                            gold: '#EDAB0F',
                            'gold-dark': '#D97706',
                            'gold-light': '#FBBF24',
                            amber: '#EDAB0F',
                        },
                    },
                    boxShadow: {
                        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 12px 24px -4px rgba(100, 30, 40, 0.12), 0 6px 12px -3px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    @livewireStyles
</head>
<body class="min-h-full flex flex-col justify-between text-slate-800 bg-[#f8fafc]">

    <!-- 1. Top Bar Ringkas (E-Commerce Announcement Bar - Wide) -->
    <div class="bg-[#641E28] text-white text-[11px] py-1.5 border-b border-rose-900/30">
        <div class="w-full px-3 sm:px-8 lg:px-12 xl:px-14 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2 truncate">
                <span class="font-extrabold text-[#EDAB0F] tracking-wide shrink-0">CampusCycle</span>
                <span class="text-rose-200/40 hidden sm:inline">•</span>
                <span class="text-rose-100 font-medium truncate hidden sm:inline">Pusat Jual Beli & Sirkulasi Barang Pre-loved Mahasiswa Untirta</span>
                <span class="text-rose-100 font-medium truncate sm:hidden text-[10px]">Marketplace Mahasiswa Untirta</span>
            </div>
            <div class="flex items-center gap-3 text-rose-100 font-medium text-[10px] sm:text-[11px] shrink-0">
                <span class="hidden md:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#EDAB0F] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Titik COD: Kampus Cilegon (FT) • Sindangsari • Pakupatan • Ciwaru</span>
                </span>
                <span class="hidden md:inline text-rose-200/40">|</span>
                <span class="flex items-center gap-1.5 text-[#EDAB0F] font-bold">
                    <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Mahasiswa Terverifikasi</span>
                </span>
            </div>
        </div>
    </div>

    <!-- 2. Main E-Commerce Navigation Bar (Widescreen Proportional Layout) -->
    <header class="w-full bg-white border-b border-slate-200/90 sticky top-0 z-40 shadow-xs">
        <div class="w-full px-3 sm:px-8 lg:px-12 xl:px-14">
            <div class="h-14 sm:h-20 flex items-center justify-between gap-2 sm:gap-4 lg:gap-8">

                <!-- Logo CampusCycle Horizontal -->
                <a href="/" class="flex items-center shrink-0 group">
                    <img 
                        src="/images/campuscycle-horizontal.png" 
                        alt="CampusCycle Logo" 
                        class="h-8 sm:h-12 lg:h-[48px] w-auto object-contain transition-transform duration-200 group-hover:scale-[1.02]"
                    />
                </a>

                <!-- E-Commerce Search Bar (Desktop) -->
                <div class="flex-1 max-w-2xl lg:max-w-3xl hidden md:block">
                    <form action="/" method="GET" class="relative flex items-center">
                        <div class="relative w-full flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari buku kuliah, jas lab FT, rice cooker, helm K3, monitor, sepeda..."
                                class="w-full pl-11 pr-24 py-2.5 text-xs sm:text-sm bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-[#641E28] rounded-full focus:ring-4 focus:ring-[#641E28]/10 transition-all font-medium text-slate-800 placeholder:text-slate-400 shadow-xs"
                            />
                            <button
                                type="submit"
                                class="absolute right-1.5 px-4 py-1.5 bg-[#641E28] hover:bg-[#4A151D] text-white rounded-full text-xs font-extrabold shadow-xs transition active:scale-95"
                            >
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Action Controls (Standard E-Commerce Right Controls) -->
                <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">

                    <!-- CTA Jual Barang (Golden Button) -->
                    <a
                        href="{{ route('product.create') }}"
                        class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs sm:text-sm font-black text-slate-950 bg-gradient-to-r from-[#EDAB0F] to-[#f59e0b] hover:from-[#d97706] hover:to-[#b45309] hover:text-white shadow-xs transition-all active:scale-95"
                    >
                        <span class="text-base font-black leading-none">+</span>
                        <span>Jual Barang</span>
                    </a>

                    @auth
                        <!-- CampusWallet Saldo Pill -->
                        <a
                            href="{{ route('dashboard') }}"
                            class="hidden lg:flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-300 text-xs font-bold text-slate-700 transition"
                            title="Saldo Dompet Mahasiswa"
                        >
                            <span class="w-5 h-5 rounded-full bg-[#EDAB0F] text-slate-900 flex items-center justify-center text-[10px] font-black shadow-xs">Rp</span>
                            <span class="font-mono text-slate-900 font-extrabold">{{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</span>
                        </a>

                        @if(Auth::user()->isAdmin())
                            <!-- Admin Console Quick Link -->
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-full bg-slate-900 text-[#EDAB0F] hover:bg-black transition text-xs font-black shadow-xs border border-amber-400/40"
                                title="Buka Panel Admin Platform"
                            >
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="hidden sm:inline">Admin</span>
                            </a>
                        @endif

                        <!-- Chat Shortcut Pill -->
                        <a
                            href="{{ route('chat') }}"
                            class="relative p-1.5 sm:p-2 rounded-full text-slate-600 hover:text-[#641E28] hover:bg-rose-50 transition"
                            title="Buka Chat Penjual & Pembeli"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            @php
                                $unreadTotal = Auth::user()->unreadChatCount();
                            @endphp
                            @if($unreadTotal > 0)
                                <span class="absolute top-0 right-0 w-4 h-4 rounded-full bg-[#641E28] text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white">
                                    {{ $unreadTotal }}
                                </span>
                            @endif
                        </a>

                        <!-- User Profile Link -->
                        <a
                            href="{{ route('dashboard') }}"
                            class="flex items-center gap-1.5 sm:gap-2 pl-1.5 pr-2.5 sm:pl-2 sm:pr-3.5 py-1 sm:py-1.5 rounded-full bg-slate-100 hover:bg-slate-200 border border-slate-200 transition text-xs font-bold text-slate-800"
                        >
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-[#641E28] text-white flex items-center justify-center text-xs font-black shadow-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline max-w-[120px] truncate font-bold">{{ Auth::user()->name }}</span>
                        </a>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="p-1.5 sm:p-2 rounded-full text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                title="Keluar Akun"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <!-- Guest State: Standar Masuk (Login) dan Daftar (Sign Up) Rapi & Tegas -->
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <a
                                href="{{ route('login') }}"
                                class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-bold text-[#641E28] hover:text-[#4A151D] hover:bg-rose-50 border border-[#641E28]/40 rounded-full transition shadow-2xs active:scale-95"
                            >
                                Masuk
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="px-3.5 sm:px-5 py-1.5 sm:py-2 text-xs sm:text-sm font-bold text-white bg-[#641E28] hover:bg-[#4A151D] rounded-full transition shadow-xs active:scale-95"
                            >
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile Search Bar (Compact & Sleek) -->
            <div class="md:hidden pb-2.5 pt-0.5">
                <form action="/" method="GET" class="relative flex items-center">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari buku kuliah, jas lab FT, helm, dispenser..."
                        class="w-full pl-9 pr-16 py-1.5 text-xs bg-slate-50 border border-slate-300 rounded-full focus:bg-white focus:border-[#641E28] font-medium"
                    />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <button type="submit" class="absolute right-1 px-3 py-1 bg-[#641E28] text-white rounded-full text-xs font-bold shadow-xs">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Area with Bottom Padding for Mobile Nav -->
    <main class="flex-1 w-full py-3 sm:py-6 pb-20 md:pb-6">
        {{ $slot }}
    </main>

    <!-- 4. Mobile Bottom Navigation Bar (Tokopedia / Shopee App Style) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-t border-slate-200/90 shadow-lg px-2 py-1.5 flex items-center justify-around">
        <!-- 1. Beranda -->
        <a href="/" class="flex flex-col items-center justify-center py-1 px-3 text-center {{ request()->is('/') ? 'text-[#641E28]' : 'text-slate-500 hover:text-slate-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] font-bold mt-0.5">Beranda</span>
        </a>

        <!-- 2. Jual (+) Floating Golden Button -->
        <a href="{{ route('product.create') }}" class="flex flex-col items-center justify-center -mt-4 group">
            <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-[#EDAB0F] to-[#f59e0b] group-hover:from-[#d97706] group-hover:to-[#b45309] text-slate-950 shadow-md flex items-center justify-center border-2 border-white transition active:scale-95">
                <svg class="w-6 h-6 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <span class="text-[10px] font-black text-[#641E28] mt-0.5">Jual</span>
        </a>

        <!-- 3. Chat -->
        @auth
            <a href="{{ route('chat') }}" class="relative flex flex-col items-center justify-center py-1 px-3 text-center {{ request()->is('chat*') ? 'text-[#641E28]' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                @php
                    $unreadTotalMobile = Auth::user()->unreadChatCount();
                @endphp
                @if($unreadTotalMobile > 0)
                    <span class="absolute top-1 right-2 w-3.5 h-3.5 rounded-full bg-[#641E28] text-white text-[8px] font-black flex items-center justify-center">
                        {{ $unreadTotalMobile }}
                    </span>
                @endif
                <span class="text-[10px] font-bold mt-0.5">Chat</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center py-1 px-3 text-center text-slate-500 hover:text-slate-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span class="text-[10px] font-bold mt-0.5">Chat</span>
            </a>
        @endauth

        <!-- 4. Akun / Dashboard -->
        @auth
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center py-1 px-3 text-center {{ request()->is('dashboard*') ? 'text-[#641E28]' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-[10px] font-bold mt-0.5">Akun</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center py-1 px-3 text-center text-slate-500 hover:text-slate-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span class="text-[10px] font-bold mt-0.5">Masuk</span>
            </a>
        @endauth
    </nav>

    <!-- Footer Ringkas & Profesional (E-Commerce Wide Layout) -->
    <footer class="w-full bg-white border-t border-slate-200 text-slate-500 text-xs py-8 mt-12">
        <div class="w-full px-4 sm:px-8 lg:px-12 xl:px-14">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <img src="/images/campuscycle-horizontal.png" alt="CampusCycle Logo" class="h-9 w-auto object-contain" />
                    <span class="text-xs text-slate-400">Marketplace Mahasiswa Untirta</span>
                </div>
                <div class="flex flex-wrap items-center gap-6 text-xs font-semibold text-slate-600">
                    <a href="/" class="hover:text-[#641E28]">Katalog Produk</a>
                    <a href="{{ route('product.create') }}" class="hover:text-[#641E28]">Jual Barang</a>
                    <a href="{{ route('login') }}" class="hover:text-[#641E28]">Masuk Mahasiswa</a>
                    <span class="text-slate-400">Titik COD: FT Cilegon • Sindangsari • Pakupatan</span>
                </div>
            </div>
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
                <p>© {{ date('Y') }} CampusCycle Untirta. Hak Cipta Dilindungi.</p>
                <p class="font-medium">Pembayaran Resmi QRIS & Verifikasi Mahasiswa Aktif.</p>
            </div>
        </div>
    </footer>

    @livewireScripts

    <!-- Global Helper: Toggle Password Visibility (100% Reliable Cross-Browser) -->
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (eyeOpen && eyeClosed) {
                if (isPass) {
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>
