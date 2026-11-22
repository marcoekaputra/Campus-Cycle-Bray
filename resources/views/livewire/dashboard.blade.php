<div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <!-- Status / Alert Notifications -->
    @if (session('status'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center justify-between shadow-xs animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span>{{ session('status') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-semibold flex items-center justify-between shadow-xs animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-rose-100 text-[#641E28] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Profile Hero Banner (Untirta Modern Student Hub) -->
    <div class="bg-gradient-to-r from-[#641E28] via-[#782231] to-[#8C283A] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-rose-900/40">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4A151D] to-[#641E28] border border-white/20 flex items-center justify-center text-2xl font-black text-[#EDAB0F] shadow-md">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white">{{ $user->name }}</h1>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/15 text-rose-100 border border-white/20">
                            <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Civitas Aktif Untirta
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400/20 text-amber-300 border border-amber-400/30">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ $user->faculty ?? 'Fakultas Teknik' }}
                        </span>
                    </div>
                    <p class="text-slate-300 text-xs sm:text-sm mt-1.5 flex flex-wrap items-center gap-2 font-medium">
                        <span>NIM: <strong class="text-white font-mono">{{ $user->nim ?? '-' }}</strong></span>
                        <span>•</span>
                        <span>Kampus/Zona: <strong class="text-white">{{ $user->campus_zone ?? 'Cilegon (FT)' }}</strong></span>
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('product.create') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-[#EDAB0F] hover:bg-[#d97706] text-slate-950 transition flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Jual Barang</span>
                </a>
                <button
                    type="button"
                    wire:click="$set('showTopupModal', true)"
                    class="px-4 py-2 text-xs font-bold rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white transition flex items-center gap-1.5 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>Top Up Saldo</span>
                </button>
                <a href="/" class="px-4 py-2 text-xs font-bold rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 transition flex items-center gap-1.5 text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span>Lihat Katalog</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-rose-500/20 hover:bg-rose-500/40 border border-rose-400/30 transition text-rose-200 cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards (Marketplace Dashboard Overview) -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <!-- Saldo Dompet -->
        <div class="bg-white p-5 rounded-3xl shadow-xs border border-slate-200/80 hover:border-[#641E28]/40 transition group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Saldo Dompet</span>
                <span class="w-8 h-8 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center font-black text-xs group-hover:scale-105 transition">Rp</span>
            </div>
            <div class="text-2xl font-black text-slate-900 tracking-tight">
                Rp {{ number_format($wallet->balance, 0, ',', '.') }}
            </div>
            <button wire:click="$set('showTopupModal', true)" class="text-xs font-bold text-[#641E28] hover:text-[#4A151D] hover:underline mt-2 flex items-center gap-1 cursor-pointer">
                <span>+ Top Up via QRIS</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Omzet Penjualan -->
        <div class="bg-white p-5 rounded-3xl shadow-xs border border-slate-200/80 hover:border-[#641E28]/40 transition group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Omzet Penjualan</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center group-hover:scale-105 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-black text-[#641E28] tracking-tight">
                Rp {{ number_format($sellerStats->total_revenue ?? 0, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-slate-400 mt-2 font-medium">Dicairkan via Trigger Realtime</p>
        </div>

        <!-- Pesanan Pembelian -->
        <div class="bg-white p-5 rounded-3xl shadow-xs border border-slate-200/80 hover:border-[#641E28]/40 transition group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pesanan Beli</span>
                <span class="w-8 h-8 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center group-hover:scale-105 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-black text-slate-900 flex items-center gap-2 tracking-tight">
                <span>{{ $myBuyerOrders->count() }} Pesanan</span>
                @if ($activeOrdersCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-[#641E28]">
                        {{ $activeOrdersCount }} Aktif
                    </span>
                @endif
            </div>
            <p class="text-[11px] text-slate-400 mt-2 font-medium">Konfirmasi selesai untuk pencairan</p>
        </div>

        <!-- Tawaran Nego Masuk -->
        <div class="bg-white p-5 rounded-3xl shadow-xs border border-slate-200/80 hover:border-[#641E28]/40 transition group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Tawaran Nego</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center group-hover:scale-105 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-black text-slate-900 flex items-center gap-2 tracking-tight">
                <span>{{ $receivedOffers->count() }} Tawaran</span>
                @if ($pendingOffersCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 animate-pulse">
                        {{ $pendingOffersCount }} Baru
                    </span>
                @endif
            </div>
            <p class="text-[11px] text-slate-400 mt-2 font-medium">Persetujuan harga calon pembeli</p>
        </div>
    </div>

    <!-- Navigation Tabs (Modern Professional Pill Style) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        <button
            type="button"
            wire:click="$set('activeTab', 'offers')"
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 flex items-center gap-2 cursor-pointer {{ $activeTab === 'offers' ? 'bg-[#641E28] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
        >
            <svg class="w-4 h-4 {{ $activeTab === 'offers' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <span>Tawaran Masuk</span>
            @if ($pendingOffersCount > 0)
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-[#EDAB0F] text-slate-950 font-bold">
                    {{ $pendingOffersCount }}
                </span>
            @endif
        </button>

        <button
            type="button"
            wire:click="$set('activeTab', 'sales')"
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 flex items-center gap-2 cursor-pointer {{ $activeTab === 'sales' ? 'bg-[#641E28] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
        >
            <svg class="w-4 h-4 {{ $activeTab === 'sales' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span>Pesanan Penjualan (Input Resi / Plat)</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'sales' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }} font-bold">
                {{ $mySellerOrders->count() }}
            </span>
        </button>

        <button
            type="button"
            wire:click="$set('activeTab', 'orders')"
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 flex items-center gap-2 cursor-pointer {{ $activeTab === 'orders' ? 'bg-[#641E28] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
        >
            <svg class="w-4 h-4 {{ $activeTab === 'orders' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span>Pesanan Pembelian Saya</span>
            @if ($activeOrdersCount > 0)
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'orders' ? 'bg-[#EDAB0F] text-slate-950' : 'bg-rose-100 text-[#641E28]' }} font-bold">
                    {{ $activeOrdersCount }}
                </span>
            @endif
        </button>

        <button
            type="button"
            wire:click="$set('activeTab', 'wallet')"
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 flex items-center gap-2 cursor-pointer {{ $activeTab === 'wallet' ? 'bg-[#641E28] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
        >
            <svg class="w-4 h-4 {{ $activeTab === 'wallet' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <span>Dompet & Mutasi Saldo</span>
        </button>

        <button
            type="button"
            wire:click="$set('activeTab', 'stats')"
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 flex items-center gap-2 cursor-pointer {{ $activeTab === 'stats' ? 'bg-[#641E28] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
        >
            <svg class="w-4 h-4 {{ $activeTab === 'stats' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span>Performa Penjual</span>
        </button>

        <button
            type="button"
            wire:click="$set('activeTab', 'products')"
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 flex items-center gap-2 cursor-pointer {{ $activeTab === 'products' ? 'bg-[#641E28] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
        >
            <svg class="w-4 h-4 {{ $activeTab === 'products' ? 'text-[#EDAB0F]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <span>Barang Jualan Saya</span>
        </button>
    </div>

    <!-- TAB 1: TAWARAN MASUK -->
    @if ($activeTab === 'offers')
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </span>
                        Kelola Tawaran Masuk (Fitur Nego Cerdas)
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Respon tawaran calon pembeli. Menerima 1 tawaran akan otomatis mengunci harga dan menolak tawaran lain pada barang ini.
                    </p>
                </div>
            </div>

            @if ($receivedOffers->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach ($receivedOffers as $offer)
                        <div class="py-4 first:pt-0 last:pb-0 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <img
                                    src="{{ $offer->product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                    alt="{{ $offer->product->title }}"
                                    class="w-16 h-16 rounded-2xl object-cover shrink-0 border border-slate-100"
                                />
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 line-clamp-1">
                                        <a href="{{ route('product.detail', $offer->product->slug) }}" class="hover:text-[#641E28] transition">
                                            {{ $offer->product->title }}
                                        </a>
                                    </h4>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mt-1">
                                        <span class="font-bold text-slate-700">Pembeli: {{ $offer->buyer->name }}</span>
                                        <span>•</span>
                                        <span>Harga Katalog: <strike class="text-slate-400">Rp {{ number_format($offer->product->price, 0, ',', '.') }}</strike></span>
                                    </div>
                                    @if ($offer->message)
                                        <p class="mt-1.5 text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100 italic">
                                            "{{ $offer->message }}"
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-4 self-end md:self-center shrink-0">
                                <div class="text-right">
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Tawaran Harga</span>
                                    <div class="text-base font-black text-[#641E28]">
                                        Rp {{ number_format($offer->offered_price, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div>
                                    @if ($offer->status === 'pending')
                                        <div class="flex items-center gap-2">
                                            <button
                                                wire:click="acceptOffer({{ $offer->id }})"
                                                class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#641E28] hover:bg-[#4A151D] shadow-sm transition flex items-center gap-1.5 cursor-pointer"
                                            >
                                                <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span>Terima</span>
                                            </button>
                                            <button
                                                wire:click="rejectOffer({{ $offer->id }})"
                                                class="px-3.5 py-2 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition flex items-center gap-1 cursor-pointer"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                <span>Tolak</span>
                                            </button>
                                        </div>
                                    @elseif ($offer->status === 'accepted')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Diterima</span>
                                        </span>
                                    @elseif ($offer->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200">
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            <span>Ditolak</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-slate-400 space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-600">Belum ada tawaran harga masuk untuk produk Anda.</p>
                </div>
            @endif
        </div>
    @endif

    <!-- TAB 2: PESANAN PENJUALAN MASUK (INPUT RESI / PLAT PICK-UP) -->
    @if ($activeTab === 'sales')
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    Pesanan Penjualan Masuk (Input Resi Kurir / Plat Nomor Mobil Pick-up)
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Input nomor resi kurir (barang kecil) atau plat nomor pick-up (barang bulky) sebelum mengubah status pengiriman.
                </p>
            </div>

            @if ($mySellerOrders->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach ($mySellerOrders as $sale)
                        <div class="py-5 first:pt-0 last:pb-0 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <img
                                    src="{{ $sale->product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                    alt="{{ $sale->product->title }}"
                                    class="w-16 h-16 rounded-2xl object-cover shrink-0 border border-slate-100"
                                />
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs font-mono font-bold text-slate-900">{{ $sale->order_number }}</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $sale->status === 'completed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($sale->status === 'shipped' ? 'bg-indigo-50 text-indigo-800 border border-indigo-200' : ($sale->status === 'processing' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-700')) }}">
                                            Status: {{ $sale->status }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700">
                                            Tier: {{ strtoupper($sale->product->size_tier ?? 'small') }}
                                        </span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900 mt-1">
                                        {{ $sale->product->title }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Pembeli: <strong>{{ $sale->buyer->name }}</strong> (NIM: {{ $sale->buyer->nim ?? '-' }})
                                    </p>
                                    <p class="text-xs text-slate-600 mt-0.5">
                                        Metode: <strong class="uppercase text-[#641E28]">{{ $sale->delivery_method === 'delivery' ? 'Campus Delivery' : 'COD Kampus' }}</strong> • Lokasi: {{ $sale->meetup_location }}
                                    </p>

                                    @if ($sale->tracking_number)
                                        <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-rose-50 text-[#641E28] text-xs font-bold border border-rose-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                            </svg>
                                            <span>Bukti Pengiriman (Resi / Plat): <strong class="font-mono">{{ $sale->tracking_number }}</strong></span>
                                        </div>
                                    @endif

                                    @if ($sale->review)
                                        <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-50 text-amber-900 text-xs font-bold border border-amber-200">
                                            <svg class="w-3.5 h-3.5 text-amber-500 fill-amber-500" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span>Rating Pembeli: {{ $sale->review->rating }}/5</span>
                                            @if($sale->review->comment)
                                                <span class="text-slate-600 font-normal italic">"{{ Str::limit($sale->review->comment, 35) }}"</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-end sm:items-center gap-3 w-full lg:w-auto shrink-0">
                                <div class="text-right">
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Total Dana</span>
                                    <div class="text-base font-black text-[#641E28]">
                                        Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a
                                        href="{{ route('order.invoice.view', $sale->order_number) }}"
                                        target="_blank"
                                        class="px-3 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition flex items-center gap-1.5 shrink-0"
                                        title="Lihat Faktur Pembelian Resmi"
                                    >
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Faktur</span>
                                    </a>
                                </div>

                                @if ($sale->return_status === 'requested')
                                    <div class="mt-3 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 space-y-2 text-left w-full">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-amber-900 flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                                                <span>Pengajuan Return Pembeli: {{ $sale->return_reason }}</span>
                                            </span>
                                            <span class="text-[10px] font-bold bg-white text-amber-900 px-2 py-0.5 rounded border border-amber-200">
                                                {{ $sale->return_method === 'delivery' ? 'Kurir ' . strtoupper($sale->return_courier) . ' (Resi: ' . $sale->return_tracking_number . ')' : 'COD Kampus via Chat' }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-amber-800">{{ $sale->return_description }}</p>
                                        <button
                                            type="button"
                                            wire:click="confirmReturnReceivedBySeller({{ $sale->id }})"
                                            wire:confirm="Konfirmasi bahwa Anda telah menerima fisik barang return dari pembeli?"
                                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold text-white bg-amber-700 hover:bg-amber-800 transition shadow-xs cursor-pointer flex items-center gap-1.5"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Konfirmasi Barang Return Telah Diterima</span>
                                        </button>
                                    </div>
                                @elseif ($sale->return_status === 'approved_by_seller')
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-900 border border-blue-200">
                                        Barang Diterima &bull; Menunggu Crosscheck Admin
                                    </span>
                                @elseif ($sale->return_status === 'completed')
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-900 border border-emerald-200">
                                        Return Selesai
                                    </span>
                                @endif

                                <!-- Form Input Resi / Plat Nomor Mobil Pick-up -->
                                @if ($sale->status === 'processing' || $sale->status === 'paid' || $sale->status === 'pending')
                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <div class="relative flex-1 sm:w-56">
                                            <input
                                                type="text"
                                                wire:model="inputTrackingNumber.{{ $sale->id }}"
                                                placeholder="{{ $sale->product->size_tier === 'bulky' ? 'Plat Pick-up (A 8123 AB)' : 'No. Resi (UNT-001)' }}"
                                                class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-mono"
                                            />
                                            @error("tracking_{$sale->id}")
                                                <span class="text-[10px] text-rose-600 block mt-0.5">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="shipOrder({{ $sale->id }})"
                                            class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#641E28] hover:bg-[#4A151D] shadow-xs transition shrink-0 cursor-pointer"
                                        >
                                            Kirim
                                        </button>
                                    </div>
                                @elseif ($sale->status === 'shipped')
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-800 border border-indigo-200 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Sedang Dikirim</span>
                                    </span>
                                @elseif ($sale->status === 'completed')
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Selesai & Dana Cair</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-slate-400 space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-600">Belum ada pesanan masuk untuk barang jualan Anda.</p>
                </div>
            @endif
        </div>
    @endif

    <!-- TAB 3: PESANAN PEMBELIAN SAYA -->
    @if ($activeTab === 'orders')
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </span>
                    Pesanan Pembelian Saya
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Setelah barang sampai via kurir/pick-up atau selesai COD, klik tombol <strong>"Barang Diterima (Selesai)"</strong> untuk mencairkan saldo ke dompet penjual via Database Trigger secara realtime.
                </p>
            </div>

            @if ($myBuyerOrders->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach ($myBuyerOrders as $order)
                        <div class="py-4 first:pt-0 last:pb-0 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <img
                                    src="{{ $order->product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                    alt="{{ $order->product->title }}"
                                    class="w-16 h-16 rounded-2xl object-cover shrink-0 border border-slate-100"
                                />
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-mono font-bold text-slate-900">{{ $order->order_number }}</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($order->status === 'shipped' ? 'bg-indigo-50 text-indigo-800 border border-indigo-200' : 'bg-amber-50 text-amber-800 border border-amber-200') }}">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900 mt-1">
                                        {{ $order->product->title }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Penjual: <strong>{{ $order->seller->name }}</strong> • {{ $order->meetup_location }}
                                    </p>

                                    @if ($order->tracking_number)
                                        <div class="mt-1.5 inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-rose-50 text-[#641E28] text-xs font-bold border border-rose-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                            </svg>
                                            <span>Plat / Resi Pengiriman: <strong class="font-mono">{{ $order->tracking_number }}</strong></span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-4 self-end md:self-center shrink-0">
                                <div class="text-right">
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Total Tagihan</span>
                                    <div class="text-base font-black text-[#641E28]">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 flex-wrap justify-end">
                                    <a
                                        href="{{ route('order.invoice.view', $order->order_number) }}"
                                        target="_blank"
                                        class="px-3 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition flex items-center gap-1.5 shrink-0"
                                        title="Lihat Faktur Pembelian Resmi"
                                    >
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Faktur</span>
                                    </a>

                                    @if ($order->isReturnable())
                                        <button
                                            type="button"
                                            wire:click="openReturnModal({{ $order->id }})"
                                            class="px-3 py-2 rounded-xl text-xs font-bold text-amber-900 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition flex items-center gap-1.5 cursor-pointer"
                                            title="Ajukan Komplain & Pengembalian Barang (Non-COD)"
                                        >
                                            <svg class="w-3.5 h-3.5 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                                            </svg>
                                            <span>Ajukan Return</span>
                                        </button>
                                    @endif

                                    @if ($order->return_status === 'requested')
                                        <span class="px-2.5 py-1.5 rounded-xl text-[11px] font-bold bg-amber-50 text-amber-900 border border-amber-200 flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                            <span>Return Diajukan</span>
                                        </span>
                                    @elseif ($order->return_status === 'approved_by_seller')
                                        <span class="px-2.5 py-1.5 rounded-xl text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                            <span>Barang Diterima Penjual</span>
                                        </span>
                                    @elseif ($order->return_status === 'completed')
                                        <span class="px-2.5 py-1.5 rounded-xl text-[11px] font-bold bg-emerald-50 text-emerald-900 border border-emerald-200 flex items-center gap-1">
                                            <span>Refund Selesai</span>
                                        </span>
                                    @elseif ($order->status !== 'completed' && $order->status !== 'cancelled' && $order->status !== 'return_requested')
                                        <button
                                            wire:click="completeOrder({{ $order->id }})"
                                            wire:confirm="Pastikan Anda sudah menerima barang dari penjual atau kurir pick-up. Setelah konfirmasi, dana otomatis dicairkan ke penjual via trigger. Lanjutkan?"
                                            class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#641E28] hover:bg-[#4A151D] shadow-xs transition flex items-center gap-1.5 cursor-pointer"
                                        >
                                            <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Barang Diterima (Selesai)</span>
                                        </button>
                                    @elseif ($order->status === 'completed')
                                        @if ($order->review)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                                <svg class="w-3.5 h-3.5 text-amber-500 fill-amber-500" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <span>{{ $order->review->rating }}/5 (Diulas)</span>
                                            </span>
                                        @else
                                            <button
                                                type="button"
                                                wire:click="openReviewModal({{ $order->id }})"
                                                class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-950 bg-[#EDAB0F] hover:bg-[#d97706] shadow-xs transition flex items-center gap-1.5 cursor-pointer"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <span>Beri Rating</span>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-slate-400 space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-600">Anda belum pernah melakukan pemesanan barang.</p>
                </div>
            @endif
        </div>
    @endif

    <!-- TAB 4: DOMPET DIGITAL & MUTASI -->
    @if ($activeTab === 'wallet')
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </span>
                        Dompet Mahasiswa & Mutasi Saldo
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Terintegrasi aman dengan transaksi marketplace kampus dan pencairan saldo otomatis.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Saldo Aktif</span>
                        <span class="text-xl font-black text-slate-900">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</span>
                    </div>
                    <button
                        type="button"
                        wire:click="$set('showTopupModal', true)"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#641E28] hover:bg-[#4A151D] shadow-xs transition cursor-pointer"
                    >
                        + Top Up Saldo
                    </button>
                </div>
            </div>

            @if ($walletMutations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider text-[10px]">
                                <th class="pb-3 font-bold">Waktu</th>
                                <th class="pb-3 font-bold">Tipe</th>
                                <th class="pb-3 font-bold">Keterangan</th>
                                <th class="pb-3 font-bold">Nominal</th>
                                <th class="pb-3 font-bold">Saldo Sebelum</th>
                                <th class="pb-3 font-bold">Saldo Sesudah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @foreach ($walletMutations as $mut)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 text-slate-400 font-normal">
                                        {{ $mut->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $mut->type === 'credit' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-[#641E28] border border-rose-200' }}">
                                            {{ $mut->type === 'credit' ? '+ Masuk' : '- Keluar' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-slate-900 font-bold">
                                        {{ $mut->description }}
                                    </td>
                                    <td class="py-3 font-bold {{ $mut->type === 'credit' ? 'text-emerald-700' : 'text-[#641E28]' }}">
                                        {{ $mut->type === 'credit' ? '+' : '-' }} Rp {{ number_format($mut->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 text-slate-500 font-mono">
                                        Rp {{ number_format($mut->balance_before, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 font-bold text-slate-900 font-mono">
                                        Rp {{ number_format($mut->balance_after, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 text-slate-400 space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-600">Belum ada riwayat mutasi saldo di dompet Anda.</p>
                </div>
            @endif
        </div>
    @endif

    <!-- TAB 5: STATISTIK PENJUAL (DARI VIEW v_seller_statistics) -->
    @if ($activeTab === 'stats')
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </span>
                    Statistik Penjual (Live View: v_seller_statistics)
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Data agregasi realtime performa penjualan Anda dari database view <code>v_seller_statistics</code>.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 rounded-2xl bg-rose-50/50 border border-rose-200">
                    <span class="text-[11px] font-bold text-[#641E28] uppercase tracking-wider block">Total Pendapatan (Omzet)</span>
                    <div class="text-3xl font-black text-[#641E28] mt-2 tracking-tight">
                        Rp {{ number_format($sellerStats->total_revenue ?? 0, 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] text-slate-500 mt-1 block font-medium">Dari pesanan completed</span>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider block">Pesanan Selesai</span>
                    <div class="text-3xl font-black text-slate-900 mt-2 tracking-tight">
                        {{ $sellerStats->completed_orders ?? 0 }} Pesanan
                    </div>
                    <span class="text-[11px] text-slate-500 mt-1 block font-medium">Total masuk: {{ $sellerStats->total_orders ?? 0 }}</span>
                </div>

                <div class="p-6 rounded-2xl bg-emerald-50/50 border border-emerald-200">
                    <span class="text-[11px] font-bold text-emerald-900 uppercase tracking-wider block">Produk Terjual</span>
                    <div class="text-3xl font-black text-emerald-950 mt-2 tracking-tight">
                        {{ $sellerStats->sold_products ?? 0 }} / {{ $sellerStats->total_products ?? 0 }}
                    </div>
                    <span class="text-[11px] text-emerald-700 mt-1 block font-medium">Aktif dijual: {{ $sellerStats->active_products ?? 0 }}</span>
                </div>

                <div class="p-6 rounded-2xl bg-amber-50/50 border border-amber-200">
                    <span class="text-[11px] font-bold text-amber-900 uppercase tracking-wider block">Rating & Reputasi Toko</span>
                    <div class="text-3xl font-black text-amber-950 mt-2 tracking-tight flex items-baseline gap-1.5">
                        <div class="flex items-center gap-1 text-[#EDAB0F]">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span>{{ number_format($sellerStats->average_rating ?? 0, 1) }}</span>
                        </div>
                        <span class="text-xs font-bold text-amber-700">/ 5.0</span>
                    </div>
                    <span class="text-[11px] text-amber-800 mt-1 block font-medium">Berdasarkan {{ $sellerStats->total_reviews ?? 0 }} ulasan pembeli</span>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 6: BARANG DAGANGAN SAYA -->
    @if ($activeTab === 'products')
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </span>
                    Katalog Barang Dagangan Saya
                </h2>
                <a href="{{ route('product.create') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-[#641E28] text-white hover:bg-[#4A151D] shadow-xs transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Upload Barang Baru</span>
                </a>
            </div>

            @if ($myProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($myProducts as $prod)
                        <div class="p-3.5 rounded-2xl border border-slate-200 flex items-center gap-3.5 bg-slate-50/50 hover:bg-white hover:border-[#641E28]/40 transition">
                            <img
                                src="{{ $prod->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                alt="{{ $prod->title }}"
                                class="w-16 h-16 rounded-xl object-cover shrink-0 border border-slate-200"
                            />
                            <div class="overflow-hidden flex-1">
                                <h4 class="text-xs font-bold text-slate-900 truncate">
                                    <a href="{{ route('product.detail', $prod->slug) }}" class="hover:text-[#641E28]">
                                        {{ $prod->title }}
                                    </a>
                                </h4>
                                <p class="text-sm font-black text-[#641E28] mt-0.5">
                                    Rp {{ number_format($prod->price, 0, ',', '.') }}
                                </p>
                                <div class="flex flex-wrap items-center gap-1.5 mt-1.5 text-[10px]">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $prod->status === 'sold' ? 'bg-rose-100 text-[#641E28]' : ($prod->status === 'reserved' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                        {{ $prod->status }}
                                    </span>
                                    <span class="text-slate-500 font-bold">Tier: {{ strtoupper($prod->size_tier ?? 'small') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 py-6 text-center font-medium">Anda belum mengunggah barang dagangan.</p>
            @endif
        </div>
    @endif

    <!-- Modal Top Up Saldo Dompet Mahasiswa -->
    @if ($showTopupModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 space-y-4 animate-scale-up">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </span>
                        <h3 class="font-bold text-slate-900 text-sm">Top Up Saldo via QRIS</h3>
                    </div>
                    <button wire:click="$set('showTopupModal', false)" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700">Pilih Nominal Top Up</label>
                    <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '50000')"
                            class="p-2.5 rounded-xl border text-center transition cursor-pointer {{ $topupAmount === '50000' ? 'border-[#641E28] bg-rose-50 text-[#641E28] font-black' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 50.000
                        </button>
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '100000')"
                            class="p-2.5 rounded-xl border text-center transition cursor-pointer {{ $topupAmount === '100000' ? 'border-[#641E28] bg-rose-50 text-[#641E28] font-black' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 100.000
                        </button>
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '200000')"
                            class="p-2.5 rounded-xl border text-center transition cursor-pointer {{ $topupAmount === '200000' ? 'border-[#641E28] bg-rose-50 text-[#641E28] font-black' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 200.000
                        </button>
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '500000')"
                            class="p-2.5 rounded-xl border text-center transition cursor-pointer {{ $topupAmount === '500000' ? 'border-[#641E28] bg-rose-50 text-[#641E28] font-black' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 500.000
                        </button>
                    </div>

                    <div>
                        <label for="topupAmountDashInput" class="block text-xs font-bold text-slate-700 mb-1">Nominal Lain (Rp)</label>
                        <input
                            type="number"
                            id="topupAmountDashInput"
                            wire:model="topupAmount"
                            class="block w-full px-3 py-2 text-sm rounded-xl border border-slate-300 font-bold focus:ring-[#641E28] focus:border-[#641E28] font-mono"
                        />
                        @error('topupAmount')
                            <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button
                        type="button"
                        wire:click="$set('showTopupModal', false)"
                        class="flex-1 py-2.5 px-3 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        wire:click="performTopup"
                        wire:loading.attr="disabled"
                        class="flex-1 py-2.5 px-3 rounded-xl bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-bold shadow-xs flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <span wire:loading.remove wire:target="performTopup">Bayar via QRIS</span>
                        <span wire:loading wire:target="performTopup">Membuat QR...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal QRIS Khusus Top Up Saldo -->
    @if ($showTopupQrisModal && $activeTopupQris)
        <div wire:poll.3s="checkTopupStatus" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-md flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 space-y-4 animate-scale-up text-center">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2 text-left">
                        <div class="px-2 py-0.5 bg-red-600 text-white font-black text-xs rounded tracking-wider">
                            QRIS
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">Top Up CampusWallet</h3>
                    </div>
                    <button wire:click="closeTopupQrisModal" class="w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="bg-rose-50/70 p-3 rounded-2xl border border-rose-200">
                    <span class="text-[10px] font-bold text-[#641E28] uppercase tracking-wider block">Nominal Top Up</span>
                    <span class="text-xl font-black text-[#641E28] block mt-0.5">
                        Rp {{ number_format($activeTopupQris['gross_amount'], 0, ',', '.') }}
                    </span>
                </div>

                <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs flex flex-col items-center">
                    <img
                        src="{{ $activeTopupQris['qr_url'] }}"
                        alt="QRIS Top Up"
                        class="w-52 h-52 object-contain mx-auto rounded-lg"
                    />

                    <div class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 text-[#641E28] text-[10px] font-bold border border-rose-200">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-[#641E28]"></span>
                        </span>
                        <span>Menunggu Scan QRIS (Auto-Detect)...</span>
                    </div>
                </div>

                <div class="space-y-2 pt-1">
                    <button
                        type="button"
                        wire:click="simulateSuccessTopup"
                        wire:loading.attr="disabled"
                        class="w-full py-2.5 px-3 rounded-xl bg-[#EDAB0F] hover:bg-[#d97706] text-slate-950 font-bold text-xs shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Simulasi Top Up Berhasil (Sandbox)</span>
                    </button>

                    <button
                        type="button"
                        wire:click="closeTopupQrisModal"
                        class="w-full py-2 px-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold cursor-pointer"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal QRIS Bayar Pesanan Pending -->
    @if ($showOrderQrisModal && $activeOrderQris)
        <div wire:poll.3s="checkOrderPaymentStatus" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-md flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 space-y-4 animate-scale-up text-center">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2 text-left">
                        <div class="px-2 py-0.5 bg-red-600 text-white font-black text-xs rounded tracking-wider">
                            QRIS
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">Bayar Pesanan #{{ $activeOrderQris['order_id'] }}</h3>
                    </div>
                    <button wire:click="closeOrderQrisModal" class="w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="bg-rose-50/70 p-3 rounded-2xl border border-rose-200">
                    <span class="text-[10px] font-bold text-[#641E28] uppercase tracking-wider block">Total Tagihan</span>
                    <span class="text-xl font-black text-[#641E28] block mt-0.5">
                        Rp {{ number_format($activeOrderQris['gross_amount'], 0, ',', '.') }}
                    </span>
                </div>

                <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs flex flex-col items-center">
                    <img
                        src="{{ $activeOrderQris['qr_url'] }}"
                        alt="QRIS Pesanan"
                        class="w-52 h-52 object-contain mx-auto rounded-lg"
                    />

                    <div class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 text-[#641E28] text-[10px] font-bold border border-rose-200">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-[#641E28]"></span>
                        </span>
                        <span>Menunggu Scan QRIS...</span>
                    </div>
                </div>

                <div class="space-y-2 pt-1">
                    <button
                        type="button"
                        wire:click="simulateSuccessOrderPayment"
                        wire:loading.attr="disabled"
                        class="w-full py-2.5 px-3 rounded-xl bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-bold shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Simulasi Sukses Bayar (Sandbox)</span>
                    </button>

                    <button
                        type="button"
                        wire:click="closeOrderQrisModal"
                        class="w-full py-2 px-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold cursor-pointer"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Rating & Ulasan (Review) -->
    @if ($showReviewModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-md flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 space-y-5 animate-scale-up text-left">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-[#EDAB0F] flex items-center justify-center">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base">Beri Penilaian & Ulasan</h3>
                            <p class="text-[11px] text-slate-500">Ulasan Anda membantu membangun reputasi penjual di Kampus Untirta</p>
                        </div>
                    </div>
                    <button wire:click="closeReviewModal" class="w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="text-center space-y-2 py-1">
                    <span class="text-xs font-bold text-slate-600 block">Pilih Bintang Kepuasan:</span>
                    
                    <!-- Star Buttons -->
                    <div class="flex items-center justify-center gap-2 pt-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button
                                type="button"
                                wire:click="$set('reviewRating', {{ $i }})"
                                class="p-1 transition transform hover:scale-125 focus:outline-none cursor-pointer {{ $reviewRating >= $i ? 'text-[#EDAB0F]' : 'text-slate-300' }}"
                            >
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>

                    <div class="pt-1">
                        <span class="inline-block text-xs font-bold text-amber-900 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                            {{ match($reviewRating) {
                                5 => 'Bintang 5: Sangat Puas & Rekomended',
                                4 => 'Bintang 4: Puas (Barang Bagus)',
                                3 => 'Bintang 3: Cukup (Sesuai Harga)',
                                2 => 'Bintang 2: Kurang Memuaskan',
                                default => 'Bintang 1: Kecewa',
                            } }}
                        </span>
                    </div>
                    @error('reviewRating')
                        <span class="text-xs text-rose-600 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Ulasan Pengalaman Transaksi
                    </label>
                    <textarea
                        wire:model="reviewComment"
                        rows="3"
                        placeholder="Contoh: Barang sesuai deskripsi dan foto real, penjual cepat tanggap dan ramah saat transaksi..."
                        class="w-full text-xs p-3 rounded-2xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] resize-none"
                    ></textarea>
                    @error('reviewComment')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button
                        type="button"
                        wire:click="submitReview"
                        wire:loading.attr="disabled"
                        class="flex-1 py-2.5 px-4 rounded-xl bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-bold shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <span>Kirim Penilaian</span>
                    </button>
                    <button
                        type="button"
                        wire:click="closeReviewModal"
                        class="py-2.5 px-4 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold cursor-pointer"
                    >
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL 4: PENGAJUAN KOMPLAIN & RETURN BARANG -->
    @if ($showReturnModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-100 space-y-5 animate-scale-up text-left">
                <!-- Header Modal Return -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-800 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base">Ajukan Komplain & Return</h3>
                            <p class="text-[11px] text-slate-500">Khusus pesanan pengiriman ekspedisi / non-COD</p>
                        </div>
                    </div>
                    <button wire:click="closeReturnModal" class="w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="submitReturnRequest" class="space-y-4">
                    <!-- Alasan Return -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Alasan Pengajuan Return <span class="text-rose-500">*</span>
                        </label>
                        <select
                            wire:model="returnReason"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold focus:ring-[#641E28] focus:border-[#641E28]"
                        >
                            <option value="Barang Rusak / Cacat Pengiriman">Barang Rusak / Cacat Pengiriman</option>
                            <option value="Barang Tidak Sesuai Foto atau Deskripsi">Barang Tidak Sesuai Foto atau Deskripsi</option>
                            <option value="Kelengkapan / Aksesori Tidak Lengkap">Kelengkapan / Aksesori Tidak Lengkap</option>
                            <option value="Barang Tidak Berfungsi Normal">Barang Tidak Berfungsi Normal</option>
                        </select>
                        @error('returnReason')
                            <span class="text-xs text-rose-600 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Metode Pengembalian Barang (COD via chat atau Jasa Delivery Tersistem) -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Pilih Metode Pengembalian Barang <span class="text-rose-500">*</span>
                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <label class="p-3 rounded-2xl border-2 cursor-pointer transition {{ $returnDeliveryMethod === 'cod' ? 'border-[#641E28] bg-rose-50/40 shadow-xs' : 'border-slate-200 hover:border-slate-300' }}">
                                <div class="flex items-start gap-2">
                                    <input type="radio" wire:model.live="returnDeliveryMethod" value="cod" class="mt-0.5 text-[#641E28] focus:ring-[#641E28]" />
                                    <div>
                                        <span class="text-xs font-extrabold text-slate-900 block">COD Kampus (via Chat)</span>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Janji temu langsung dengan penjual di area kampus. Bebas Ongkir (Rp 0).</p>
                                    </div>
                                </div>
                            </label>

                            <label class="p-3 rounded-2xl border-2 cursor-pointer transition {{ $returnDeliveryMethod === 'delivery' ? 'border-[#641E28] bg-rose-50/40 shadow-xs' : 'border-slate-200 hover:border-slate-300' }}">
                                <div class="flex items-start gap-2">
                                    <input type="radio" wire:model.live="returnDeliveryMethod" value="delivery" class="mt-0.5 text-[#641E28] focus:ring-[#641E28]" />
                                    <div>
                                        <span class="text-xs font-extrabold text-slate-900 block">Jasa Kurir Tersistem</span>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Kirim balik via ekspedisi. Ongkir ditanggung pembeli (Rp 10.000).</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @if ($returnDeliveryMethod === 'delivery')
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                                <label class="block text-[11px] font-bold text-slate-700">Pilih Ekspedisi Pengembalian:</label>
                                <select wire:model="returnCourier" class="w-full text-xs px-3 py-2 rounded-lg border border-slate-300 font-bold">
                                    <option value="jnt">J&T Express (EZ)</option>
                                    <option value="jne">JNE Express (REG)</option>
                                    <option value="sicepat">SiCepat Ekspres (HALU)</option>
                                    <option value="untirta_express">Kurir Kilat Untirta</option>
                                </select>
                                <p class="text-[10px] text-slate-500">
                                    Nomor resi return resmi akan otomatis dibuat sistem setelah pengajuan Anda dikirimkan.
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Deskripsi Rinci Masalah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Jelaskan Kendala Barang <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            wire:model="returnDescription"
                            rows="3"
                            placeholder="Jelaskan secara detail kerusakan atau ketidaksesuaian barang yang diterima..."
                            class="w-full text-xs p-3 rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28]"
                            required
                        ></textarea>
                        @error('returnDescription')
                            <span class="text-xs text-rose-600 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Foto Bukti -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Foto Bukti Kerusakan / Unboxing (Opsional)
                        </label>
                        <input
                            type="file"
                            wire:model="returnProofImage"
                            accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-[#641E28] hover:file:bg-rose-100 cursor-pointer"
                        />
                        @error('returnProofImage')
                            <span class="text-xs text-rose-600 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Notice Skema Refund -->
                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-[11px] text-amber-900 space-y-1">
                        <strong class="font-bold block text-amber-950">Skema Pengembalian Dana (Refund Escrow):</strong>
                        <p class="leading-relaxed">
                            Setelah penjual menerima barang dan Admin menyetujui crosscheck return, saldo pembelian akan dikembalikan langsung ke dompet pembeli <strong>setelah dipotong Application Fee (1.5%)</strong>.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 py-2.5 px-4 rounded-xl bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-bold shadow-md transition flex items-center justify-center gap-1.5 cursor-pointer"
                        >
                            <span wire:loading.remove wire:target="submitReturnRequest">Kirim Pengajuan Return</span>
                            <span wire:loading wire:target="submitReturnRequest">Memproses...</span>
                        </button>
                        <button
                            type="button"
                            wire:click="closeReturnModal"
                            class="py-2.5 px-4 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold cursor-pointer"
                        >
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
