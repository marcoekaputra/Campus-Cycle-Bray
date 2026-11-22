<div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Breadcrumb & Navigasi -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="/" class="hover:text-[#641E28] transition">Beranda</a>
        <span>/</span>
        <a href="{{ route('product.detail', $product->slug) }}" class="hover:text-[#641E28] transition truncate max-w-xs">
            {{ $product->title }}
        </a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Checkout & Pembayaran</span>
    </nav>

    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#641E28] text-white">
                    Escrow Protected
                </span>
                <span class="text-xs font-semibold text-slate-500">100% Cashless & Rekening Bersama Kampus</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1.5 tracking-tight">
                Checkout Pesanan Mahasiswa
            </h1>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-600 bg-slate-100 px-3.5 py-2 rounded-2xl border border-slate-200 self-start sm:self-auto">
            <svg class="w-4 h-4 text-[#641E28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>Dana tertahan aman sampai barang Anda terima</span>
        </div>
    </div>

    <!-- Alert Status & Error -->
    @if (session()->has('status'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-bold">{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->has('paymentMethod'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-bold">{{ $errors->first('paymentMethod') }}</span>
        </div>
    @endif

    <!-- GRID FORM UTAMA (2 Kolom) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Rincian Barang, Pengiriman & Pembayaran -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 1. Ringkasan Produk yang Dibeli -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-50 text-[#641E28] flex items-center justify-center font-bold text-xs">1</span>
                        Barang yang Dibeli
                    </h2>
                    <span class="text-xs text-slate-500 font-semibold">
                        Penjual: <strong class="text-slate-800">{{ $product->seller->name }}</strong> (Untirta {{ $product->campus_zone }})
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="w-20 h-20 rounded-2xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                        @if ($product->images && count($product->images) > 0)
                            <img src="{{ $product->images[0] }}" alt="{{ $product->title }}" class="w-full h-full object-cover"/>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Foto</div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-black uppercase text-[#641E28] bg-rose-50 px-2 py-0.5 rounded border border-rose-200">
                                {{ $product->category->name }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                Kondisi: {{ $product->condition }}
                            </span>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 truncate">
                            {{ $product->title }}
                        </h3>

                        @if ($priceOffer && $priceOffer->status === 'accepted')
                            <div class="flex items-center gap-2 pt-0.5">
                                <span class="text-xs text-slate-400 line-through">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm font-black text-[#641E28]">
                                    Rp {{ number_format($priceOffer->offered_price, 0, ',', '.') }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                    Harga Nego Disetujui
                                </span>
                            </div>
                        @else
                            <div class="text-sm font-black text-[#641E28] pt-0.5">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. Metode Pengiriman & Logistik Multi-Ekspedisi -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-5 sm:p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-50 text-[#641E28] flex items-center justify-center font-bold text-xs">2</span>
                        Pilih Metode Pengantaran Barang
                    </h2>
                </div>

                <!-- Toggle Opsi: COD Kampus vs Jasa Ekspedisi Delivery -->
                <div class="grid grid-cols-2 gap-3">
                    <button
                        type="button"
                        wire:click="$set('deliveryMethod', 'pickup')"
                        class="p-4 rounded-2xl border-2 text-left transition-all cursor-pointer {{ $deliveryMethod === 'pickup' ? 'border-[#641E28] bg-rose-50/30 ring-2 ring-[#641E28]/15' : 'border-slate-200 bg-white hover:border-slate-300' }}"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-extrabold text-slate-900">COD Kampus</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Bebas Ongkir
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Ketemuan langsung di fakultas/kantin kampus penjual (Untirta {{ $product->campus_zone }}).
                        </p>
                    </button>

                    <button
                        type="button"
                        wire:click="$set('deliveryMethod', 'delivery')"
                        class="p-4 rounded-2xl border-2 text-left transition-all cursor-pointer {{ $deliveryMethod === 'delivery' ? 'border-[#641E28] bg-rose-50/30 ring-2 ring-[#641E28]/15' : 'border-slate-200 bg-white hover:border-slate-300' }}"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-extrabold text-slate-900">Jasa Ekspedisi / Delivery</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-[#641E28] border border-rose-200">
                                Berresi Resmi
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Diantar via J&T, JNE, SiCepat, atau Kurir Kilat Untirta ke alamat/kosan Anda.
                        </p>
                    </button>
                </div>

                @if ($deliveryMethod === 'delivery')
                    <!-- FORM PENGIRIMAN EKSPEDISI -->
                    <div class="space-y-4 pt-2">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-4">
                            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                                Destinasi Pengiriman Mahasiswa
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="destinationZone" class="block text-xs font-bold text-slate-700 mb-1">
                                        Zona Kampus Tujuan Penerima <span class="text-rose-500">*</span>
                                    </label>
                                    <select
                                        id="destinationZone"
                                        wire:model.live="destinationZone"
                                        class="block w-full px-3 py-2 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-[#641E28] focus:border-[#641E28] bg-white"
                                    >
                                        <option value="Sindangsari">Kampus Utama Sindangsari (Serang)</option>
                                        <option value="Cilegon">Kampus Cilegon (Fakultas Teknik)</option>
                                        <option value="Pakupatan">Kampus Pakupatan (Serang)</option>
                                        <option value="Ciwaru">Kampus Ciwaru (FKIP Serang)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Rute Kampus</label>
                                    <div class="px-3 py-2 text-xs rounded-xl bg-white border border-slate-200 text-slate-700 font-semibold flex items-center justify-between">
                                        <span>Untirta {{ $product->campus_zone }} → {{ $destinationZone }}</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $product->campus_zone === $destinationZone ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                                            {{ $product->campus_zone === $destinationZone ? 'Satu Area Kampus' : 'Antar-Kampus' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="destinationAddress" class="block text-xs font-bold text-slate-700 mb-1">
                                    Alamat Pengiriman (Kosan / Gedung Kuliah / Lab) <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="destinationAddress"
                                    wire:model="destinationAddress"
                                    placeholder="Contoh: Kosan Asri Kamar 3, dekat Gerbang FT Untirta Cilegon"
                                    class="block w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] bg-white font-medium"
                                    required
                                />
                                @error('destinationAddress')
                                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Pilihan Ekspedisi Kurir -->
                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Pilih Ekspedisi / Kurir Pengantaran <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-[11px] text-slate-500 font-medium">
                                    Muatan: <strong class="uppercase text-slate-700">{{ $product->size_tier ?? 'small' }}</strong>
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($this->availableCouriers as $courierKey => $courier)
                                    @if ($courierKey !== 'pickup')
                                        <label
                                            class="relative p-3.5 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between {{ $selectedCourier === $courierKey ? 'border-[#641E28] bg-rose-50/40 shadow-sm ring-2 ring-[#641E28]/15' : 'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50/50' }}"
                                        >
                                            <div class="flex items-start justify-between gap-2">
                                                <div class="flex items-center gap-2.5">
                                                    <input
                                                        type="radio"
                                                        name="selectedCourier"
                                                        wire:model.live="selectedCourier"
                                                        value="{{ $courierKey }}"
                                                        class="w-4 h-4 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                                                    />
                                                    <div>
                                                        <div class="flex items-center gap-1.5 flex-wrap">
                                                            <span class="text-xs font-black text-slate-900">{{ $courier['name'] }}</span>
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase {{ $courier['badge_color'] }} border">
                                                                {{ $courier['badge'] }}
                                                            </span>
                                                        </div>
                                                        <span class="text-[11px] font-bold text-slate-600 block mt-0.5">
                                                            {{ $courier['service'] }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="text-right shrink-0">
                                                    <span class="text-xs font-black text-[#641E28] block">
                                                        Rp {{ number_format($courier['fee'], 0, ',', '.') }}
                                                    </span>
                                                    <span class="text-[10px] font-semibold text-slate-500 block">
                                                        {{ $courier['eta'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-slate-500 mt-2 pl-6">
                                                {{ $courier['description'] }}
                                            </p>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Titik Temu COD Kampus & Penegasan Pembayaran Cashless -->
                    <div class="space-y-3 pt-2">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-2">
                            <label for="meetupLocation" class="block text-xs font-bold text-slate-700">
                                Titik Janji Temu COD di Kampus Penjual <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="meetupLocation"
                                wire:model="meetupLocation"
                                placeholder="Contoh: Kantin FT Untirta Cilegon / Depan Gedung COE / Gerbang Utama"
                                class="block w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] bg-white font-medium"
                                required
                            />
                            <p class="text-[11px] text-slate-500">
                                Area Kampus Penjual: <strong>Untirta {{ $product->campus_zone }}</strong>. Ongkir Rp 0.
                            </p>
                            @error('meetupLocation')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Banner Edukasi: Transaksi Tetap Cashless via Escrow -->
                        <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200 text-amber-900 text-xs flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-amber-700 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="leading-relaxed">
                                <strong class="font-bold">Pembayaran Tetap Dilakukan Secara Cashless (Rekening Bersama):</strong>
                                Demi keamanan kedua belah pihak dari penipuan COD uang palsu atau pembatalan sepihak, dana pembayaran disimpan aman di rekening bersama CampusCycle. Setelah Anda bertemu dan memeriksa barang secara langsung di kampus, Anda cukup menekan tombol "Selesaikan Pesanan" untuk meneruskan dana ke penjual.
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Catatan Tambahan -->
                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Catatan Tambahan untuk Penjual / Kurir
                    </label>
                    <textarea
                        id="notes"
                        wire:model="notes"
                        rows="2"
                        placeholder="Contoh: Tolong hubungi via WhatsApp sebelum kirim, atau titip di pos satpam..."
                        class="block w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28]"
                    ></textarea>
                </div>
            </div>

            <!-- 3. Metode Pembayaran Cashless (Wallet & Virtual Account Mobile Banking) -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-50 text-[#641E28] flex items-center justify-center font-bold text-xs">3</span>
                        Pilih Metode Pembayaran Cashless
                    </h2>
                    <button
                        type="button"
                        wire:click="openTopupModal"
                        class="text-xs font-bold text-[#641E28] hover:text-[#4A151D] bg-rose-50 px-3 py-1 rounded-xl border border-rose-200 transition"
                    >
                        + Top Up Dompet
                    </button>
                </div>

                <div class="space-y-3">
                    <!-- Opsi 1: CampusWallet (Saldo Dompet Kampus) -->
                    <label class="block p-4 rounded-2xl border-2 transition-all cursor-pointer {{ $paymentMethod === 'wallet' ? 'border-[#641E28] bg-rose-50/40 ring-2 ring-[#641E28]/15' : 'border-slate-200 hover:border-slate-300' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input
                                    type="radio"
                                    wire:model.live="paymentMethod"
                                    value="wallet"
                                    class="w-4 h-4 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                                />
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs sm:text-sm font-black text-slate-900">CampusWallet (Dompet Digital Mahasiswa)</span>
                                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-[#641E28] text-white">Instan</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Saldo Anda: <strong class="text-slate-900">Rp {{ number_format($this->buyerWallet->balance, 0, ',', '.') }}</strong>
                                    </p>
                                </div>
                            </div>
                            @if ($this->buyerWallet->balance < $this->totalAmount)
                                <span class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-200">
                                    Saldo Kurang
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                                    <span>Saldo Cukup</span>
                                </span>
                            @endif
                        </div>
                    </label>

                    <!-- Header Opsi Virtual Account -->
                    <div class="pt-2">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2">
                            Transfer Virtual Account (Verifikasi Otomatis 24 Jam)
                        </span>
                        <div class="space-y-2.5">
                            <!-- Opsi 2: BCA Virtual Account -->
                            <label class="block p-3.5 rounded-2xl border-2 transition-all cursor-pointer {{ $paymentMethod === 'va_bca' ? 'border-[#641E28] bg-rose-50/40 ring-2 ring-[#641E28]/15' : 'border-slate-200 hover:border-slate-300' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input
                                            type="radio"
                                            wire:model.live="paymentMethod"
                                            value="va_bca"
                                            class="w-4 h-4 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                                        />
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded bg-blue-700 text-white font-black text-[10px]">BCA</span>
                                                <span class="text-xs sm:text-sm font-bold text-slate-900">BCA Virtual Account</span>
                                            </div>
                                            <p class="text-[11px] text-slate-500 mt-0.5">Transfer via BCA Mobile, myBCA, KlikBCA, atau ATM BCA</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-semibold text-slate-400">Verifikasi Otomatis</span>
                                </div>
                            </label>

                            <!-- Opsi 3: BRI Virtual Account (BRIVA) -->
                            <label class="block p-3.5 rounded-2xl border-2 transition-all cursor-pointer {{ $paymentMethod === 'va_bri' ? 'border-[#641E28] bg-rose-50/40 ring-2 ring-[#641E28]/15' : 'border-slate-200 hover:border-slate-300' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input
                                            type="radio"
                                            wire:model.live="paymentMethod"
                                            value="va_bri"
                                            class="w-4 h-4 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                                        />
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded bg-blue-800 text-white font-black text-[10px]">BRI</span>
                                                <span class="text-xs sm:text-sm font-bold text-slate-900">BRI Virtual Account (BRIVA)</span>
                                            </div>
                                            <p class="text-[11px] text-slate-500 mt-0.5">Transfer via BRImo, Internet Banking BRI, atau ATM BRI</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-semibold text-slate-400">Verifikasi Otomatis</span>
                                </div>
                            </label>

                            <!-- Opsi 4: Mandiri Virtual Account -->
                            <label class="block p-3.5 rounded-2xl border-2 transition-all cursor-pointer {{ $paymentMethod === 'va_mandiri' ? 'border-[#641E28] bg-rose-50/40 ring-2 ring-[#641E28]/15' : 'border-slate-200 hover:border-slate-300' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input
                                            type="radio"
                                            wire:model.live="paymentMethod"
                                            value="va_mandiri"
                                            class="w-4 h-4 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                                        />
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded bg-amber-500 text-slate-950 font-black text-[10px]">MANDIRI</span>
                                                <span class="text-xs sm:text-sm font-bold text-slate-900">Mandiri Virtual Account</span>
                                            </div>
                                            <p class="text-[11px] text-slate-500 mt-0.5">Transfer via Livin' by Mandiri atau ATM Mandiri</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-semibold text-slate-400">Verifikasi Otomatis</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Rincian Pembayaran E-Commerce Standar & Submit -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-5 sticky top-24">
                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider pb-3 border-b border-slate-100">
                    Rincian Pembayaran
                </h2>

                <div class="space-y-2.5 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span>Harga Barang</span>
                        <span class="font-bold text-slate-900">Rp {{ number_format($this->itemPrice, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-start">
                        <div>
                            <span>Ongkos Kirim</span>
                            @if ($deliveryMethod === 'delivery' && isset($this->availableCouriers[$selectedCourier]))
                                <span class="block text-[10px] text-slate-400 font-semibold">
                                    {{ $this->availableCouriers[$selectedCourier]['name'] }}
                                </span>
                            @else
                                <span class="block text-[10px] text-slate-400 font-semibold">COD Kampus</span>
                            @endif
                        </div>
                        @if ($this->shippingFee > 0)
                            <span class="font-bold text-[#641E28]">Rp {{ number_format($this->shippingFee, 0, ',', '.') }}</span>
                        @else
                            <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 text-[11px]">GRATIS</span>
                        @endif
                    </div>

                    <!-- Application Fee Pembeli (1.5%) -->
                    <div class="flex justify-between items-baseline pt-1 border-t border-dashed border-slate-100">
                        <div>
                            <span class="font-semibold text-slate-700">Biaya Layanan Aplikasi (1.5%)</span>
                            <span class="block text-[10px] text-slate-400">Perlindungan Escrow Kampus</span>
                        </div>
                        <span class="font-bold text-slate-900">
                            Rp {{ number_format($this->buyerAppFee, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex justify-between items-baseline text-sm">
                        <div>
                            <span class="font-black text-slate-900 block">Total Pembayaran</span>
                            <span class="text-[10px] text-slate-400">Termasuk pajak & biaya sistem</span>
                        </div>
                        <span class="text-2xl font-black text-[#641E28]">
                            Rp {{ number_format($this->totalAmount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Keamanan Escrow Card -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600 space-y-1">
                    <div class="flex items-center gap-1.5 font-bold text-slate-800">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Jaminan Keamanan Rekening Bersama</span>
                    </div>
                    <p class="text-[10px] text-slate-500 leading-relaxed">
                        Dana Anda tidak langsung diterima penjual, melainkan ditahan di rekening bersama CampusCycle sampai barang terkonfirmasi diterima dengan baik.
                    </p>
                </div>

                <button
                    type="button"
                    wire:click="processCheckout"
                    wire:loading.attr="disabled"
                    @disabled($paymentMethod === 'wallet' && $this->buyerWallet->balance < $this->totalAmount)
                    class="w-full py-3.5 px-4 rounded-2xl bg-[#641E28] hover:bg-[#4A151D] text-white font-extrabold text-sm shadow-md transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                >
                    <span wire:loading.remove wire:target="processCheckout">
                        @if ($paymentMethod === 'wallet')
                            Bayar Sekarang via CampusWallet
                        @else
                            Buat Pesanan & Bayar via Virtual Account
                        @endif
                    </span>
                    <span wire:loading wire:target="processCheckout" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Memproses Pesanan...</span>
                    </span>
                </button>

                @if ($paymentMethod === 'wallet' && $this->buyerWallet->balance < $this->totalAmount)
                    <div class="p-3 rounded-2xl bg-amber-50 border border-amber-200 text-center space-y-1">
                        <p class="text-[11px] text-amber-900 font-semibold">
                            Saldo dompet Anda kurang Rp {{ number_format($this->totalAmount - $this->buyerWallet->balance, 0, ',', '.') }}.
                        </p>
                        <button
                            type="button"
                            wire:click="openTopupModal"
                            class="text-xs font-bold text-[#641E28] underline hover:text-[#4A151D] cursor-pointer"
                        >
                            + Top Up Saldo Dompet Sekarang
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL 1: INFORMASI VIRTUAL ACCOUNT (BCA, BRI, MANDIRI) -->
    @if ($showVaModal && $activeVa)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/75 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-5 animate-scale-up text-center" x-data="{ copiedVa: false, copiedAmount: false }">
                <!-- Header Modal VA -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2 text-left">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-black uppercase text-white {{ $activeVa['bank'] === 'bca' ? 'bg-blue-700' : ($activeVa['bank'] === 'bri' ? 'bg-blue-800' : 'bg-amber-600') }}">
                            {{ strtoupper($activeVa['bank']) }}
                        </span>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm">{{ $activeVa['bank_name'] }}</h3>
                            <p class="text-[10px] text-slate-400">Verifikasi Otomatis Escrow Untirta</p>
                        </div>
                    </div>
                    <button wire:click="closeVaModal" class="w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Nomor Virtual Account Box -->
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-left space-y-3">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Virtual Account</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xl sm:text-2xl font-mono font-black text-slate-900 tracking-wider">
                                {{ $activeVa['va_number'] }}
                            </span>
                            <button
                                type="button"
                                @click="navigator.clipboard.writeText('{{ $activeVa['va_number'] }}'); copiedVa = true; setTimeout(() => copiedVa = false, 2000)"
                                class="px-3 py-1.5 text-xs font-bold rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 transition flex items-center gap-1 cursor-pointer"
                            >
                                <span x-text="copiedVa ? 'Tersalin!' : 'Salin'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200/80">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Tagihan Pembayaran</span>
                        <div class="flex items-center justify-between mt-0.5">
                            <span class="text-lg font-black text-[#641E28]">
                                Rp {{ number_format($activeVa['amount'], 0, ',', '.') }}
                            </span>
                            <button
                                type="button"
                                @click="navigator.clipboard.writeText('{{ $activeVa['amount'] }}'); copiedAmount = true; setTimeout(() => copiedAmount = false, 2000)"
                                class="px-3 py-1.5 text-xs font-bold rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 transition flex items-center gap-1 cursor-pointer"
                            >
                                <span x-text="copiedAmount ? 'Tersalin!' : 'Salin'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2 text-[11px] text-slate-500 flex items-center justify-between">
                        <span>Batas Waktu Bayar:</span>
                        <strong class="text-rose-700 font-semibold">{{ $activeVa['expired_at'] }}</strong>
                    </div>
                </div>

                <!-- Petunjuk Transfer Mobile Banking -->
                <div class="text-left bg-rose-50/40 p-3.5 rounded-2xl border border-rose-200/80 space-y-1.5 text-xs text-slate-600">
                    <p class="font-bold text-slate-900 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#641E28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span>Cara Bayar via {{ $activeVa['bank_name'] }}:</span>
                    </p>
                    <ol class="list-decimal list-inside space-y-1 text-[11px] text-slate-600 pl-1">
                        <li>Buka aplikasi m-Banking (BCA Mobile, BRImo, atau Livin' by Mandiri).</li>
                        <li>Pilih menu <strong>Transfer / Pembayaran &rarr; Virtual Account</strong>.</li>
                        <li>Masukkan Nomor VA di atas: <strong>{{ $activeVa['va_number'] }}</strong>.</li>
                        <li>Pastikan nama tagihan sesuai, masukkan PIN Anda dan konfirmasi bayar.</li>
                    </ol>
                </div>

                <!-- Tombol Aksi Sandbox & Navigasi -->
                <div class="space-y-2 pt-1">
                    <button
                        type="button"
                        wire:click="simulateVaPayment('{{ $activeVa['order_number'] }}')"
                        wire:loading.attr="disabled"
                        class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-[#641E28] to-[#8C283A] hover:from-[#4A151D] hover:to-[#641E28] text-white text-xs font-bold shadow transition flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-[#EDAB0F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Simulasi Konfirmasi Bayar VA (Sandbox Instan)</span>
                    </button>

                    <button
                        type="button"
                        wire:click="closeVaModal"
                        class="w-full py-2 px-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold cursor-pointer"
                    >
                        Bayar Nanti (Lihat Pesanan di Dashboard)
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL 2: INPUT NOMINAL TOP UP SALDO WALLET -->
    @if ($showTopupModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 space-y-4 animate-scale-up">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </span>
                        <h3 class="font-extrabold text-slate-900 text-sm">Top Up Saldo CampusWallet</h3>
                    </div>
                    <button wire:click="closeTopupModal" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-semibold text-slate-700">Pilih Nominal Top Up</label>
                    <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '50000')"
                            class="p-2.5 rounded-xl border text-center transition {{ $topupAmount === '50000' ? 'border-[#641E28] bg-rose-50 text-[#641E28]' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 50.000
                        </button>
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '100000')"
                            class="p-2.5 rounded-xl border text-center transition {{ $topupAmount === '100000' ? 'border-[#641E28] bg-rose-50 text-[#641E28]' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 100.000
                        </button>
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '200000')"
                            class="p-2.5 rounded-xl border text-center transition {{ $topupAmount === '200000' ? 'border-[#641E28] bg-rose-50 text-[#641E28]' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 200.000
                        </button>
                        <button
                            type="button"
                            wire:click="$set('topupAmount', '500000')"
                            class="p-2.5 rounded-xl border text-center transition {{ $topupAmount === '500000' ? 'border-[#641E28] bg-rose-50 text-[#641E28]' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}"
                        >
                            Rp 500.000
                        </button>
                    </div>

                    <div>
                        <label for="topupAmountInput" class="block text-xs font-semibold text-slate-700 mb-1">Nominal Custom (Rp)</label>
                        <input
                            type="number"
                            id="topupAmountInput"
                            wire:model="topupAmount"
                            class="block w-full px-3 py-2 text-sm rounded-xl border border-slate-300 font-bold focus:ring-[#641E28] focus:border-[#641E28]"
                        />
                        @error('topupAmount')
                            <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button
                        type="button"
                        wire:click="closeTopupModal"
                        class="flex-1 py-2 px-3 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        wire:click="generateTopupQris"
                        wire:loading.attr="disabled"
                        class="flex-1 py-2 px-3 rounded-xl bg-[#641E28] hover:bg-[#4A151D] text-white text-xs font-bold shadow-md flex items-center justify-center gap-1.5"
                    >
                        <span wire:loading.remove wire:target="generateTopupQris">Bayar via QRIS</span>
                        <span wire:loading wire:target="generateTopupQris">Loading...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL 3: QRIS KHUSUS TOP UP SALDO -->
    @if ($showTopupQrisModal && $activeTopupQris)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/75 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 space-y-4 animate-scale-up text-center">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2 text-left">
                        <div class="px-2 py-0.5 bg-red-600 text-white font-black text-xs rounded tracking-wider">
                            QRIS
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-sm">Top Up CampusWallet</h3>
                    </div>
                    <button wire:click="closeTopupModal" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200">
                    <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider block">Nominal Top Up</span>
                    <span class="text-xl font-black text-[#641E28] block mt-0.5">
                        Rp {{ number_format($activeTopupQris['gross_amount'], 0, ',', '.') }}
                    </span>
                </div>

                <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center">
                    <img
                        src="{{ $activeTopupQris['qr_url'] }}"
                        alt="QRIS Top Up"
                        class="w-52 h-52 object-contain mx-auto rounded-lg"
                    />

                    <div class="mt-2.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-rose-50 text-[#641E28] text-[10px] font-bold">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-[#641E28]"></span>
                        </span>
                        <span>Scan Menggunakan m-Banking / E-Wallet</span>
                    </div>
                </div>

                <div class="space-y-2 pt-1">
                    <button
                        type="button"
                        wire:click="simulateTopupSuccess"
                        wire:loading.attr="disabled"
                        class="w-full py-2.5 px-3 rounded-xl bg-gradient-to-r from-[#641E28] to-[#8C283A] hover:from-[#4A151D] hover:to-[#641E28] text-white text-xs font-bold shadow transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Simulasi Top Up Berhasil (Sandbox)</span>
                    </button>

                    <button
                        type="button"
                        wire:click="closeTopupModal"
                        class="w-full py-2 px-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold cursor-pointer"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
