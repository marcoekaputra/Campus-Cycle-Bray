<div class="max-w-3xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="/" class="hover:text-[#641E28] transition">Beranda</a>
        <span>/</span>
        <a href="{{ route('dashboard') }}" class="hover:text-[#641E28] transition">Dashboard</a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Jual Barang Pre-loved</span>
    </nav>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Upload Barang Dagangan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Jual perlengkapan kuliah, lemari kosan, alat praktikum, atau buku teks ke sesama mahasiswa Untirta.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-100 text-[#641E28] border border-rose-200 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>{{ Auth::user()->faculty_code ?? 'FT' }} Untirta (Kampus {{ Auth::user()->campus_zone ?? 'Cilegon' }})</span>
            </span>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8">
        <form wire:submit.prevent="saveProduct" class="space-y-6">
            <!-- 1. Judul Barang -->
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Judul / Nama Barang <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    wire:model="title"
                    placeholder="Contoh: Lemari Pakaian Portable 4 Box / Helm Proyek SNI FT Untirta / Kalkulator Casio fx-991EX"
                    class="block w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-bold"
                    required
                />
                @error('title')
                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Kategori & Harga -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kategori Barang <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="category_id"
                        wire:model="category_id"
                        class="block w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-medium"
                        required
                    >
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Harga Barang (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-black text-slate-400">
                            Rp
                        </span>
                        <input
                            type="number"
                            id="price"
                            wire:model="price"
                            placeholder="Contoh: 150000"
                            class="block w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-black text-[#641E28] font-mono"
                            required
                        />
                    </div>
                    @error('price')
                        <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 3. Upload & Pilihan Foto Barang (Enhanced Marketplace Photo Tools) -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-800">
                            Foto Barang Dagangan <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-[11px] text-slate-500">Pilih upload dari galeri file, tempel URL online, atau gunakan preset foto sampel barang.</p>
                    </div>

                    <!-- Mode Selector Tab -->
                    <div class="inline-flex p-1 bg-white rounded-xl border border-slate-200 text-xs font-bold self-start">
                        <button
                            type="button"
                            wire:click="$set('uploadMode', 'file')"
                            class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5 cursor-pointer {{ $uploadMode === 'file' ? 'bg-[#641E28] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Upload File</span>
                        </button>
                        <button
                            type="button"
                            wire:click="$set('uploadMode', 'url')"
                            class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5 cursor-pointer {{ $uploadMode === 'url' ? 'bg-[#641E28] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>Input Link</span>
                        </button>
                        <button
                            type="button"
                            wire:click="$set('uploadMode', 'preset')"
                            class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5 cursor-pointer {{ $uploadMode === 'preset' ? 'bg-[#641E28] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Sampel Foto</span>
                        </button>
                    </div>
                </div>

                <!-- PREVIEW BOX (If image or imageUrlInput is present) -->
                @if ($image || !empty($imageUrlInput))
                    <div class="relative bg-white p-3 rounded-2xl border-2 border-rose-200 shadow-sm flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-32 h-32 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover" />
                            @else
                                <img src="{{ $imageUrlInput }}" alt="Preview" class="w-full h-full object-cover" />
                            @endif
                        </div>
                        <div class="flex-1 text-center sm:text-left space-y-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Foto Siap Ditayangkan</span>
                            </span>
                            <p class="text-xs text-slate-600 line-clamp-1 font-mono">
                                {{ $image ? $image->getClientOriginalName() : $imageUrlInput }}
                            </p>
                            <p class="text-[11px] text-slate-400">
                                Gambar ini akan muncul sebagai foto sampul utama di katalog & halaman detail.
                            </p>
                        </div>
                        <button
                            type="button"
                            wire:click="removeImage"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition flex items-center gap-1 cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Hapus / Ganti</span>
                        </button>
                    </div>
                @endif

                <!-- MODE 1: FILE UPLOAD -->
                @if ($uploadMode === 'file' && !$image && empty($imageUrlInput))
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-2xl hover:border-[#641E28] transition bg-white relative">
                        <div class="space-y-2 text-center">
                            <div class="w-12 h-12 mx-auto rounded-full bg-rose-50 text-[#641E28] flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>

                            <div class="flex text-xs text-slate-700 justify-center font-bold">
                                <label for="imageUploadInput" class="relative cursor-pointer rounded-lg bg-rose-50 px-3 py-1.5 text-[#641E28] hover:bg-blue-100 border border-rose-200 transition">
                                    <span>Pilih Foto dari Galeri / Kamera</span>
                                    <input
                                        id="imageUploadInput"
                                        type="file"
                                        wire:model="image"
                                        accept="image/png, image/jpeg, image/jpg, image/webp"
                                        class="sr-only"
                                    />
                                </label>
                            </div>
                            <p class="text-[11px] text-slate-400">Mendukung format JPG, PNG, WEBP hingga ukuran 8MB</p>

                            <div wire:loading wire:target="image" class="text-xs font-bold text-[#641E28] flex items-center justify-center gap-2 pt-2">
                                <svg class="animate-spin w-4 h-4 text-[#641E28]" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span>Mengunggah preview foto...</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- MODE 2: INPUT URL -->
                @if ($uploadMode === 'url' && !$image && empty($imageUrlInput))
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-2">
                        <label for="imgUrlInputBox" class="block text-xs font-bold text-slate-700">Link URL Gambar Online</label>
                        <div class="flex items-center gap-2">
                            <input
                                type="url"
                                id="imgUrlInputBox"
                                wire:model.live.debounce.400ms="imageUrlInput"
                                placeholder="https://images.unsplash.com/... atau link foto online"
                                class="flex-1 text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-mono"
                            />
                        </div>
                        <p class="text-[10px] text-slate-400">Masukkan link gambar langsung berformat web publik (Unsplash, Imgur, Cloudinary, dll).</p>
                    </div>
                @endif

                <!-- MODE 3: PRESET SAMPEL FOTO MAHASISWA -->
                @if ($uploadMode === 'preset')
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-slate-800">Pilih Foto Sampel Realistis Barang Kampus:</span>
                            <span class="text-[10px] text-[#641E28] font-bold">1-Klik Terpasang</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 max-h-64 overflow-y-auto p-1">
                            <!-- Preset 1: Lemari Pakaian 4 Box -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/lemari-4box.jpg', 'Lemari Pakaian Portable 4 Box Modular Kosan', 'bulky')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/lemari-4box.jpg" alt="Lemari 4 Box" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Lemari 4 Box</span>
                                <span class="text-[10px] text-slate-500 block">Bulky Kosan</span>
                            </button>

                            <!-- Preset 2: Helm Safety FT SNI -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/helm-proyek-ft.jpg', 'Helm Safety Proyek SNI FT Untirta Kuning', 'small')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/helm-proyek-ft.jpg" alt="Helm Proyek" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Helm Proyek SNI</span>
                                <span class="text-[10px] text-slate-500 block">Alat Praktikum FT</span>
                            </button>

                            <!-- Preset 3: Dispenser Kosan -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/dispenser-kosan.jpg', 'Dispenser Galon Air Kosan Mahasiswa', 'medium')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/dispenser-kosan.jpg" alt="Dispenser" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Dispenser Galon</span>
                                <span class="text-[10px] text-slate-500 block">Perlengkapan Kos</span>
                            </button>

                            <!-- Preset 4: Kalkulator Casio fx-991EX -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/kalkulator-casio.jpg', 'Kalkulator Saintifik Casio fx-991EX Classwiz', 'small')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/kalkulator-casio.jpg" alt="Kalkulator" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Kalkulator Casio</span>
                                <span class="text-[10px] text-slate-500 block">Alat Praktikum Lab</span>
                            </button>

                            <!-- Preset 5: Rice Cooker Mini -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/rice-cooker.jpg', 'Rice Cooker Mini Miyako 0.6L Anak Kosan', 'medium')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/rice-cooker.jpg" alt="Rice Cooker" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Rice Cooker Kos</span>
                                <span class="text-[10px] text-slate-500 block">Perlengkapan Kos</span>
                            </button>

                            <!-- Preset 6: Kipas Angin Meja -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/kipas-angin.jpg', 'Kipas Angin Meja Meja Cosmos 12 Inch 3 Speed', 'medium')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/kipas-angin.jpg" alt="Kipas Angin" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Kipas Angin Meja</span>
                                <span class="text-[10px] text-slate-500 block">Perlengkapan Kos</span>
                            </button>

                            <!-- Preset 7: Buku Kalkulus Purcell -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/buku-kalkulus.jpg', 'Kalkulus Edisi 9 Jilid 1 & 2 - Dale Varberg & Purcell', 'small')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/buku-kalkulus.jpg" alt="Buku Kalkulus" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Buku Kalkulus</span>
                                <span class="text-[10px] text-slate-500 block">Buku & Diktat</span>
                            </button>

                            <!-- Preset 8: Jas Lab FT -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/jas-lab.jpg', 'Jas Lab Untirta Katun Tebal Drill + Goggles', 'small')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/jas-lab.jpg" alt="Jas Lab" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Jas Lab + Goggles</span>
                                <span class="text-[10px] text-slate-500 block">Alat Praktikum Lab</span>
                            </button>

                            <!-- Preset 9: Monitor LED 24" -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/monitor-lg.jpg', 'Monitor LED LG 24 Inch IPS Full HD HDMI', 'medium')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/monitor-lg.jpg" alt="Monitor LG" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Monitor IPS 24"</span>
                                <span class="text-[10px] text-slate-500 block">Elektronik Gadget</span>
                            </button>

                            <!-- Preset 10: Kasur Busa Inoac -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/kasur-lipat.jpg', 'Kasur Busa Lipat Inoac Single 90x200cm Kosan', 'bulky')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/kasur-lipat.jpg" alt="Kasur Lipat" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Kasur Inoac</span>
                                <span class="text-[10px] text-slate-500 block">Bulky Kosan</span>
                            </button>

                            <!-- Preset 11: Meja Lipat Lesehan -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/meja-lipat.jpg', 'Meja Lipat Lesehan Laptop Kayu Mahoni Kosan', 'small')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/meja-lipat.jpg" alt="Meja Lipat" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Meja Lipat Laptop</span>
                                <span class="text-[10px] text-slate-500 block">Perlengkapan Kos</span>
                            </button>

                            <!-- Preset 12: Sepeda Lipat Polygon -->
                            <button
                                type="button"
                                wire:click="selectPresetImage('/images/products/sepeda-lipat.jpg', 'Sepeda Lipat Polygon Urbano 3 Kampus Untirta', 'bulky')"
                                class="p-2 rounded-xl border border-slate-200 hover:border-[#641E28] hover:shadow-xs text-left transition group bg-slate-50/50"
                            >
                                <img src="/images/products/sepeda-lipat.jpg" alt="Sepeda Lipat" class="w-full h-20 object-cover rounded-lg mb-1.5" />
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#641E28] line-clamp-1 block">Sepeda Polygon</span>
                                <span class="text-[10px] text-slate-500 block">Transportasi Kampus</span>
                            </button>
                        </div>
                    </div>
                @endif

                @error('image')
                    <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- 4. Kategori Ukuran Barang (Size Tier untuk Logistik Antar-Kampus) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Kategori Ukuran Barang (Size Tier untuk Ongkir Logistik Kampus) <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Kecil / Reguler -->
                    <label class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all {{ $size_tier === 'small' ? 'border-[#641E28] bg-rose-50/40 shadow-sm' : 'border-slate-200 hover:border-slate-300' }}">
                        <div class="flex items-start gap-2.5">
                            <input
                                type="radio"
                                wire:model.live="size_tier"
                                value="small"
                                class="mt-0.5 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                            />
                            <div>
                                <span class="text-xs font-black text-slate-900 block">Kecil / Reguler</span>
                                <span class="text-[11px] text-slate-500 leading-tight block mt-0.5">
                                    Buku, kalkulator, modul, helm safety, jas lab, mouse, kemeja kuliah.
                                </span>
                            </div>
                        </div>
                    </label>

                    <!-- Sedang / Kargo -->
                    <label class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all {{ $size_tier === 'medium' ? 'border-[#641E28] bg-rose-50/40 shadow-sm' : 'border-slate-200 hover:border-slate-300' }}">
                        <div class="flex items-start gap-2.5">
                            <input
                                type="radio"
                                wire:model.live="size_tier"
                                value="medium"
                                class="mt-0.5 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                            />
                            <div>
                                <span class="text-xs font-black text-slate-900 block">Sedang / Kargo</span>
                                <span class="text-[11px] text-slate-500 leading-tight block mt-0.5">
                                    Dispenser, rice cooker, monitor 24", meja lipat, kipas angin kosan.
                                </span>
                            </div>
                        </div>
                    </label>

                    <!-- Besar / Bulky -->
                    <label class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all {{ $size_tier === 'bulky' ? 'border-[#641E28] bg-rose-50/40 shadow-sm' : 'border-slate-200 hover:border-slate-300' }}">
                        <div class="flex items-start gap-2.5">
                            <input
                                type="radio"
                                wire:model.live="size_tier"
                                value="bulky"
                                class="mt-0.5 text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                            />
                            <div>
                                <span class="text-xs font-black text-slate-900 block">Besar / Bulky (Pick-up)</span>
                                <span class="text-[11px] text-slate-500 leading-tight block mt-0.5">
                                    Lemari pakaian 4 box, kasur busa kosan, sepeda lipat, kulkas mini.
                                </span>
                            </div>
                        </div>
                    </label>
                </div>
                @error('size_tier')
                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- 5. Kondisi Grade & Titik COD -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="condition_grade" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Grade Kondisi Barang <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="condition_grade"
                        wire:model="condition_grade"
                        class="block w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-medium"
                        required
                    >
                        <option value="Grade S (Baru / Like New)">Grade S (Baru / Like New Lengkap Box)</option>
                        <option value="Grade A (Mulus)">Grade A (Mulus Terawat & Bersih)</option>
                        <option value="Grade B (Normal)">Grade B (Fungsi Normal Ada Jejak Pakai)</option>
                        <option value="Grade C (Layak Pakai)">Grade C (Layak Pakai Apa Adanya)</option>
                    </select>
                </div>

                <div>
                    <label for="pickup_location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Titik Rekomendasi COD Kampus
                    </label>
                    <input
                        type="text"
                        id="pickup_location"
                        wire:model="pickup_location"
                        placeholder="Contoh: Gedung COE FT Cilegon / Halte Kampus"
                        class="block w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28]"
                    />
                </div>
            </div>

            <!-- 6. Deskripsi Barang -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Deskripsi Lengkap Barang <span class="text-rose-500">*</span>
                </label>
                <textarea
                    id="description"
                    wire:model="description"
                    rows="4"
                    placeholder="Jelaskan kondisi barang, kelengkapan (dus/kunci/kabel), minus pemakaian, alasan dijual, dan waktu luang untuk COD di kampus..."
                    class="block w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] font-medium"
                    required
                ></textarea>
                @error('description')
                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- 7. Opsi Nego -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        wire:model="is_negotiable"
                        class="w-4 h-4 rounded text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                    />
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 block">Izinkan Mahasiswa Menawar Harga (Fitur Nego Cerdas)</span>
                        <span class="text-[11px] text-slate-500 block">Calon pembeli dapat mengajukan penawaran harga yang bisa Anda terima atau tolak di dashboard.</span>
                    </div>
                </label>
            </div>

            <!-- Tombol Submit -->
            <div class="pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-2xl bg-[#641E28] hover:bg-[#4A151D] text-white font-black text-sm shadow-xl shadow-[#641E28]/15 hover:shadow-[#641E28]/25 transition flex items-center justify-center gap-2 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="saveProduct">
                        Tayangkan Barang di Marketplace CampusCycle
                    </span>
                    <span wire:loading wire:target="saveProduct" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Menyimpan & Menayangkan Barang...</span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
