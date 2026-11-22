<x-layouts.app :title="'Dashboard Mahasiswa - CampusCycle Untirta'">
    <div class="max-w-5xl mx-auto w-full space-y-6">
        <!-- Notification Alert -->
        @if (session('status'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center justify-between shadow-xs">
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

        <!-- Profile Hero Banner -->
        <div class="bg-gradient-to-r from-[#641E28] via-[#782231] to-[#8C283A] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-rose-900/40">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4A151D] to-[#641E28] border border-white/20 flex items-center justify-center text-2xl font-black text-[#EDAB0F] shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-2xl font-black tracking-tight">{{ Auth::user()->name }}</h1>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/15 text-rose-100 border border-white/20">
                                <svg class="w-3.5 h-3.5 text-[#EDAB0F]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Terverifikasi Untirta
                            </span>
                        </div>
                        <p class="text-rose-200 text-sm mt-0.5 flex items-center gap-3">
                            <span>NIM: <strong class="text-white font-mono">{{ Auth::user()->nim ?? '-' }}</strong></span>
                            <span>•</span>
                            <span>{{ Auth::user()->campus_name ?? 'Universitas Sultan Ageng Tirtayasa' }}</span>
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 transition backdrop-blur-sm cursor-pointer">
                        Keluar Akun
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- Dompet Digital -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200/80">
                <div class="flex items-center justify-between text-slate-500 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Saldo Dompet</span>
                    <span class="w-8 h-8 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center font-bold text-xs">Rp</span>
                </div>
                <div class="text-2xl font-black text-slate-900">Rp 0,00</div>
                <p class="text-xs text-slate-400 mt-1">Dompet terhubung otomatis dengan akun</p>
            </div>

            <!-- Produk Aktif -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200/80">
                <div class="flex items-center justify-between text-slate-500 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Barang Dijual</span>
                    <span class="w-8 h-8 rounded-xl bg-rose-50 text-[#641E28] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                </div>
                <div class="text-2xl font-black text-slate-900">0 Produk</div>
                <p class="text-xs text-slate-400 mt-1">Siap tayang di marketplace kampus</p>
            </div>

            <!-- Transaksi & Nego -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200/80">
                <div class="flex items-center justify-between text-slate-500 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider">Tawaran Harga Masuk</span>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </span>
                </div>
                <div class="text-2xl font-black text-slate-900">0 Penawaran</div>
                <p class="text-xs text-slate-400 mt-1">Negosiasi harga aktif antar mahasiswa</p>
            </div>
        </div>

        <!-- Detail Informasi Akun Mahasiswa -->
        <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200/80">
            <h3 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#641E28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Data Mahasiswa Terverifikasi
            </h3>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div>
                    <dt class="text-xs font-semibold text-slate-400 uppercase">Nama Lengkap</dt>
                    <dd class="text-slate-800 font-bold mt-0.5">{{ Auth::user()->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold text-slate-400 uppercase">Nomor Induk Mahasiswa (NIM)</dt>
                    <dd class="text-slate-800 font-bold mt-0.5">{{ Auth::user()->nim ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold text-slate-400 uppercase">Alamat Email Terdaftar</dt>
                    <dd class="text-slate-800 font-medium mt-0.5">{{ Auth::user()->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold text-slate-400 uppercase">Afiliasi Universitas</dt>
                    <dd class="text-[#641E28] font-bold mt-0.5">{{ Auth::user()->campus_name ?? 'Universitas Sultan Ageng Tirtayasa' }}</dd>
                </div>
            </dl>
        </div>
    </div>
</x-layouts.app>
