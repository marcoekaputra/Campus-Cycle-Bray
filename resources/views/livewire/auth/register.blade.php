<div class="sm:mx-auto sm:w-full sm:max-w-lg">
    <!-- Card Container -->
    <div class="bg-white py-8 px-6 shadow-2xl shadow-rose-950/10 sm:rounded-3xl sm:px-10 border border-slate-200/80">
        <!-- Header -->
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-rose-50 text-[#641E28] mb-3 border border-rose-100 shadow-inner">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-100 text-[#641E28] border border-rose-200 mb-2">
                <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>FT UNTIRTA & Multi-Fakultas</span>
            </div>
            <h2 class="text-2xl font-black tracking-tight text-slate-900">
                Registrasi Mahasiswa Untirta
            </h2>
            <p class="mt-1 text-xs text-slate-500">
                Bergabung dengan ekosistem marketplace sirkular eksklusif civitas akademika Universitas Sultan Ageng Tirtayasa.
            </p>
        </div>

        <form wire:submit.prevent="register" class="space-y-4">
            <!-- 1. Input NIM with Realtime Validation -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="nim" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        NIM Mahasiswa <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[11px] text-[#641E28] font-bold">Validasi Otomatis PDDIKTI</span>
                </div>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2H9.17A3.001 3.001 0 0112 14z" />
                        </svg>
                    </div>

                    <input
                        type="text"
                        id="nim"
                        wire:model.live.debounce.500ms="nim"
                        placeholder="Contoh: 3337220001 (FT) / 222... (FEB)"
                        class="block w-full pl-11 pr-11 py-2.5 text-sm rounded-xl font-mono border {{ $isNimValid === true ? 'border-[#641E28] focus:ring-[#641E28] focus:border-[#641E28] bg-rose-50/30' : ($isNimValid === false ? 'border-rose-500 focus:ring-rose-500 focus:border-rose-500 bg-rose-50/20' : 'border-slate-300 focus:ring-[#641E28] focus:border-[#641E28]') }} transition-colors"
                        required
                    />

                    <!-- Status Indicator Icon -->
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center">
                        <!-- Loading spinner -->
                        <div wire:loading wire:target="nim, updatedNim" class="text-[#641E28]">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                        </div>

                        <!-- Result indicator when not loading -->
                        <div wire:loading.remove wire:target="nim, updatedNim">
                            @if ($isNimValid === true)
                                <svg class="w-5 h-5 text-[#641E28]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            @elseif ($isNimValid === false)
                                <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Realtime NIM Verification Feedback Box -->
                @if ($nimMessage)
                    <div class="mt-2 p-2.5 rounded-xl text-xs {{ $isNimValid ? 'bg-emerald-50 text-emerald-900 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }} flex items-start gap-2 transition-all">
                        <div class="shrink-0 mt-0.5">
                            @if ($isNimValid)
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-bold">{{ $nimMessage }}</p>
                            @if ($nimSource === 'pddikti_api')
                                <span class="inline-flex items-center gap-1 mt-1 px-1.5 py-0.5 rounded bg-emerald-100 text-[10px] font-bold text-emerald-900 border border-emerald-200">
                                    <svg class="w-3 h-3 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <span>Terverifikasi PDDIKTI Kemdikbud</span>
                                </span>
                            @elseif ($nimSource === 'untirta_verified' || $nimSource === 'fallback_regex')
                                <span class="inline-flex items-center gap-1 mt-1 px-1.5 py-0.5 rounded bg-amber-100 text-[10px] font-bold text-amber-900 border border-amber-300">
                                    <svg class="w-3 h-3 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span>Terverifikasi Format Civitas Untirta</span>
                                </span>
                            @elseif ($nimSource === 'format_hint')
                                <span class="inline-flex items-center gap-1 mt-1 px-1.5 py-0.5 rounded bg-slate-100 text-[10px] font-bold text-slate-700 border border-slate-200">
                                    <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Menunggu Kelengkapan 10 Digit</span>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                @error('nim')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Input Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        placeholder="Nama sesuai data akademik"
                        class="block w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] transition-colors font-medium"
                        required
                    />
                </div>
                @error('name')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- 3. Input Email Pribadi -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Email Pribadi (Gmail / Yahoo / dsb.) <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        placeholder="namaanda@gmail.com"
                        class="block w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-[#641E28] focus:border-[#641E28] transition-colors"
                        required
                    />
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Gunakan email pribadi aktif Anda untuk menerima bukti transaksi dan tautan pemulihan kata sandi jika lupa password.</p>
                @error('email')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- 4. Input Password & Confirmation with Eye Toggle -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-data="{ showPass: false, showConfirm: false }">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="password"
                            wire:model="password"
                            placeholder="Min. 6 karakter"
                            class="block w-full pl-10 pr-10 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors outline-hidden font-medium"
                            required
                        />
                        <button
                            type="button"
                            onclick="togglePasswordVisibility('password', this)"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer transition select-none"
                            title="Tampilkan / Sembunyikan Kata Sandi"
                        >
                            <svg class="eye-open w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="eye-closed w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Ulangi Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="password_confirmation"
                            wire:model="password_confirmation"
                            placeholder="Ketik ulang kata sandi"
                            class="block w-full pl-10 pr-10 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors outline-hidden font-medium"
                            required
                        />
                        <button
                            type="button"
                            onclick="togglePasswordVisibility('password_confirmation', this)"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer transition select-none"
                            title="Tampilkan / Sembunyikan Konfirmasi Kata Sandi"
                        >
                            <svg class="eye-open w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="eye-closed w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-black text-white bg-[#641E28] hover:bg-[#4A151D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-600 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-rose-950/20 cursor-pointer"
                >
                    <span wire:loading.remove wire:target="register">
                        Daftar Akun Mahasiswa
                    </span>
                    <span wire:loading wire:target="register" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Mendaftarkan & Mengarahkan...</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Footer link to Login -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-[#641E28] hover:text-blue-900 transition">
                Masuk di sini
            </a>
        </div>
    </div>
</div>
