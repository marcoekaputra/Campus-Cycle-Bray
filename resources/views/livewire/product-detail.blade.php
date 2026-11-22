<div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="/" class="hover:text-[#641E28] transition">Beranda Katalog</a>
        <span>/</span>
        <span class="text-slate-400">{{ $product->category->name ?? 'Kategori' }}</span>
        <span>/</span>
        <span class="text-slate-800 truncate max-w-xs">{{ $product->title }}</span>
    </nav>

    <!-- Success Message Alert -->
    @if (session('offer_success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center justify-between shadow-xs animate-fade-in">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('offer_success') }}</span>
            </div>
        </div>
    @endif

    <!-- Product Detail Card Grid -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-card overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-8">
        <!-- Left: Image Section -->
        <div class="space-y-4">
            <div class="relative w-full h-80 sm:h-96 rounded-2xl bg-slate-100 overflow-hidden border border-slate-200">
                <img
                    src="{{ $product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                    alt="{{ $product->title }}"
                    class="w-full h-full object-cover"
                />

                <!-- Campus Zone & Status Badges -->
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    <span class="px-3 py-1 rounded-xl text-xs font-bold uppercase tracking-wider backdrop-blur-md shadow-md {{ $product->campus_zone === 'Cilegon' ? 'bg-[#641E28]/95 text-white' : ($product->campus_zone === 'Sindangsari' ? 'bg-emerald-700/95 text-white' : ($product->campus_zone === 'Pakupatan' ? 'bg-amber-600/95 text-white' : 'bg-slate-800/95 text-white')) }}">
                        {{ $product->campus_zone === 'Cilegon' ? 'FT Cilegon' : 'Kampus ' . $product->campus_zone }}
                    </span>
                    @if ($product->is_negotiable)
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-white/95 text-[#641E28] border border-rose-200 shadow-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>Bisa Nego</span>
                        </span>
                    @endif
                </div>

                @if ($product->status === 'sold')
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center">
                        <span class="px-5 py-2.5 rounded-2xl bg-rose-600 text-white font-black text-lg tracking-wider uppercase shadow-xl">
                            TERJUAL (SOLD OUT)
                        </span>
                    </div>
                @endif
            </div>

            <!-- Mini Specification Pills -->
            <div class="grid grid-cols-2 gap-3 text-xs">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                    <span class="text-slate-400 block font-semibold uppercase text-[10px]">Kondisi Barang</span>
                    <span class="font-extrabold text-slate-800 text-xs mt-0.5">{{ $product->condition_grade ?: ucfirst($product->condition) }}</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                    <span class="text-slate-400 block font-semibold uppercase text-[10px]">Titik COD Kampus</span>
                    <span class="font-extrabold text-slate-800 text-xs truncate block mt-0.5">{{ $product->pickup_location ?: 'Kampus ' . $product->campus_zone }}</span>
                </div>
            </div>
        </div>

        <!-- Right: Detail & Action Section -->
        <div class="flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <!-- Category & Title -->
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#641E28] bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-200">
                            {{ $product->category->name ?? 'Kategori' }}
                        </span>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                            {{ $product->faculty }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2.5 tracking-tight leading-snug">
                        {{ $product->title }}
                    </h1>
                </div>

                <!-- Price Box (E-Commerce Style) -->
                <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-200/80 flex items-baseline justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Harga Barang</span>
                        <div class="text-3xl font-black text-[#641E28] mt-0.5">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                    @if ($product->is_negotiable)
                        <span class="text-xs font-bold text-amber-800 bg-amber-100 px-3 py-1 rounded-full border border-amber-300 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>Terbuka Penawaran</span>
                        </span>
                    @else
                        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            Harga Pas
                        </span>
                    @endif
                </div>

                <!-- Product Description -->
                <div>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Deskripsi Barang
                    </h2>
                    <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50/60 p-4 rounded-2xl border border-slate-100">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Seller Profile Card -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/40 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#641E28] to-[#8C283A] text-white font-black text-lg flex items-center justify-center shadow-md">
                            {{ strtoupper(substr($product->seller->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-slate-900 text-sm">{{ $product->seller->name ?? 'Mahasiswa' }}</span>
                                <span class="text-[10px] bg-amber-100 text-amber-900 px-2 py-0.5 rounded-md font-extrabold border border-amber-300">
                                    {{ $product->faculty_code }} Verified
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                NIM: {{ $product->seller->nim ?? '333xxxxxxx' }} • Zona Kampus {{ $product->campus_zone }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Area: Authenticated vs Guest vs Seller -->
            <div class="pt-4 border-t border-slate-100">
                @guest
                    <!-- Jika User Belum Login -->
                    <div class="p-4 rounded-2xl bg-rose-50/60 border border-rose-200 text-slate-800 space-y-3">
                        <div class="flex items-center gap-2 font-bold text-sm text-[#641E28]">
                            <svg class="w-4 h-4 text-[#641E28]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Login untuk Membeli atau Menawar</span>
                        </div>
                        <p class="text-xs text-slate-600">
                            Khusus civitas akademika Universitas Sultan Ageng Tirtayasa demi keamanan bertransaksi bersama.
                        </p>
                        <a
                            href="{{ route('login') }}"
                            class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-full bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-extrabold shadow-sm transition"
                        >
                            <span>Masuk / Login Mahasiswa</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    @if (Auth::id() === $product->seller_id)
                        <!-- Jika User adalah Penjual Barang Tersebut -->
                        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-slate-900 flex items-center justify-between">
                            <div class="text-xs">
                                <span class="font-bold block text-sm text-[#641E28]">Ini adalah produk Anda</span>
                                <span class="text-slate-600">Pantau tawaran masuk di Dashboard Penjual Anda.</span>
                            </div>
                            <a
                                href="{{ route('dashboard') }}"
                                class="px-4 py-2 rounded-full bg-[#641E28] text-white text-xs font-bold hover:bg-[#4A151D] transition"
                            >
                                Dashboard
                            </a>
                        </div>
                    @else
                        <!-- Jika User Sudah Login dan BUKAN Penjual -->
                        @if ($existingOffer)
                            <!-- Status Tawaran yang Pernah Diajukan -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 mb-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-700">Tawaran Anda Saat Ini:</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $existingOffer->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : ($existingOffer->status === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                        Status: {{ $existingOffer->status }}
                                    </span>
                                </div>
                                <div class="text-lg font-black text-slate-900">
                                    Rp {{ number_format($existingOffer->offered_price, 0, ',', '.') }}
                                </div>
                                @if ($existingOffer->status === 'pending')
                                    <p class="text-[11px] text-slate-500">Tawaran sedang menunggu persetujuan penjual.</p>
                                @elseif ($existingOffer->status === 'accepted')
                                    <p class="text-[11px] text-emerald-700 font-semibold">Tawaran Anda telah DITERIMA! Silakan lanjutkan ke checkout.</p>
                                @endif
                            </div>
                        @endif

                        @if ($product->status === 'available')
                            <div class="space-y-2.5">
                                @if ($existingOffer && $existingOffer->status === 'accepted')
                                    <a
                                        href="{{ route('order.checkout', ['slug' => $product->slug, 'offer_id' => $existingOffer->id]) }}"
                                        class="w-full py-3.5 px-6 rounded-full bg-gradient-to-r from-[#641E28] to-[#8C283A] hover:from-[#4A151D] hover:to-[#641E28] text-white font-extrabold text-sm shadow-md flex items-center justify-center gap-2 transition"
                                    >
                                        <svg class="w-4 h-4 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        <span>Checkout Sekarang (Harga Nego: Rp {{ number_format($existingOffer->offered_price, 0, ',', '.') }})</span>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                @endif

                                <div class="flex items-center gap-2 sm:gap-3">
                                    <a
                                        href="{{ route('chat', ['product' => $product->slug]) }}"
                                        class="py-3 px-3.5 sm:px-4 rounded-full border border-slate-300 hover:border-[#641E28] text-slate-700 hover:text-[#641E28] font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition bg-slate-50 hover:bg-rose-50/50 shrink-0"
                                        title="Chat langsung dengan penjual ini"
                                    >
                                        <svg class="w-4 h-4 text-[#641E28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span class="hidden sm:inline">Chat Penjual</span>
                                        <span class="sm:hidden">Chat</span>
                                    </a>

                                    <a
                                        href="{{ route('order.checkout', $product->slug) }}"
                                        class="flex-1 py-3 px-3 sm:px-4 rounded-full bg-[#641E28] hover:bg-[#4A151D] text-white font-extrabold text-xs sm:text-sm shadow-sm flex items-center justify-center gap-1.5 transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        <span>Beli Langsung</span>
                                    </a>

                                    @if ($product->is_negotiable)
                                        <button
                                            type="button"
                                            wire:click="openOfferModal"
                                            class="flex-1 py-3 px-3 sm:px-4 rounded-full bg-gradient-to-r from-[#EDAB0F] to-[#f59e0b] hover:from-[#d97706] hover:to-[#b45309] text-slate-950 hover:text-white font-extrabold text-xs sm:text-sm shadow-xs flex items-center justify-center gap-1.5 transition"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Tawar Harga (Nego)</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                @endguest
            </div>
        </div>
    </div>

    <!-- Modal Form Nego / Tawar Harga -->
    @if ($showOfferModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-5 animate-scale-up">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </span>
                        <h3 class="font-extrabold text-slate-900 text-base">Ajukan Tawaran Harga</h3>
                    </div>
                    <button wire:click="closeOfferModal" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Product Mini Summary -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-3">
                    <img
                        src="{{ $product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                        alt="{{ $product->title }}"
                        class="w-12 h-12 rounded-xl object-cover"
                    />
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-slate-900 truncate">{{ $product->title }}</p>
                        <p class="text-xs text-slate-500">Harga Katalog: <strong class="text-[#641E28]">Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                    </div>
                </div>

                <!-- Form Nego -->
                <form wire:submit.prevent="submitOffer" class="space-y-4">
                    <div>
                        <label for="offeredPrice" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nominal Penawaran Anda (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative rounded-xl shadow-xs">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-extrabold text-slate-400">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="offeredPrice"
                                wire:model="offeredPrice"
                                placeholder="Contoh: 50000"
                                class="block w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-bold"
                                required
                            />
                        </div>
                        @error('offeredPrice')
                            <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="offerMessage" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Pesan untuk Penjual (Opsional)
                        </label>
                        <textarea
                            id="offerMessage"
                            wire:model="offerMessage"
                            rows="3"
                            placeholder="Contoh: Halo kak, bisa nego tipis? Saya mahasiswa FT bisa COD di kantin Cilegon..."
                            class="block w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28]"
                        ></textarea>
                        @error('offerMessage')
                            <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button
                            type="button"
                            wire:click="closeOfferModal"
                            class="flex-1 py-2.5 px-4 rounded-full border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 py-2.5 px-4 rounded-full bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-extrabold shadow-sm transition disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="submitOffer">Kirim Tawaran</span>
                            <span wire:loading wire:target="submitOffer">Mengirim...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
