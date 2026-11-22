<div class="max-w-[1536px] mx-auto w-full px-4 sm:px-6 lg:px-8 space-y-6">

    <!-- 1. E-Commerce Hero Promo Banners (Sleek, Visual, E-Commerce Modern) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 sm:gap-4 items-stretch">
        <!-- Main Promo Banner (Spans 8 cols) -->
        <div class="lg:col-span-8 relative overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-r from-[#641E28] via-[#7A2332] to-[#8F2B3C] p-4 sm:p-8 text-white shadow-md flex flex-col justify-between">
            <!-- Decorative circle glow -->
            <div class="absolute -right-10 -bottom-10 w-40 sm:w-60 h-40 sm:h-60 rounded-full bg-[#EDAB0F]/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-2 sm:space-y-3 max-w-xl">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-white/10 backdrop-blur-md text-[#EDAB0F] text-[10px] sm:text-xs font-bold border border-white/10">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <span>Marketplace Sirkular Untirta</span>
                </div>

                <h1 class="text-lg sm:text-2xl lg:text-4xl font-black tracking-tight leading-tight text-white">
                    Ekosistem Jual Beli Pre-Loved Mahasiswa Untirta
                </h1>

                <p class="text-[11px] sm:text-sm text-rose-100/90 font-normal leading-relaxed line-clamp-2 sm:line-clamp-none">
                    Pusat transaksi perlengkapan kuliah, jas lab FT, buku diktat & alat kos. Dijamin aman dengan sistem Escrow dan titik COD kampus.
                </p>

                <div class="pt-1 sm:pt-2 flex flex-wrap items-center gap-2 sm:gap-3">
                    <a
                        href="{{ route('product.create') }}"
                        class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full bg-[#EDAB0F] hover:bg-[#d97706] text-slate-950 font-black text-xs shadow-md transition-all active:scale-95 flex items-center gap-1.5"
                    >
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Jual Barang</span>
                    </a>
                    <button
                        type="button"
                        wire:click="resetFilters"
                        class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-full bg-white/15 hover:bg-white/25 text-white font-bold text-xs border border-white/20 transition-all flex items-center gap-1.5 cursor-pointer"
                    >
                        <span>Semua Barang</span>
                        <span>→</span>
                    </button>
                </div>
            </div>

            <!-- Trust Bar Minimal -->
            <div class="relative z-10 mt-4 sm:mt-6 pt-2.5 sm:pt-3 border-t border-white/10 flex flex-wrap items-center justify-between gap-2 text-[10px] sm:text-[11px] text-rose-100/80">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Mahasiswa PDDIKTI</span>
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Dynamic Nego</span>
                </span>
                <span class="hidden sm:flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>QRIS Dinamis</span>
                </span>
            </div>
        </div>

        <!-- 2 Side Promo Tiles (Hidden on small mobile to prioritize product catalog) -->
        <div class="hidden sm:flex lg:col-span-4 flex-col gap-3 sm:gap-4">
            <!-- Tile 1: Praktikum FT Cilegon -->
            <div class="flex-1 p-5 rounded-3xl bg-white border border-slate-200/80 shadow-xs hover:border-[#641E28]/40 transition-all flex flex-col justify-between group">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#641E28] bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200 inline-block mb-1">
                            FT Cilegon
                        </span>
                        <h2 class="text-sm font-bold text-slate-900 group-hover:text-[#641E28] transition">
                            Alat Praktikum & Lab Teknik
                        </h2>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                            Helm SNI proyek, kalkulator Casio Classwiz, jas lab & penggaris T-square.
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-[#641E28] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <button
                        type="button"
                        wire:click="filterFaculty('FT')"
                        class="w-full py-2 px-3 rounded-full bg-slate-100 hover:bg-[#641E28] hover:text-white text-slate-800 text-xs font-bold transition flex items-center justify-center gap-1 cursor-pointer"
                    >
                        <span>Lihat Barang FT</span>
                        <span>→</span>
                    </button>
                </div>
            </div>

            <!-- Tile 2: Perlengkapan Kosan Murah -->
            <div class="flex-1 p-5 rounded-3xl bg-white border border-slate-200/80 shadow-xs hover:border-[#641E28]/40 transition-all flex flex-col justify-between group">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200 inline-block mb-1">
                            Pindahan Kos
                        </span>
                        <h2 class="text-sm font-bold text-slate-900 group-hover:text-[#641E28] transition">
                            Perabotan Kos Siap Angkut
                        </h2>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                            Dispenser, rice cooker, kipas angin, rak sepatu & kasur lipat hemat.
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-800 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <button
                        type="button"
                        wire:click="filterCategory(3)"
                        class="w-full py-2 px-3 rounded-full bg-slate-100 hover:bg-[#641E28] hover:text-white text-slate-800 text-xs font-bold transition flex items-center justify-center gap-1 cursor-pointer"
                    >
                        <span>Lihat Alat Kosan</span>
                        <span>→</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. KATEGORI PILIHAN (Classic E-Commerce Icon Grid - Tokopedia/Shopee Style) -->
    <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-5 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between mb-2.5 sm:mb-4">
            <h2 class="text-xs sm:text-sm font-bold text-slate-900 flex items-center gap-1.5">
                <span>Kategori Pilihan Mahasiswa</span>
            </h2>
            @if ($selectedCategory)
                <button
                    wire:click="filterCategory(null)"
                    class="text-[11px] sm:text-xs font-bold text-[#641E28] hover:underline flex items-center gap-1 cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Semua Kategori</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-6 gap-2 sm:gap-3">
            @foreach ($categories as $cat)
                @php
                    $isSelected = ($selectedCategory === $cat->id);
                @endphp
                <button
                    type="button"
                    wire:click="filterCategory({{ $cat->id }})"
                    class="p-2 sm:p-3 rounded-xl sm:rounded-2xl text-center border transition-all flex flex-col items-center justify-center gap-1.5 sm:gap-2 group cursor-pointer {{ $isSelected ? 'bg-rose-50/70 border-[#641E28] ring-2 ring-[#641E28]/20 shadow-xs' : 'bg-slate-50/60 hover:bg-slate-100 border-slate-200 hover:border-slate-300' }}"
                >
                    <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl flex items-center justify-center transition-transform group-hover:scale-105 {{ $isSelected ? 'bg-[#641E28] text-[#EDAB0F] shadow-xs' : 'bg-white shadow-xs text-slate-700' }}">
                        @if (str_contains($cat->name, 'Buku') || str_contains($cat->name, 'Diktat'))
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        @elseif (str_contains($cat->name, 'Elektronik') || str_contains($cat->name, 'Gadget'))
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        @elseif (str_contains($cat->name, 'Kos'))
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        @elseif (str_contains($cat->name, 'Praktikum') || str_contains($cat->name, 'Lab'))
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        @elseif (str_contains($cat->name, 'Transportasi'))
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        @elseif (str_contains($cat->name, 'Fashion') || str_contains($cat->name, 'Merchandise'))
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        @endif
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold leading-tight {{ $isSelected ? 'text-[#641E28]' : 'text-slate-700' }}">
                        {{ $cat->name }}
                    </span>
                    <span class="text-[9px] sm:text-[10px] font-semibold text-slate-400">
                        {{ $cat->products_count }} barang
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- 3. FAKULTAS STRIP (Pills Minimal & Rapi) -->
    <div class="bg-white px-3 py-2 sm:px-4 sm:py-3 rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-2 overflow-x-auto no-scrollbar">
        <span class="text-xs font-bold text-slate-700 whitespace-nowrap shrink-0 flex items-center gap-1.5 mr-1">
            <svg class="w-4 h-4 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="hidden sm:inline">Fakultas:</span>
        </span>

        <button
            type="button"
            wire:click="filterFaculty('')"
            class="px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full text-[11px] sm:text-xs font-bold whitespace-nowrap transition shrink-0 cursor-pointer {{ empty($selectedFaculty) ? 'bg-[#641E28] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
        >
            Semua Fakultas
        </button>

        @foreach ($faculties as $fac)
            @php
                $isActive = ($selectedFaculty === $fac['code']);
            @endphp
            <button
                type="button"
                wire:click="filterFaculty('{{ $fac['code'] }}')"
                class="px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full text-[11px] sm:text-xs font-bold whitespace-nowrap transition shrink-0 flex items-center gap-1 cursor-pointer {{ $isActive ? 'bg-[#641E28] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
            >
                <span>{{ $fac['code'] }}</span>
                @if ($isActive)
                    <svg class="w-3 h-3 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                @endif
            </button>
        @endforeach
    </div>

    <!-- 4. E-COMMERCE MAIN SECTION: SIDEBAR + PRODUCT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6 items-start">

        <!-- SIDEBAR FILTER (Hidden on Mobile, Visible on Desktop lg+) -->
        <aside class="hidden lg:block lg:col-span-1 space-y-4">
            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs space-y-5 sticky top-24">

                <!-- Header Filter -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#641E28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filter Produk</span>
                    </span>
                    @if ($selectedCategory || $selectedZone || $selectedFaculty || $selectedTier || $search || $sortBy !== 'latest')
                        <button wire:click="resetFilters" class="text-xs text-[#641E28] hover:underline font-bold cursor-pointer">
                            Reset
                        </button>
                    @endif
                </div>

                <!-- 1. Lokasi Kampus COD -->
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Lokasi Kampus COD</span>
                    </label>
                    <div class="space-y-1 text-xs">
                        <button
                            type="button"
                            wire:click="filterZone('')"
                            class="w-full text-left px-3 py-1.5 rounded-xl font-semibold flex items-center justify-between transition cursor-pointer {{ empty($selectedZone) ? 'bg-rose-50 text-[#641E28] font-bold border border-rose-200' : 'text-slate-600 hover:bg-slate-50' }}"
                        >
                            <span>Semua Kampus Untirta</span>
                            @if (empty($selectedZone))
                                <svg class="w-3.5 h-3.5 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif
                        </button>
                        @foreach ($zones as $zone)
                            <button
                                type="button"
                                wire:click="filterZone('{{ $zone }}')"
                                class="w-full text-left px-3 py-1.5 rounded-xl font-semibold flex items-center justify-between transition cursor-pointer {{ $selectedZone === $zone ? 'bg-rose-50 text-[#641E28] font-bold border border-rose-200' : 'text-slate-600 hover:bg-slate-50' }}"
                            >
                                <span>{{ $zone }} {{ $zone === 'Cilegon' ? '(FT)' : '' }}</span>
                                @if ($selectedZone === $zone)
                                    <svg class="w-3.5 h-3.5 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Kategori Barang -->
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Kategori Barang</span>
                    </label>
                    <div class="space-y-1 text-xs max-h-52 overflow-y-auto pr-1">
                        <button
                            type="button"
                            wire:click="filterCategory(null)"
                            class="w-full text-left px-3 py-1.5 rounded-xl font-semibold flex items-center justify-between transition cursor-pointer {{ is_null($selectedCategory) ? 'bg-rose-50 text-[#641E28] font-bold border border-rose-200' : 'text-slate-600 hover:bg-slate-50' }}"
                        >
                            <span>Semua Kategori</span>
                            @if (is_null($selectedCategory))
                                <svg class="w-3.5 h-3.5 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif
                        </button>
                        @foreach ($categories as $category)
                            <button
                                type="button"
                                wire:click="filterCategory({{ $category->id }})"
                                class="w-full text-left px-3 py-1.5 rounded-xl font-semibold flex items-center justify-between transition cursor-pointer {{ $selectedCategory === $category->id ? 'bg-rose-50 text-[#641E28] font-bold border border-rose-200' : 'text-slate-600 hover:bg-slate-50' }}"
                            >
                                <span class="truncate">{{ $category->name }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $selectedCategory === $category->id ? 'bg-[#641E28] text-white' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $category->products_count }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Ukuran Logistik -->
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Ukuran Logistik</span>
                    </label>
                    <div class="grid grid-cols-3 gap-1 text-xs font-semibold">
                        <button
                            type="button"
                            wire:click="filterTier('')"
                            class="py-1.5 rounded-xl text-center border transition cursor-pointer {{ empty($selectedTier) ? 'border-[#641E28] bg-rose-50 text-[#641E28] font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}"
                        >
                            Semua
                        </button>
                        <button
                            type="button"
                            wire:click="filterTier('small')"
                            class="py-1.5 rounded-xl text-center border transition cursor-pointer {{ $selectedTier === 'small' ? 'border-[#641E28] bg-rose-50 text-[#641E28] font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}"
                        >
                            Reguler
                        </button>
                        <button
                            type="button"
                            wire:click="filterTier('bulky')"
                            class="py-1.5 rounded-xl text-center border transition cursor-pointer {{ $selectedTier === 'bulky' ? 'border-[#641E28] bg-rose-50 text-[#641E28] font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}"
                        >
                            Bulky
                        </button>
                    </div>
                </div>

                <!-- Keamanan Transaksi -->
                <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 space-y-1.5">
                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Transaksi Aman Mahasiswa</span>
                    </div>
                    <p class="leading-normal text-[10px] text-slate-400">
                        Cek fisik barang saat COD di titik kumpul kampus sebelum konfirmasi selesai.
                    </p>
                </div>
            </div>
        </aside>

        <!-- PRODUCT LISTINGS (3-Kolom E-Commerce) -->
        <main class="lg:col-span-3 space-y-4">

            <!-- E-Commerce Toolbar -->
            <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="font-black text-slate-900 text-sm">
                        {{ $products->total() }} Produk
                    </span>

                    @if ($selectedFaculty)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-[#641E28] border border-rose-200">
                            <span>Fakultas {{ $selectedFaculty }}</span>
                            <button wire:click="filterFaculty('')" class="hover:text-red-700 cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    @endif

                    @if ($selectedZone)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                            <span>Kampus {{ $selectedZone }}</span>
                            <button wire:click="filterZone('')" class="hover:text-red-700 cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    @endif

                    @if ($selectedCategory)
                        @php
                            $curCat = $categories->firstWhere('id', $selectedCategory);
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                            <span>{{ $curCat->name ?? '' }}</span>
                            <button wire:click="filterCategory(null)" class="hover:text-red-700 cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    @endif

                    @if ($search)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                            <span>"{{ $search }}"</span>
                            <button wire:click="$set('search', '')" class="hover:text-red-700 cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    @endif
                </div>

                <!-- Sort Control -->
                <div class="flex items-center gap-2 self-end sm:self-auto">
                    <span class="text-xs text-slate-500 font-semibold">Urutkan:</span>
                    <select
                        id="sortBy"
                        wire:model.live="sortBy"
                        class="px-3 py-1.5 text-xs font-bold rounded-full border border-slate-300 bg-slate-50 text-slate-800 focus:ring-[#641E28] focus:border-[#641E28]"
                    >
                        <option value="latest">Produk Terbaru</option>
                        <option value="price_asc">Harga: Terendah</option>
                        <option value="price_desc">Harga: Tertinggi</option>
                    </select>
                </div>
            </div>

            <!-- PRODUCT GRID (Modern E-Commerce 2-Col Mobile Cards) -->
            @if ($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-2.5 sm:gap-4 md:gap-5">
                    @foreach ($products as $product)
                        <div class="group bg-white rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-sm hover:border-[#641E28]/40 hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between overflow-hidden">

                            <!-- Foto Produk Berasio 4:3 -->
                            <div class="relative w-full aspect-[4/3] bg-slate-100 overflow-hidden">
                                <a href="{{ route('product.detail', $product->slug) }}" class="block w-full h-full">
                                    <img
                                        src="{{ $product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                        alt="{{ $product->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    />
                                </a>

                                <!-- Badges Ringkas -->
                                <div class="absolute top-1.5 left-1.5 sm:top-2.5 sm:left-2.5 flex flex-wrap items-center gap-1">
                                    <span class="px-1.5 sm:px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold shadow-xs {{ $product->campus_zone === 'Cilegon' ? 'bg-[#641E28] text-white' : ($product->campus_zone === 'Sindangsari' ? 'bg-emerald-700 text-white' : 'bg-slate-800 text-white') }}">
                                        {{ $product->campus_zone === 'Cilegon' ? 'FT Cilegon' : $product->campus_zone }}
                                    </span>

                                    @if ($product->size_tier === 'bulky')
                                        <span class="hidden sm:inline px-1.5 sm:px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                            Bulky
                                        </span>
                                    @endif
                                </div>

                                @if ($product->is_negotiable)
                                    <div class="absolute bottom-1.5 right-1.5 sm:bottom-2.5 sm:right-2.5">
                                        <span class="px-1.5 sm:px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-white/95 text-[#641E28] shadow-xs border border-rose-200 flex items-center gap-0.5 sm:gap-1">
                                            <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            <span>Nego</span>
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Body Card -->
                            <div class="p-2 sm:p-3.5 flex-1 flex flex-col justify-between space-y-1 sm:space-y-2">
                                <div>
                                    <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider block truncate">
                                        {{ $product->category->name }}
                                    </span>

                                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#641E28] transition line-clamp-2 mt-0.5 leading-snug">
                                        <a href="{{ route('product.detail', $product->slug) }}">
                                            {{ $product->title }}
                                        </a>
                                    </h3>
                                </div>

                                <div>
                                    <div class="text-xs sm:text-base font-black text-[#641E28]">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>

                                    <div class="mt-1.5 pt-1.5 border-t border-slate-100 flex items-center justify-between text-[10px] sm:text-[11px] text-slate-500">
                                        <span class="truncate max-w-[70px] sm:max-w-[120px] font-medium text-slate-600 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-slate-400 shrink-0 hidden sm:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span class="truncate">{{ $product->seller->name }}</span>
                                        </span>
                                        <a
                                            href="{{ route('product.detail', $product->slug) }}"
                                            class="font-bold text-[#641E28] hover:text-[#4A151D] shrink-0"
                                        >
                                            Beli →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-6 border-t border-slate-200/80">
                    {{ $products->links('vendor.livewire.tailwind') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Produk Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500">Coba ganti kata kunci pencarian atau reset filter.</p>
                    <button
                        wire:click="resetFilters"
                        class="px-5 py-2 rounded-full bg-[#641E28] text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        Reset Filter
                    </button>
                </div>
            @endif
        </main>
    </div>
</div>
