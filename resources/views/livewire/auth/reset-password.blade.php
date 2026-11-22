<div class="sm:mx-auto sm:w-full sm:max-w-md py-8" x-data="{ showPass: false, showConfirm: false }">
    <div class="bg-white py-8 px-6 shadow-2xl shadow-rose-950/10 sm:rounded-3xl sm:px-10 border border-slate-200/80">
        <!-- Header -->
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-rose-50 text-[#641E28] mb-3 border border-rose-100 shadow-inner">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black tracking-tight text-slate-900">
                Buat Kata Sandi Baru
            </h2>
            <p class="mt-1 text-xs text-slate-500">
                Tentukan kata sandi baru untuk akun mahasiswa CampusCycle Untirta Anda.
            </p>
        </div>

        <form wire:submit="resetPassword" class="space-y-4">
            <!-- Info Akun Mahasiswa Terverifikasi -->
            <div class="p-4 rounded-2xl bg-rose-50/70 border border-rose-200/80">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Akun Mahasiswa Terverifikasi</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#641E28] text-white">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Untirta Valid</span>
                    </span>
                </div>
                <div class="mt-1.5">
                    <div class="font-black text-slate-900 text-sm">{{ $user->name ?? $email }}</div>
                    <div class="text-xs text-slate-600 mt-0.5">NIM: <strong>{{ $user->nim ?? '-' }}</strong> &bull; {{ $user->faculty ?? 'Universitas Sultan Ageng Tirtayasa' }}</div>
                </div>
                <input type="hidden" wire:model="email" />
                @error('email')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- 1. Kata Sandi Baru + Eye Toggle -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Kata Sandi Baru <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input
                        type="password"
                        id="password"
                        wire:model="password"
                        placeholder="Minimal 6 karakter"
                        class="block w-full pl-11 pr-11 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors outline-hidden font-medium"
                        required
                        autofocus
                    />
                    <!-- Eye Button Toggle -->
                    <button
                        type="button"
                        onclick="togglePasswordVisibility('password', this)"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer transition select-none"
                        title="Tampilkan / Sembunyikan Kata Sandi"
                    >
                        <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-closed w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Konfirmasi Kata Sandi Baru + Eye Toggle -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Ulangi Kata Sandi Baru <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <input
                        type="password"
                        id="password_confirmation"
                        wire:model="password_confirmation"
                        placeholder="Ulangi kata sandi"
                        class="block w-full pl-11 pr-11 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#641E28]/20 focus:border-[#641E28] transition-colors outline-hidden font-medium"
                        required
                    />
                    <!-- Eye Button Toggle -->
                    <button
                        type="button"
                        onclick="togglePasswordVisibility('password_confirmation', this)"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer transition select-none"
                        title="Tampilkan / Sembunyikan Konfirmasi Kata Sandi"
                    >
                        <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-closed w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#641E28] hover:bg-[#4A151D] focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-[#641E28] disabled:opacity-50 transition-all shadow-rose-950/20 cursor-pointer"
                >
                    <span wire:loading.remove wire:target="resetPassword">
                        Simpan Kata Sandi Baru
                    </span>
                    <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Menyimpan...</span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

