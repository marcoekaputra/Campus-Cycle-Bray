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
        <div class="w-full px-4 sm:px-8 lg:px-12 xl:px-14 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="font-extrabold text-[#EDAB0F] tracking-wide">CampusCycle Untirta</span>
                <span class="text-rose-200/40">•</span>
                <span class="text-rose-100 font-medium hidden sm:inline">Pusat Jual Beli & Sirkulasi Barang Pre-loved Mahasiswa</span>
            </div>
            <div class="flex items-center gap-3 text-rose-100 font-medium text-[11px]">
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
                    <span>Mahasiswa Terverifikasi PDDIKTI</span>
                </span>
            </div>
        </div>
    </div>

    <!-- 2. Main E-Commerce Navigation Bar (Widescreen Proportional Layout) -->
    <header class="w-full bg-white border-b border-slate-200/90 sticky top-0 z-40 shadow-xs">
        <div class="w-full px-4 sm:px-8 lg:px-12 xl:px-14">
            <div class="h-16 sm:h-20 flex items-center justify-between gap-4 lg:gap-8">

                <!-- Logo CampusCycle Horizontal (Pinggir Kiri Berwibawa & Tajam) -->
                <a href="/" class="flex items-center shrink-0 group mr-2 lg:mr-4">
                    <img 
                        src="/images/campuscycle-horizontal.png" 
                        alt="CampusCycle Logo" 
                        class="h-10 sm:h-12 lg:h-[50px] w-auto object-contain transition-transform duration-200 group-hover:scale-[1.02]"
                    />
                </a>

                <!-- E-Commerce Search Bar (Lapang & Proporsional di Tengah) -->
                <div class="flex-1 max-w-3xl lg:max-w-4xl hidden md:block">
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
                                class="w-full pl-11 pr-28 py-2.5 text-xs sm:text-sm bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-[#641E28] rounded-full focus:ring-4 focus:ring-[#641E28]/10 transition-all font-medium text-slate-800 placeholder:text-slate-400 shadow-xs"
                            />
                            <button
                                type="submit"
                                class="absolute right-1.5 px-5 py-1.5 bg-[#641E28] hover:bg-[#4A151D] text-white rounded-full text-xs font-extrabold shadow-xs transition active:scale-95"
                            >
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Action Controls (Pinggir Kanan Proporsional) -->
                <div class="flex items-center gap-3 sm:gap-4 shrink-0">

                    <!-- CTA Jual Barang (Golden Button) -->
                    <a
                        href="{{ route('product.create') }}"
                        class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-black text-slate-950 bg-gradient-to-r from-[#EDAB0F] to-[#f59e0b] hover:from-[#d97706] hover:to-[#b45309] hover:text-white shadow-sm transition-all flex items-center gap-1.5 active:scale-95"
                    >
                        <span class="text-base font-black leading-none">+</span>
                        <span class="hidden sm:inline">Jual Barang</span>
                        <span class="sm:hidden">Jual</span>
                    </a>

                    @auth
                        <!-- CampusWallet Saldo Pill -->
                        <a
                            href="{{ route('dashboard') }}"
                            class="hidden lg:flex items-center gap-2.5 px-3.5 py-2 rounded-full bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-300 text-xs font-bold text-slate-700 transition"
                            title="Saldo Dompet Mahasiswa"
                        >
                            <span class="w-5 h-5 rounded-full bg-[#EDAB0F] text-slate-900 flex items-center justify-center text-[10px] font-black shadow-xs">Rp</span>
                            <span class="font-mono text-slate-900 font-extrabold">{{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</span>
                        </a>

                        @if(Auth::user()->isAdmin())
                            <!-- Admin Console Quick Link -->
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-900 text-[#EDAB0F] hover:bg-black transition text-xs font-black shadow-xs border border-amber-400/40"
                                title="Buka Panel Admin Platform"
                            >
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="hidden sm:inline">Admin Console</span>
                            </a>
                        @endif

                        <!-- Chat Shortcut Pill -->
                        <a
                            href="{{ route('chat') }}"
                            class="relative p-2 rounded-full text-slate-600 hover:text-[#641E28] hover:bg-rose-50 transition"
                            title="Buka Chat Penjual & Pembeli"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            @php
                                $unreadTotal = Auth::user()->unreadChatCount();
                            @endphp
                            @if($unreadTotal > 0)
                                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full bg-[#641E28] text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white">
                                    {{ $unreadTotal }}
                                </span>
                            @endif
                        </a>

                        <!-- User Profile Link -->
                        <a
                            href="{{ route('dashboard') }}"
                            class="flex items-center gap-2.5 pl-2 pr-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-slate-200 border border-slate-200 transition text-xs font-bold text-slate-800"
                        >
                            <div class="w-7 h-7 rounded-full bg-[#641E28] text-white flex items-center justify-center text-xs font-black shadow-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline max-w-[120px] truncate font-bold">{{ Auth::user()->name }}</span>
                        </a>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="p-2 rounded-full text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                title="Keluar Akun"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <!-- Guest State -->
                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('login') }}"
                                class="px-4 py-2 text-xs sm:text-sm font-extrabold text-slate-700 hover:text-[#641E28] transition"
                            >
                                Masuk
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="px-5 py-2 text-xs sm:text-sm font-extrabold text-[#641E28] bg-rose-50 hover:bg-[#641E28] hover:text-white border border-rose-200 rounded-full transition shadow-xs"
                            >
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="md:hidden pb-3">
                <form action="/" method="GET" class="relative flex items-center">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari buku, rice cooker, helm lab..."
                        class="w-full pl-9 pr-16 py-2 text-xs bg-slate-50 border border-slate-300 rounded-full focus:border-[#641E28] font-medium"
                    />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <button type="submit" class="absolute right-1 px-3 py-1 bg-[#641E28] text-white rounded-full text-xs font-bold">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 w-full py-4 sm:py-6">
        {{ $slot }}
    </main>

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
</body>
</html>
