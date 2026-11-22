<div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
    <div class="bg-white py-8 px-6 shadow-2xl shadow-rose-950/10 sm:rounded-3xl sm:px-10 border border-slate-200/80">
        <!-- Header -->
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-rose-50 text-[#641E28] mb-3 border border-rose-100 shadow-inner">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black tracking-tight text-slate-900">
                Lupa Kata Sandi?
            </h2>
            <p class="mt-1 text-xs text-slate-500 leading-relaxed">
                Masukkan NIM akun Untirta dan alamat Gmail pribadi Anda. Tautan pemulihan akan dikirimkan langsung ke Gmail pribadi tersebut.
            </p>
        </div>

        @if ($emailSent)
            <!-- Status Success & Simulation Link -->
            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs">
                    <div class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <div class="font-bold text-sm text-emerald-900">Tautan Berhasil Dikirim ke Gmail!</div>
                            <p class="mt-1 leading-relaxed">
                                Instruksi pemulihan telah dikirim ke Gmail pribadi Anda: <strong>{{ $sentEmail }}</strong>. Silakan periksa inbox atau folder spam Gmail Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Instant Action Button for Fast Testing -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center text-xs space-y-2">
                    <span class="text-[11px] font-semibold text-slate-500 block">Tautan Reset Langsung (Akses Cepat Pengujian):</span>
                    <a
                        href="{{ $demoResetUrl }}"
                        class="w-full inline-flex justify-center items-center gap-1.5 py-2.5 px-4 bg-[#641E28] hover:bg-[#4A151D] text-white font-bold rounded-xl text-xs transition shadow-xs"
                    >
                        <span>Buka Halaman Buat Password Baru</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <div class="pt-2 text-center">
                    <button
                        type="button"
                        wire:click="$set('emailSent', false)"
                        class="text-xs font-bold text-slate-500 hover:text-slate-800 transition cursor-pointer"
                    >
                        &larr; Kirim ke Gmail pribadi lainnya
                    </button>
                </div>
            </div>
        @else
            <form wire:submit="sendResetLink" class="space-y-4">
                <!-- 1. NIM Mahasiswa / Akun Untirta -->
                <div>
                    <label for="login" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        NIM atau Akun Mahasiswa Untirta <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="login"
                            wire:model="login"
                            placeholder="Contoh: 3337240067"
                            class="block w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors font-medium outline-hidden"
                            required
                            autofocus
                        />
                    </div>
                    @error('login')
                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. Alamat Gmail Pribadi -->
                <div>
                    <label for="personalEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Gmail Pribadi (Tujuan Kirim Tautan) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input
                            type="email"
                            id="personalEmail"
                            wire:model="personalEmail"
                            placeholder="Contoh: nama.anda@gmail.com"
                            class="block w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors font-medium outline-hidden"
                            required
                        />
                    </div>
                    <p class="mt-1.5 text-[11px] text-slate-500">
                        Tautan reset kata sandi dan instruksi verifikasi akan dikirim langsung ke Gmail pribadi ini.
                    </p>
                    @error('personalEmail')
                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#641E28] hover:bg-[#4A151D] focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-[#641E28] disabled:opacity-50 transition-all shadow-rose-950/20 cursor-pointer"
                    >
                        <span wire:loading.remove wire:target="sendResetLink">
                            Kirim Tautan ke Gmail Pribadi
                        </span>
                        <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Mengirim ke Gmail...</span>
                        </span>
                    </button>
                </div>
            </form>
        @endif

        <!-- Back to Login -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
            Ingat kata sandi Anda?
            <a href="{{ route('login') }}" class="font-bold text-[#641E28] hover:text-[#4A151D] transition">
                Kembali ke Halaman Masuk
            </a>
        </div>
    </div>
</div>
