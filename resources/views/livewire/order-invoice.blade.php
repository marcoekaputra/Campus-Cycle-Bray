<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Action Bar (Hidden when printing) -->
    <div class="flex items-center justify-between gap-4 print:hidden pb-4 border-b border-slate-200">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#641E28] transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Dashboard</span>
        </a>

        <div class="flex items-center gap-2">
            <button
                type="button"
                onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#641E28] hover:bg-[#4A151D] text-white font-bold text-xs shadow-md transition cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- INVOICE SHEET (Modern, Clean, Professional A4-Friendly Card) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-900/5 p-8 sm:p-12 space-y-8 print:shadow-none print:border-none print:p-0">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pb-6 border-b border-slate-200">
            <div class="space-y-1">
                <div class="flex items-center gap-2.5">
                    <img src="/images/campuscycle-horizontal.png" alt="CampusCycle Logo" class="h-10 w-auto object-contain" />
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    Platform Circular Marketplace Civitas Akademika Universitas Sultan Ageng Tirtayasa
                </p>
            </div>

            <div class="text-left sm:text-right space-y-1">
                <div class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300">
                    Lunas (Escrow Active)
                </div>
                <div class="text-xs text-slate-500">
                    No. Faktur: <strong class="text-slate-900 font-mono">{{ $order->invoiceNumber() }}</strong>
                </div>
                <div class="text-xs text-slate-500">
                    No. Pesanan: <strong class="text-slate-700 font-mono">{{ $order->order_number }}</strong>
                </div>
                <div class="text-xs text-slate-500">
                    Tanggal: {{ $order->created_at ? $order->created_at->format('d F Y, H:i') : now()->format('d F Y, H:i') }} WIB
                </div>
            </div>
        </div>

        <!-- Dua Kolom: Identitas Pembeli & Penjual -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-5 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
            <!-- Data Pembeli -->
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Diterbitkan Untuk (Pembeli):</span>
                <div class="font-extrabold text-slate-900 text-sm">{{ $order->buyer->name }}</div>
                <div class="text-slate-600">NIM: <strong>{{ $order->buyer->nim ?? '-' }}</strong> &bull; {{ $order->buyer->faculty ?? 'Untirta' }}</div>
                <div class="text-slate-600">Email: {{ $order->buyer->email }}</div>
                @if ($order->buyer->phone)
                    <div class="text-slate-600">WhatsApp: {{ $order->buyer->phone }}</div>
                @endif
                <div class="text-slate-500 mt-1">
                    Kampus: <strong>Untirta {{ $order->destination_zone ?? $order->buyer->campus_zone ?? 'Untirta' }}</strong>
                </div>
            </div>

            <!-- Data Penjual & Metode Transaksi -->
            <div class="space-y-1 sm:border-l sm:border-slate-200 sm:pl-6">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Penyedia Barang (Penjual):</span>
                <div class="font-extrabold text-slate-900 text-sm">{{ $order->seller->name }}</div>
                <div class="text-slate-600">NIM: <strong>{{ $order->seller->nim ?? '-' }}</strong> &bull; {{ $order->seller->faculty ?? 'Untirta' }}</div>
                <div class="text-slate-600">Lokasi: Kampus Untirta {{ $order->product->campus_zone ?? $order->seller->campus_zone }}</div>

                <div class="pt-2 border-t border-slate-200 mt-2 space-y-0.5">
                    <div class="text-slate-700">
                        Metode Bayar: <strong>{{ $order->payment_method === 'wallet' ? 'CampusWallet (Saldo Dompet)' : $order->formattedVaBank() }}</strong>
                    </div>
                    @if ($order->va_number)
                        <div class="text-slate-500 font-mono text-[11px]">
                            No. VA: {{ $order->va_number }} ({{ strtoupper($order->va_bank) }})
                        </div>
                    @endif
                    <div class="text-slate-700">
                        Metode Pengantaran: <strong>{{ $order->delivery_method === 'delivery' ? 'Jasa Ekspedisi Delivery' : 'COD Kampus (Ketemuan Langsung)' }}</strong>
                    </div>
                    @if ($order->tracking_number)
                        <div class="text-slate-500 font-mono text-[11px]">
                            No. Resi: {{ $order->tracking_number }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Barang Transaksi -->
        <div class="overflow-hidden rounded-2xl border border-slate-200">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/90 text-slate-700 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4">Deskripsi Produk</th>
                        <th class="py-3 px-4 text-center">Kondisi</th>
                        <th class="py-3 px-4 text-right">Harga Satuan</th>
                        <th class="py-3 px-4 text-center">Jumlah</th>
                        <th class="py-3 px-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    <tr>
                        <td class="py-4 px-4">
                            <div class="font-black text-slate-900 text-sm">{{ $order->product->title }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">Kategori: {{ $order->product->category->name ?? '-' }}</div>
                        </td>
                        <td class="py-4 px-4 text-center font-semibold text-slate-600">
                            {{ $order->product->condition ?? 'Bekas Layak Pakai' }}
                        </td>
                        <td class="py-4 px-4 text-right font-medium">
                            Rp {{ number_format($order->priceOffer ? $order->priceOffer->offered_price : $order->product->price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4 text-center font-bold">1</td>
                        <td class="py-4 px-4 text-right font-bold text-slate-900">
                            Rp {{ number_format($order->priceOffer ? $order->priceOffer->offered_price : $order->product->price, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Rekapitulasi Pembayaran & Application Fee -->
        <div class="flex flex-col sm:flex-row justify-between gap-6 pt-2">
            <div class="sm:max-w-xs space-y-2 text-xs text-slate-500">
                <div class="p-3.5 rounded-xl bg-rose-50/50 border border-rose-200/70 text-[11px] leading-relaxed text-slate-700">
                    <strong class="text-[#641E28] block mb-0.5">Catatan Resmi Rekening Bersama:</strong>
                    Faktur ini merupakan bukti sah transaksi digital di platform CampusCycle Untirta. Dana pembayaran telah didepositkan pada sistem escrow institusi dan akan diteruskan kepada penjual setelah barang terkonfirmasi diterima dengan baik.
                </div>
            </div>

            <div class="sm:w-72 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal Produk:</span>
                    <span class="font-bold text-slate-900">
                        Rp {{ number_format($order->priceOffer ? $order->priceOffer->offered_price : $order->product->price, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between text-slate-600">
                    <span>Ongkos Kirim Logistik:</span>
                    <span class="font-bold text-slate-900">
                        @if ($order->shipping_fee > 0)
                            Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}
                        @else
                            <span class="text-emerald-700 font-bold">GRATIS</span>
                        @endif
                    </span>
                </div>

                <div class="flex justify-between text-slate-600 pt-1 border-t border-slate-100">
                    <div>
                        <span>Biaya Layanan Aplikasi (1.5%):</span>
                        <span class="block text-[10px] text-slate-400">Escrow & Asuransi Kampus</span>
                    </div>
                    <span class="font-bold text-slate-900">
                        Rp {{ number_format($order->buyer_app_fee > 0 ? $order->buyer_app_fee : round(($order->priceOffer ? $order->priceOffer->offered_price : $order->product->price) * 0.015, 2), 0, ',', '.') }}
                    </span>
                </div>

                <div class="pt-3 border-t-2 border-slate-900 flex justify-between items-baseline">
                    <span class="font-black text-slate-900 text-sm">Total Bayar:</span>
                    <span class="text-xl font-black text-[#641E28]">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Footer Tanda Tangan & Verifikasi Digital -->
        <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-[11px] text-slate-400">
            <div>
                <p>&copy; {{ date('Y') }} CampusCycle &bull; Universitas Sultan Ageng Tirtayasa</p>
                <p>Dokumen ini dicetak secara otomatis dan sah tanpa tanda tangan basah.</p>
            </div>
            <div class="font-mono text-[10px] text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                AUTH-SHA256: {{ strtoupper(substr(hash('sha256', $order->order_number . $order->total_amount . $order->created_at), 0, 16)) }}
            </div>
        </div>
    </div>
</div>
