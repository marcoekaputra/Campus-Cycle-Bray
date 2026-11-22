<div class="min-h-screen flex flex-col lg:flex-row bg-slate-950 text-slate-100">

    <!-- ======================================================== -->
    <!-- 1. LEFT SIDEBAR PANEL (Panel Kiri Profesional E-Commerce) -->
    <!-- ======================================================== -->
    <aside class="w-full lg:w-64 xl:w-72 bg-slate-900 border-r border-slate-800 flex flex-col shrink-0 lg:h-screen lg:sticky lg:top-0 z-30">
        <!-- Sidebar Header: Brand & Identity -->
        <div class="p-5 border-b border-slate-800/80 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <img src="/images/campuscycle-horizontal.png" alt="CampusCycle" class="h-8 sm:h-9 w-auto brightness-110 object-contain" />
            </a>
            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-amber-400/10 text-[#EDAB0F] border border-amber-400/20">
                Console
            </span>
        </div>

        <!-- Sidebar Navigation Groups (Shopee / Tokopedia Seller Centre Structure) -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-3.5 space-y-6">

            <!-- Section: UTAMA -->
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 mb-2">
                    Utama
                </div>
                <nav class="space-y-1">
                    <button
                        type="button"
                        wire:click="switchTab('overview')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $activeTab === 'overview' ? 'bg-[#641E28] text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ $activeTab === 'overview' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Ringkasan Platform</span>
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Section: OPERASIONAL MARKETPLACE -->
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 mb-2">
                    Operasional Marketplace
                </div>
                <nav class="space-y-1">
                    <!-- Produk -->
                    <button
                        type="button"
                        wire:click="switchTab('products')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $activeTab === 'products' ? 'bg-[#641E28] text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ $activeTab === 'products' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>Katalog & QC</span>
                        </div>
                        @if($flaggedProductsCount > 0)
                            <span class="px-1.5 py-0.5 text-[10px] font-black rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                {{ $flaggedProductsCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Transaksi & Escrow -->
                    <button
                        type="button"
                        wire:click="switchTab('orders')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $activeTab === 'orders' ? 'bg-[#641E28] text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ $activeTab === 'orders' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>Transaksi & Escrow</span>
                        </div>
                        <span class="text-[10px] font-mono text-slate-300 bg-slate-800 px-1.5 py-0.5 rounded">
                            {{ $totalOrdersCount }}
                        </span>
                    </button>

                    <!-- Monitoring Chat Civitas (Fitur 1) -->
                    <button
                        type="button"
                        wire:click="switchTab('chats')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $activeTab === 'chats' ? 'bg-[#641E28] text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ $activeTab === 'chats' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span>Monitoring Chat</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            {{ $totalConversationsCount }}
                        </span>
                    </button>
                </nav>
            </div>

            <!-- Section: MEDIASI & KEUANGAN -->
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 mb-2">
                    Mediasi & Keuangan
                </div>
                <nav class="space-y-1">
                    <!-- Sengketa -->
                    <button
                        type="button"
                        wire:click="switchTab('disputes')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $activeTab === 'disputes' ? 'bg-[#641E28] text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ $activeTab === 'disputes' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>Pusat Sengketa</span>
                        </div>
                        @if($pendingDisputesCount > 0)
                            <span class="px-1.5 py-0.5 text-[10px] font-black rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                {{ $pendingDisputesCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Pencairan Dana (Payouts) -->
                    <button
                        type="button"
                        wire:click="switchTab('finance')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $activeTab === 'finance' ? 'bg-[#641E28] text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ $activeTab === 'finance' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span>Pencairan Dana (Payout)</span>
                        </div>
                        @if($pendingWithdrawalsCount > 0)
                            <span class="px-1.5 py-0.5 text-[10px] font-black rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                {{ $pendingWithdrawalsCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Pengguna Civitas -->
                    <button
                        type="button"
                        wire:click="switchTab('users')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $activeTab === 'users' ? 'bg-[#641E28] text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ $activeTab === 'users' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Pengguna & PDDIKTI</span>
                        </div>
                        <span class="text-[10px] font-mono text-slate-300 bg-slate-800 px-1.5 py-0.5 rounded">
                            {{ $totalUsers }}
                        </span>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Sidebar Footer: Switch to Marketplace & Admin User Card -->
        <div class="p-3.5 border-t border-slate-800/80 bg-slate-900/90 space-y-3">
            <a
                href="/"
                class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white text-xs font-bold transition border border-slate-700/60"
            >
                <svg class="w-4 h-4 text-[#EDAB0F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Buka Marketplace</span>
            </a>

            <!-- Admin Profile & Logout -->
            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-[#641E28] text-[#EDAB0F] font-black flex items-center justify-center text-xs shrink-0 shadow-xs border border-amber-400/20">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-amber-400 font-semibold uppercase">{{ Auth::user()->role }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition cursor-pointer"
                        title="Keluar Akun Admin"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ======================================================== -->
    <!-- 2. MAIN CONTENT AREA (Panel Kanan Data & Operasional) -->
    <!-- ======================================================== -->
    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-slate-950">

        <!-- Top App Bar -->
        <header class="h-16 px-4 sm:px-6 lg:px-8 border-b border-slate-850 bg-slate-900/60 backdrop-blur-md sticky top-0 z-20 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="text-xs font-medium text-slate-400 hidden sm:block">
                    Admin Console /
                </div>
                <h2 class="text-sm sm:text-base font-black text-white capitalize">
                    @switch($activeTab)
                        @case('overview') Ringkasan Eksekutif & Metrik Operasional @break
                        @case('products') Moderasi Katalog & Manajemen Produk (QC) @break
                        @case('orders') Transaksi & Escrow Platform @break
                        @case('chats') Monitoring & Pengawasan Chat Civitas Untirta @break
                        @case('disputes') Pusat Mediasi Sengketa Transaksi @break
                        @case('finance') Pencairan Saldo Dompet & Rekonsiliasi Bank @break
                        @case('users') Manajemen Pengguna & Verifikasi PDDIKTI @break
                        @default Dashboard @break
                    @endswitch
                </h2>
            </div>

            <!-- Operational Status Badges -->
            <div class="flex items-center gap-2 sm:gap-3 text-xs">
                <div class="hidden md:flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-semibold text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Escrow Engine Aktif</span>
                </div>
                <div class="hidden lg:flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-[#EDAB0F] font-semibold text-[11px]">
                    <span>Zona: Untirta Multi-Kampus</span>
                </div>
            </div>
        </header>

        <!-- Flash Alert Messages -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4">
            @if (session()->has('status'))
                <div class="mb-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl flex items-center justify-between text-xs sm:text-sm font-semibold">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl flex items-center justify-between text-xs sm:text-sm font-semibold">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Dynamic Main Content -->
        <div class="p-4 sm:p-6 lg:p-8 space-y-6">

            <!-- ========================================== -->
            <!-- TAB: OVERVIEW (Ringkasan Eksekutif)       -->
            <!-- ========================================== -->
            @if($activeTab === 'overview')
                <!-- 4 KPI Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                    <!-- 1. Total GMV -->
                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">
                            <span>Total GMV Selesai</span>
                            <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-2xl font-black text-white font-mono">
                            Rp {{ number_format($totalGmv, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-emerald-400 font-semibold mt-2 flex items-center gap-1">
                            <span>{{ $completedOrdersCount }} transaksi selesai</span>
                        </div>
                    </div>

                    <!-- 2. Saldo Escrow Tertahan -->
                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">
                            <span>Saldo Escrow Berjalan</span>
                            <span class="p-1.5 rounded-lg bg-amber-500/10 text-[#EDAB0F]">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-2xl font-black text-[#EDAB0F] font-mono">
                            Rp {{ number_format($escrowBalance, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-semibold mt-2">
                            Dana aman tertahan sebelum serah-terima
                        </div>
                    </div>

                    <!-- 3. Produk Aktif -->
                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">
                            <span>Katalog Aktif</span>
                            <span class="p-1.5 rounded-lg bg-blue-500/10 text-blue-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-2xl font-black text-white font-mono">
                            {{ $activeProductsCount }} / {{ $totalProducts }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-semibold mt-2">
                            Barang pre-loved siap dibeli
                        </div>
                    </div>

                    <!-- 4. Pengguna Terdaftar -->
                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">
                            <span>Civitas Kampus</span>
                            <span class="p-1.5 rounded-lg bg-purple-500/10 text-purple-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="text-2xl font-black text-white font-mono">
                            {{ $totalUsers }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-semibold mt-2">
                            Mahasiswa & Admin Untirta
                        </div>
                    </div>
                </div>

                <!-- 2 Columns: Transaksi Escrow Berjalan & Distribusi Zona Kampus -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left (2 cols): Pesanan Butuh Pengawasan -->
                    <div class="lg:col-span-2 p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-extrabold text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#EDAB0F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Transaksi Berjalan (Escrow Aktif)</span>
                            </h3>
                            <button wire:click="switchTab('orders')" class="text-xs font-bold text-[#EDAB0F] hover:underline">
                                Lihat Semua Pesanan →
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="text-slate-400 border-b border-slate-800 text-[11px] font-bold uppercase tracking-wider">
                                        <th class="pb-2.5">No. Pesanan</th>
                                        <th class="pb-2.5">Barang</th>
                                        <th class="pb-2.5">Pembeli</th>
                                        <th class="pb-2.5">Total</th>
                                        <th class="pb-2.5">Metode</th>
                                        <th class="pb-2.5">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/60 font-medium">
                                    @forelse($escrowOrders as $eo)
                                        <tr class="hover:bg-slate-800/40 transition">
                                            <td class="py-3 font-mono font-bold text-white">{{ $eo->order_number }}</td>
                                            <td class="py-3 truncate max-w-[160px]">{{ $eo->product->title ?? '-' }}</td>
                                            <td class="py-3 text-slate-300">{{ $eo->buyer->name ?? '-' }}</td>
                                            <td class="py-3 font-mono font-bold text-emerald-400">Rp {{ number_format($eo->total_amount, 0, ',', '.') }}</td>
                                            <td class="py-3 text-[11px] text-slate-400">{{ strtoupper($eo->delivery_method) }}</td>
                                            <td class="py-3">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $eo->status === 'paid' ? 'bg-amber-500/10 text-[#EDAB0F] border border-amber-500/30' : 'bg-blue-500/10 text-blue-400 border border-blue-500/30' }}">
                                                    {{ strtoupper($eo->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-6 text-center text-slate-500 text-xs">
                                                Tidak ada transaksi berjalan saat ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Right (1 col): Antrean Perhatian Admin -->
                    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-4">
                        <h3 class="text-sm font-extrabold text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span>Antrean Perhatian Admin</span>
                        </h3>

                        <div class="space-y-3">
                            <!-- Pending Disputes -->
                            <div class="p-3.5 rounded-xl bg-slate-800/60 border border-slate-700/60 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-white">Sengketa Transaksi</div>
                                    <div class="text-[11px] text-slate-400">Komplain belum dimediasi</div>
                                </div>
                                <button
                                    wire:click="switchTab('disputes')"
                                    class="px-2.5 py-1 text-xs font-extrabold rounded-lg {{ $pendingDisputesCount > 0 ? 'bg-amber-500 text-slate-950' : 'bg-slate-700 text-slate-300' }}"
                                >
                                    {{ $pendingDisputesCount }} Tiket
                                </button>
                            </div>

                            <!-- Pending Withdrawals -->
                            <div class="p-3.5 rounded-xl bg-slate-800/60 border border-slate-700/60 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-white">Permintaan Pencairan</div>
                                    <div class="text-[11px] text-slate-400">Withdrawal saldo mahasiswa</div>
                                </div>
                                <button
                                    wire:click="switchTab('finance')"
                                    class="px-2.5 py-1 text-xs font-extrabold rounded-lg {{ $pendingWithdrawalsCount > 0 ? 'bg-rose-500 text-white' : 'bg-slate-700 text-slate-300' }}"
                                >
                                    {{ $pendingWithdrawalsCount }} Antrean
                                </button>
                            </div>

                            <!-- Flagged Products -->
                            <div class="p-3.5 rounded-xl bg-slate-800/60 border border-slate-700/60 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-white">Produk Ditakedown</div>
                                    <div class="text-[11px] text-slate-400">Pelanggaran pedoman katalog</div>
                                </div>
                                <button
                                    wire:click="switchTab('products')"
                                    class="px-2.5 py-1 text-xs font-extrabold rounded-lg bg-slate-700 text-slate-300"
                                >
                                    {{ $flaggedProductsCount }} Barang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- TAB: PRODUCTS (Katalog & Moderasi QC)     -->
            <!-- ========================================== -->
            @if($activeTab === 'products')
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-white">Manajemen & Moderasi Produk (QC)</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Pantau kepatuhan barang bekas kampus, verifikasi kelayakan barang, dan lakukan takedown bila melanggar.</p>
                        </div>
                        <div class="text-xs text-slate-400 font-mono">
                            Total: <strong class="text-white">{{ $products->total() }}</strong> barang
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="productSearch"
                            placeholder="Cari judul barang, penjual, NIM..."
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white placeholder:text-slate-400 focus:border-[#EDAB0F] outline-hidden"
                        />
                        <select
                            wire:model.live="productCategory"
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <select
                            wire:model.live="productZone"
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="">Semua Kampus</option>
                            <option value="Cilegon">FT Cilegon</option>
                            <option value="Sindangsari">Sindangsari</option>
                            <option value="Pakupatan">Pakupatan</option>
                            <option value="Ciwaru">Ciwaru</option>
                        </select>
                        <select
                            wire:model.live="productStatus"
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="">Semua Status</option>
                            <option value="available">Tersedia (Available)</option>
                            <option value="sold">Terjual (Sold)</option>
                            <option value="flagged">Ditakedown (Flagged)</option>
                        </select>
                    </div>

                    <!-- Products Table -->
                    <div class="overflow-x-auto rounded-xl border border-slate-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-850 text-slate-400 uppercase text-[11px] font-bold">
                                <tr>
                                    <th class="p-3">Produk</th>
                                    <th class="p-3">Penjual & NIM</th>
                                    <th class="p-3">Harga</th>
                                    <th class="p-3">Kategori</th>
                                    <th class="p-3">Zona Kampus</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 text-right">Aksi Moderasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 font-medium">
                                @forelse($products as $prod)
                                    <tr class="hover:bg-slate-850/50 transition">
                                        <td class="p-3 flex items-center gap-3">
                                            <img
                                                src="{{ $prod->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                                alt="{{ $prod->title }}"
                                                class="w-10 h-10 rounded-lg object-cover border border-slate-700 shrink-0"
                                            />
                                            <div class="min-w-0">
                                                <div class="font-bold text-white truncate max-w-[180px]">{{ $prod->title }}</div>
                                                <div class="text-[10px] text-slate-400">ID: #{{ $prod->id }}</div>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <div class="text-slate-200 font-bold">{{ $prod->seller->name ?? 'Mahasiswa' }}</div>
                                            <div class="text-[10px] font-mono text-slate-400">{{ $prod->seller->nim ?? '-' }}</div>
                                        </td>
                                        <td class="p-3 font-mono font-bold text-white">
                                            Rp {{ number_format($prod->price, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 text-slate-300">{{ $prod->category->name ?? '-' }}</td>
                                        <td class="p-3 text-slate-300">{{ $prod->campus_zone }}</td>
                                        <td class="p-3">
                                            @if($prod->is_flagged)
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                                    TAKEDOWN
                                                </span>
                                            @elseif($prod->status === 'sold')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-700 text-slate-300">
                                                    TERJUAL
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                                    AKTIF
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-right">
                                            @if($prod->is_flagged)
                                                <button
                                                    type="button"
                                                    wire:click="restoreProduct({{ $prod->id }})"
                                                    class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                >
                                                    Pulihkan
                                                </button>
                                            @else
                                                <button
                                                    type="button"
                                                    wire:click="openTakedownModal({{ $prod->id }})"
                                                    class="px-2.5 py-1 bg-rose-600/80 hover:bg-rose-600 text-white rounded-lg text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                >
                                                    Takedown
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-500">
                                            Tidak ada produk yang cocok dengan kriteria pencarian.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>{{ $products->links() }}</div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- TAB: ORDERS (Transaksi & Escrow)          -->
            <!-- ========================================== -->
            @if($activeTab === 'orders')
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-white">Manajemen Transaksi & Escrow Kampus</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Pantau status pembayaran Midtrans/Dompet, verifikasi serah-terima COD, dan selesaikan pesanan tertahan.</p>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="orderSearch"
                            placeholder="Cari No. Pesanan, Nama Pembeli, Penjual..."
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white placeholder:text-slate-400 focus:border-[#EDAB0F] outline-hidden"
                        />
                        <select
                            wire:model.live="orderStatus"
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="">Semua Status Pesanan</option>
                            <option value="pending">Menunggu Pembayaran</option>
                            <option value="paid">Dibayar (Escrow)</option>
                            <option value="processing">Diproses Penjual</option>
                            <option value="shipped">Dalam Pengiriman / COD</option>
                            <option value="completed">Selesai (Dana Cair)</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                        <select
                            wire:model.live="orderDeliveryMethod"
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="">Semua Metode Pengiriman</option>
                            <option value="cod">COD Kampus</option>
                            <option value="express_courier">Kurir Kilat</option>
                            <option value="locker_drop">Loker Kampus</option>
                        </select>
                    </div>

                    <!-- Orders Table -->
                    <div class="overflow-x-auto rounded-xl border border-slate-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-850 text-slate-400 uppercase text-[11px] font-bold">
                                <tr>
                                    <th class="p-3">No. Pesanan</th>
                                    <th class="p-3">Barang</th>
                                    <th class="p-3">Pihak Transaksi</th>
                                    <th class="p-3">Total Nominal</th>
                                    <th class="p-3">Metode Bayar & Logistik</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 text-right">Intervensi Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 font-medium">
                                @forelse($orders as $ord)
                                    <tr class="hover:bg-slate-850/50 transition">
                                        <td class="p-3 font-mono font-bold text-white">{{ $ord->order_number }}</td>
                                        <td class="p-3 truncate max-w-[160px]">{{ $ord->product->title ?? '-' }}</td>
                                        <td class="p-3">
                                            <div class="text-slate-200"><span class="text-slate-500">P:</span> {{ $ord->buyer->name ?? '-' }}</div>
                                            <div class="text-slate-400 text-[11px]"><span class="text-slate-500">S:</span> {{ $ord->seller->name ?? '-' }}</div>
                                        </td>
                                        <td class="p-3 font-mono font-bold text-emerald-400">
                                            Rp {{ number_format($ord->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3">
                                            <div class="capitalize text-slate-300">{{ str_replace('_', ' ', $ord->payment_method) }}</div>
                                            <div class="text-[10px] text-slate-400">{{ strtoupper($ord->delivery_method) }} ({{ $ord->destination_zone }})</div>
                                        </td>
                                        <td class="p-3">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $ord->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : ($ord->status === 'cancelled' ? 'bg-rose-500/10 text-rose-400' : 'bg-amber-500/10 text-[#EDAB0F] border border-amber-500/30') }}">
                                                {{ strtoupper($ord->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-right space-x-1.5">
                                            <a
                                                href="{{ route('order.invoice.view', $ord->order_number) }}"
                                                target="_blank"
                                                class="px-2 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-bold transition"
                                                title="Lihat Faktur Pembelian"
                                            >
                                                Faktur
                                            </a>
                                            @if(!in_array($ord->status, ['completed', 'cancelled']))
                                                <button
                                                    type="button"
                                                    wire:click="forceCompleteOrder({{ $ord->id }})"
                                                    wire:confirm="Yakin ingin menyelesaikan pesanan ini secara paksa? Dana escrow akan langsung diteruskan ke dompet penjual."
                                                    class="px-2 py-1 bg-emerald-600/80 hover:bg-emerald-600 text-white rounded text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                    title="Selesaikan & Cairkan Dana ke Penjual"
                                                >
                                                    Selesaikan
                                                </button>
                                                <button
                                                    type="button"
                                                    wire:click="forceCancelAndRefund({{ $ord->id }})"
                                                    wire:confirm="Yakin ingin membatalkan pesanan ini dan mengembalikan dana ke dompet pembeli?"
                                                    class="px-2 py-1 bg-rose-600/80 hover:bg-rose-600 text-white rounded text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                    title="Batalkan & Kembalikan Dana (Refund)"
                                                >
                                                    Refund
                                                </button>
                                            @else
                                                <span class="text-[11px] text-slate-500 font-mono">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-500">
                                            Tidak ada riwayat pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>{{ $orders->links() }}</div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- TAB: CHATS (Monitoring Chat Mahasiswa)     -->
            <!-- ========================================== -->
            @if($activeTab === 'chats')
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-white flex items-center gap-2">
                                <span>Pusat Pengawasan & Monitoring Chat Civitas Untirta</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    Anti-Fraud & Audit
                                </span>
                            </h3>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Administrator dapat memantau percakapan tawar-menawar & COD antar mahasiswa untuk mengantisipasi indikasi penipuan, transaksi di luar sistem, atau barang terlarang.
                            </p>
                        </div>
                        <div class="text-xs text-slate-400 font-mono">
                            Total: <strong class="text-white">{{ $chats->total() }}</strong> percakapan
                        </div>
                    </div>

                    <!-- Search Filter -->
                    <div class="max-w-md">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="chatSearch"
                            placeholder="Cari obrolan: nama mahasiswa, NIM, atau barang..."
                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white placeholder:text-slate-400 focus:border-[#EDAB0F] outline-hidden font-medium"
                        />
                    </div>

                    <!-- Conversations Table -->
                    <div class="overflow-x-auto rounded-xl border border-slate-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-850 text-slate-400 uppercase text-[11px] font-bold">
                                <tr>
                                    <th class="p-3">ID</th>
                                    <th class="p-3">Pembeli (Inisiator)</th>
                                    <th class="p-3">Penjual</th>
                                    <th class="p-3">Produk Terkait</th>
                                    <th class="p-3">Pesan Terakhir</th>
                                    <th class="p-3">Waktu Terakhir</th>
                                    <th class="p-3 text-right">Audit & Inspeksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 font-medium">
                                @forelse($chats as $c)
                                    <tr class="hover:bg-slate-850/50 transition">
                                        <td class="p-3 font-mono text-slate-400">#{{ $c->id }}</td>
                                        <td class="p-3">
                                            <div class="text-slate-200 font-bold">{{ $c->buyer->name ?? 'Mahasiswa' }}</div>
                                            <div class="text-[10px] font-mono text-slate-400">{{ $c->buyer->nim ?? '-' }}</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="text-slate-200 font-bold">{{ $c->seller->name ?? 'Mahasiswa' }}</div>
                                            <div class="text-[10px] font-mono text-slate-400">{{ $c->seller->nim ?? '-' }}</div>
                                        </td>
                                        <td class="p-3">
                                            @if($c->product)
                                                <div class="truncate max-w-[150px] font-bold text-white">{{ $c->product->title }}</div>
                                                <div class="text-[10px] font-mono text-[#EDAB0F]">Rp {{ number_format($c->product->price, 0, ',', '.') }}</div>
                                            @else
                                                <span class="text-slate-500 italic">Umum</span>
                                            @endif
                                        </td>
                                        <td class="p-3 truncate max-w-[200px] text-slate-300">
                                            {{ $c->latestMessage ? $c->latestMessage->message : '-' }}
                                        </td>
                                        <td class="p-3 text-[11px] text-slate-400 font-mono">
                                            {{ $c->last_message_at ? $c->last_message_at->format('d M H:i') : '-' }}
                                        </td>
                                        <td class="p-3 text-right">
                                            <button
                                                type="button"
                                                wire:click="openInspectChat({{ $c->id }})"
                                                class="px-3 py-1.5 bg-[#641E28] hover:bg-[#4A151D] text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5 ml-auto cursor-pointer"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span>Inspeksi Chat</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-500">
                                            Belum ada aktivitas obrolan di platform.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>{{ $chats->links() }}</div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- TAB: DISPUTES (Pusat Mediasi Sengketa)    -->
            <!-- ========================================== -->
            @if($activeTab === 'disputes')
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-white">Pusat Mediasi Sengketa Transaksi</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Tangani komplain pembeli terhadap kondisi barang, ketidaksesuaian COD, dan ambil keputusan pelepasan escrow.</p>
                        </div>
                    </div>

                    <!-- Disputes Table -->
                    <div class="overflow-x-auto rounded-xl border border-slate-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-850 text-slate-400 uppercase text-[11px] font-bold">
                                <tr>
                                    <th class="p-3">ID Sengketa</th>
                                    <th class="p-3">No. Pesanan</th>
                                    <th class="p-3">Pelapor (Pembeli)</th>
                                    <th class="p-3">Terlapor (Penjual)</th>
                                    <th class="p-3">Alasan Komplain</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 text-right">Keputusan Mediasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 font-medium">
                                @forelse($disputes as $disp)
                                    <tr class="hover:bg-slate-850/50 transition">
                                        <td class="p-3 font-mono font-bold text-white">#DSP-{{ $disp->id }}</td>
                                        <td class="p-3 font-mono text-[#EDAB0F]">{{ $disp->order->order_number ?? '-' }}</td>
                                        <td class="p-3">
                                            <div class="text-slate-200 font-bold">{{ $disp->complainant->name ?? '-' }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $disp->complainant->nim ?? '-' }}</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="text-slate-200 font-bold">{{ $disp->respondent->name ?? '-' }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $disp->respondent->nim ?? '-' }}</div>
                                        </td>
                                        <td class="p-3 max-w-[200px]">
                                            <div class="font-bold text-slate-200 truncate">{{ $disp->reason }}</div>
                                            <div class="text-[10px] text-slate-400 truncate">{{ $disp->description }}</div>
                                        </td>
                                        <td class="p-3">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $disp->status === 'open' ? 'bg-amber-500/10 text-[#EDAB0F] border border-amber-500/30' : 'bg-slate-700 text-slate-300' }}">
                                                {{ strtoupper($disp->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-right space-x-1.5">
                                            @if($disp->order)
                                                <a
                                                    href="{{ route('order.invoice.view', $disp->order->order_number) }}"
                                                    target="_blank"
                                                    class="px-2 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-bold transition"
                                                    title="Lihat Faktur Pembelian"
                                                >
                                                    Faktur
                                                </a>
                                            @endif

                                            @if($disp->order && $disp->order->return_status === 'approved_by_seller')
                                                <button
                                                    type="button"
                                                    wire:click="approveReturnRefund({{ $disp->order_id }})"
                                                    wire:confirm="Setujui crosscheck return dan cairkan refund ke dompet pembeli (setelah dipotong application fee 1.5%)?"
                                                    class="px-2.5 py-1 bg-amber-600 hover:bg-amber-500 text-white rounded text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                >
                                                    Setujui Refund Return
                                                </button>
                                            @elseif($disp->status === 'open' || $disp->status === 'under_review')
                                                <button
                                                    type="button"
                                                    wire:click="resolveDisputeRefundBuyer({{ $disp->id }})"
                                                    wire:confirm="Kembalikan dana ke pembeli?"
                                                    class="px-2.5 py-1 bg-rose-600/80 hover:bg-rose-600 text-white rounded text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                >
                                                    Refund Pembeli
                                                </button>
                                                <button
                                                    type="button"
                                                    wire:click="resolveDisputeReleaseToSeller({{ $disp->id }})"
                                                    wire:confirm="Lepaskan dana ke penjual?"
                                                    class="px-2.5 py-1 bg-emerald-600/80 hover:bg-emerald-600 text-white rounded text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                >
                                                    Lepas ke Penjual
                                                </button>
                                            @else
                                                <span class="text-[11px] text-slate-500 italic">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-500">
                                            Tidak ada sengketa transaksi yang aktif.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- TAB: FINANCE (Pencairan Saldo & Payout)   -->
            <!-- ========================================== -->
            @if($activeTab === 'finance')
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-white">Rekonsiliasi Keuangan & Pencairan Saldo Mahasiswa</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Kelola permintaan penarikan saldo dompet hasil penjualan pre-loved ke rekening bank atau e-wallet mahasiswa.</p>
                        </div>
                    </div>

                    <!-- Withdrawals Table -->
                    <div class="overflow-x-auto rounded-xl border border-slate-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-850 text-slate-400 uppercase text-[11px] font-bold">
                                <tr>
                                    <th class="p-3">ID Payout</th>
                                    <th class="p-3">Mahasiswa</th>
                                    <th class="p-3">Nominal Penarikan</th>
                                    <th class="p-3">Bank / E-Wallet</th>
                                    <th class="p-3">No. Rekening</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 text-right">Otorisasi Transfer</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 font-medium">
                                @forelse($withdrawals as $w)
                                    <tr class="hover:bg-slate-850/50 transition">
                                        <td class="p-3 font-mono font-bold text-white">#WDR-{{ $w->id }}</td>
                                        <td class="p-3">
                                            <div class="text-slate-200 font-bold">{{ $w->account_holder }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $w->user->nim ?? '-' }}</div>
                                        </td>
                                        <td class="p-3 font-mono font-bold text-emerald-400">
                                            Rp {{ number_format($w->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 text-slate-300 font-bold">{{ $w->bank_name }}</td>
                                        <td class="p-3 font-mono text-slate-300">{{ $w->account_number }}</td>
                                        <td class="p-3">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $w->status === 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : ($w->status === 'rejected' ? 'bg-rose-500/10 text-rose-400' : 'bg-amber-500/10 text-[#EDAB0F] border border-amber-500/30') }}">
                                                {{ strtoupper($w->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-right space-x-1.5">
                                            @if($w->status === 'pending')
                                                <button
                                                    type="button"
                                                    wire:click="approveWithdrawal({{ $w->id }})"
                                                    wire:confirm="Setujui transfer pencairan dana ini?"
                                                    class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                >
                                                    Setujui
                                                </button>
                                                <button
                                                    type="button"
                                                    wire:click="rejectWithdrawal({{ $w->id }})"
                                                    wire:confirm="Tolak pencairan dana ini?"
                                                    class="px-2.5 py-1 bg-rose-600/80 hover:bg-rose-600 text-white rounded text-[11px] font-bold transition shadow-xs cursor-pointer"
                                                >
                                                    Tolak
                                                </button>
                                            @else
                                                <span class="text-[11px] text-slate-500 font-mono">Tuntas</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-500">
                                            Tidak ada permintaan pencairan dana saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- TAB: USERS (Pengguna & PDDIKTI)           -->
            <!-- ========================================== -->
            @if($activeTab === 'users')
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-sm space-y-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-white">Direktori Pengguna & Verifikasi PDDIKTI</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Kelola civitas akademika Untirta, atur status pembekuan akun (suspend), dan sesuaikan saldo dompet pengujian.</p>
                        </div>
                    </div>

                    <!-- Search Filter -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="userSearch"
                            placeholder="Cari Nama, NIM, Email..."
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white placeholder:text-slate-400 focus:border-[#EDAB0F] outline-hidden"
                        />
                        <select
                            wire:model.live="userRole"
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="">Semua Peran</option>
                            <option value="student">Mahasiswa</option>
                            <option value="campus_admin">Admin Untirta</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        <select
                            wire:model.live="userZone"
                            class="px-3.5 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="">Semua Zona Kampus</option>
                            <option value="Cilegon">Kampus Cilegon (FT)</option>
                            <option value="Sindangsari">Sindangsari</option>
                            <option value="Pakupatan">Pakupatan</option>
                            <option value="Ciwaru">Ciwaru</option>
                        </select>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto rounded-xl border border-slate-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-850 text-slate-400 uppercase text-[11px] font-bold">
                                <tr>
                                    <th class="p-3">Nama Mahasiswa</th>
                                    <th class="p-3">NIM & Fakultas</th>
                                    <th class="p-3">Email Kampus</th>
                                    <th class="p-3">Zona Kampus</th>
                                    <th class="p-3">Saldo Dompet</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 text-right">Aksi Akun</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 font-medium">
                                @forelse($users as $usr)
                                    <tr class="hover:bg-slate-850/50 transition">
                                        <td class="p-3">
                                            <div class="text-white font-bold">{{ $usr->name }}</div>
                                            <div class="text-[10px] text-amber-400 font-semibold uppercase">{{ $usr->role }}</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-slate-200">{{ $usr->nim ?? '-' }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $usr->faculty ?? 'Untirta' }}</div>
                                        </td>
                                        <td class="p-3 text-slate-300 font-mono text-[11px]">{{ $usr->email }}</td>
                                        <td class="p-3 text-slate-300">{{ $usr->campus_zone ?? '-' }}</td>
                                        <td class="p-3 font-mono font-bold text-emerald-400">
                                            Rp {{ number_format($usr->wallet->balance ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3">
                                            @if($usr->is_suspended)
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                                    DIBEKUKAN
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                                    AKTIF
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-right space-x-1.5">
                                            <button
                                                type="button"
                                                wire:click="openBalanceModal({{ $usr->id }})"
                                                class="px-2 py-1 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 rounded text-[11px] font-bold transition cursor-pointer"
                                                title="Sesuaikan Saldo Dompet"
                                            >
                                                ± Saldo
                                            </button>
                                            @if(!$usr->isAdmin())
                                                <button
                                                    type="button"
                                                    wire:click="toggleSuspendUser({{ $usr->id }})"
                                                    class="px-2 py-1 {{ $usr->is_suspended ? 'bg-emerald-600 hover:bg-emerald-500 text-white' : 'bg-rose-600/80 hover:bg-rose-600 text-white' }} rounded text-[11px] font-bold transition cursor-pointer"
                                                >
                                                    {{ $usr->is_suspended ? 'Aktifkan' : 'Suspend' }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-500">
                                            Tidak ada data pengguna yang cocok.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>{{ $users->links() }}</div>
                </div>
            @endif

        </div>
    </main>

    <!-- ======================================================== -->
    <!-- 3. MODAL: INSPEKSI TRANSKRIP CHAT (Fitur 1)             -->
    <!-- ======================================================== -->
    @if($inspectConversation)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-2xl w-full flex flex-col h-[600px] shadow-2xl overflow-hidden animate-scale-up">
                <!-- Modal Top Header -->
                <div class="p-4 border-b border-slate-800 flex items-center justify-between shrink-0 bg-slate-850">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-extrabold text-white">Transkrip Audit Percakapan #{{ $inspectConversation->id }}</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-[#EDAB0F]">Mode Pengawasan</span>
                        </div>
                        <div class="text-[11px] text-slate-400 mt-0.5">
                            Pembeli: <strong>{{ $inspectConversation->buyer->name ?? 'Mahasiswa' }}</strong> ({{ $inspectConversation->buyer->nim ?? '-' }}) •
                            Penjual: <strong>{{ $inspectConversation->seller->name ?? 'Mahasiswa' }}</strong> ({{ $inspectConversation->seller->nim ?? '-' }})
                        </div>
                    </div>
                    <button
                        type="button"
                        wire:click="closeInspectChat"
                        class="p-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition cursor-pointer"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Product Reference Card -->
                @if($inspectConversation->product)
                    <div class="p-3 bg-slate-800/40 border-b border-slate-800 flex items-center justify-between gap-3 shrink-0">
                        <div class="flex items-center gap-3">
                            <img
                                src="{{ $inspectConversation->product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                alt="{{ $inspectConversation->product->title }}"
                                class="w-10 h-10 rounded-lg object-cover border border-slate-700"
                            />
                            <div>
                                <div class="text-xs font-bold text-white">{{ $inspectConversation->product->title }}</div>
                                <div class="text-[11px] font-mono text-[#EDAB0F]">Rp {{ number_format($inspectConversation->product->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-400">
                            Zona: {{ $inspectConversation->product->campus_zone }}
                        </span>
                    </div>
                @endif

                <!-- Chat Messages Scroll List -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar bg-slate-950/60">
                    @forelse($inspectConversation->messages as $m)
                        @php
                            $isBuyer = ($m->sender_id === $inspectConversation->buyer_id);
                        @endphp
                        <div class="flex flex-col {{ $isBuyer ? 'items-start' : 'items-end' }}">
                            <div class="text-[10px] font-bold mb-0.5 {{ $isBuyer ? 'text-blue-400' : 'text-emerald-400' }}">
                                {{ $m->sender->name ?? 'Mahasiswa' }} ({{ $isBuyer ? 'Pembeli' : 'Penjual' }})
                            </div>
                            <div class="max-w-md rounded-xl px-3.5 py-2 text-xs leading-relaxed {{ $isBuyer ? 'bg-slate-800 text-slate-200 border border-slate-700' : 'bg-slate-800/80 text-emerald-200 border border-emerald-500/30' }}">
                                <p class="whitespace-pre-wrap">{{ $m->message }}</p>
                            </div>
                            <div class="text-[10px] font-mono text-slate-500 mt-0.5">
                                {{ $m->created_at->format('d M Y • H:i') }}
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex items-center justify-center text-slate-500 text-xs">
                            Belum ada pesan yang terekam dalam sesi obrolan ini.
                        </div>
                    @endforelse
                </div>

                <!-- Modal Footer -->
                <div class="p-3 border-t border-slate-800 bg-slate-900 flex justify-end shrink-0">
                    <button
                        type="button"
                        wire:click="closeInspectChat"
                        class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold rounded-xl transition cursor-pointer"
                    >
                        Tutup Audit
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- 4. MODAL: TAKEDOWN PRODUK                                -->
    <!-- ======================================================== -->
    @if($showTakedownModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl animate-scale-up">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-white">Takedown Produk Katalog</h3>
                        <p class="text-[11px] text-slate-400">Sembunyikan produk yang melanggar aturan dari marketplace.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">Alasan Takedown</label>
                    <textarea
                        wire:model="takedownReason"
                        rows="3"
                        class="w-full p-3 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white placeholder:text-slate-400 focus:border-rose-500 outline-hidden"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        wire:click="closeTakedownModal"
                        class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        wire:click="takedownProduct"
                        class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl transition shadow-xs cursor-pointer"
                    >
                        Konfirmasi Takedown
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- 5. MODAL: PENYESUAIAN SALDO DOMPET USER                  -->
    <!-- ======================================================== -->
    @if($showBalanceModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl animate-scale-up">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-[#EDAB0F] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-white">Penyesuaian Saldo Dompet Kampus</h3>
                        <p class="text-[11px] text-slate-400">Tambahkan atau kurangkan saldo dompet untuk keperluan audit/pengujian.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Jenis Tindakan</label>
                        <select
                            wire:model="balanceAction"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        >
                            <option value="credit">Tambah Saldo (Kredit / Top-Up)</option>
                            <option value="debit">Kurangi Saldo (Debit)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Nominal (Rp)</label>
                        <input
                            type="number"
                            wire:model="balanceAmount"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden font-mono"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Catatan Admin</label>
                        <input
                            type="text"
                            wire:model="balanceNotes"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-[#EDAB0F] outline-hidden"
                        />
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        wire:click="closeBalanceModal"
                        class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        wire:click="applyBalanceAdjustment"
                        class="px-4 py-2 bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-bold rounded-xl transition shadow-xs cursor-pointer"
                    >
                        Terapkan Perubahan
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
