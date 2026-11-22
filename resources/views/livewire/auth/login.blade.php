<div class="sm:mx-auto sm:w-full sm:max-w-md" x-data="{ showPass: false }">
    <!-- Card Container -->
    <div class="bg-white py-8 px-6 shadow-2xl shadow-rose-950/10 sm:rounded-3xl sm:px-10 border border-slate-200/80">
        <!-- Header -->
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-rose-50 text-[#641E28] mb-3 border border-rose-100 shadow-inner">
                <!-- Login Key Icon -->
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-rose-50 text-[#641E28] border border-rose-200/80 mb-3">
                <svg class="w-3.5 h-3.5 text-[#641E28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Civitas Akademika Untirta</span>
            </div>
            <h2 class="text-2xl font-black tracking-tight text-slate-900">
                Masuk ke CampusCycle
            </h2>
            <p class="mt-1 text-xs text-slate-500">
                Marketplace sirkular perlengkapan kuliah & barang teknik antar-mahasiswa.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs font-semibold text-[#641E28] flex items-center gap-2">
                <svg class="w-4 h-4 text-[#641E28]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form wire:submit="authenticate" method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <!-- 1. Input Email / NIM -->
            <div>
                <label for="login" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    NIM atau Alamat Email <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="login"
                        id="login"
                        wire:model="login"
                        value="{{ old('login') }}"
                        placeholder="Contoh: 3337240067 atau email"
                        class="block w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors font-medium outline-hidden"
                        required
                        autofocus
                    />
                </div>
                @error('login')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Input Password with Eye Toggle -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Kata Sandi <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input
                        :type="showPass ? 'text' : 'password'"
                        type="password"
                        name="password"
                        id="password"
                        wire:model="password"
                        placeholder="Masukkan kata sandi"
                        class="block w-full pl-11 pr-11 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors outline-hidden font-medium"
                        required
                    />
                    <!-- Eye Button Toggle (Show/Hide Password) -->
                    <button
                        type="button"
                        @click="showPass = !showPass"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer transition"
                        title="Tampilkan / Sembunyikan Kata Sandi"
                    >
                        <!-- Open Eye -->
                        <svg x-show="!showPass" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Slashed Eye -->
                        <svg x-show="showPass" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember me & Lupa Kata Sandi -->
            <div class="flex items-center justify-between text-xs pt-0.5">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 select-none">
                    <input
                        type="checkbox"
                        name="remember"
                        wire:model="remember"
                        class="w-4 h-4 rounded text-[#641E28] border-slate-300 focus:ring-[#641E28]"
                    />
                    <span>Ingat saya di perangkat ini</span>
                </label>
                <a href="{{ route('password.request') }}" class="font-bold text-[#641E28] hover:text-[#4A151D] hover:underline transition">
                    Lupa kata sandi?
                </a>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#641E28] hover:bg-[#4A151D] focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-[#641E28] disabled:opacity-50 transition-all shadow-rose-950/20 cursor-pointer"
                >
                    <span wire:loading.remove wire:target="authenticate">
                        Masuk Sekarang
                    </span>
                    <span wire:loading wire:target="authenticate" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Memverifikasi...</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Footer link to Register -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
            Belum punya akun mahasiswa?
            <a href="{{ route('register') }}" class="font-bold text-[#641E28] hover:text-[#4A151D] transition underline decoration-rose-300 underline-offset-2">
                Daftar dengan NIM Untirta
            </a>
        </div>
    </div>
</div>
