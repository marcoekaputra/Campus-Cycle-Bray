<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Resmi #{{ $order->order_number }} - CampusCycle Untirta</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
        }
        body {
            background-color: #ffffff;
            padding: 30px;
            font-size: 13px;
            line-height: 1.5;
        }
        .header {
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: -0.5px;
        }
        .brand-subtitle {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 3px;
        }
        .invoice-badge {
            text-align: right;
        }
        .invoice-title {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }
        .invoice-number {
            font-size: 13px;
            font-weight: 700;
            color: #2563eb;
            font-family: monospace;
        }
        .status-pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .status-paid {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .status-unpaid {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .info-col {
            width: 50%;
            vertical-align: top;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px;
            margin-right: 10px;
        }
        .info-card.right {
            margin-right: 0;
            margin-left: 10px;
        }
        .info-card-title {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 4px;
        }
        .info-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }
        .info-detail {
            color: #475569;
            font-size: 12px;
            margin-top: 2px;
        }
        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .table-items th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 10px 14px;
            text-align: left;
        }
        .table-items th.text-right {
            text-align: right;
        }
        .table-items td {
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .table-items td.text-right {
            text-align: right;
        }
        .table-items tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .totals-table {
            width: 320px;
            margin-left: auto;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .totals-table td {
            padding: 6px 10px;
            font-size: 12px;
        }
        .totals-table .total-label {
            color: #64748b;
            text-align: left;
        }
        .totals-table .total-value {
            text-align: right;
            font-weight: 600;
        }
        .totals-table tr.grand-total td {
            border-top: 2px solid #1e3a8a;
            font-size: 15px;
            font-weight: 800;
            color: #1e3a8a;
            padding-top: 10px;
        }
        .footer-note {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 12px 16px;
            border-radius: 4px;
            font-size: 11px;
            color: #1e40af;
            line-height: 1.6;
        }
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signature-cell {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            font-size: 12px;
        }
        .signature-line {
            width: 180px;
            border-bottom: 1px solid #94a3b8;
            margin: 60px auto 5px auto;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    @if(request()->has('preview'))
    <div class="no-print" style="background: #1e3a8a; color: white; padding: 10px 20px; margin-bottom: 20px; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
        <span><strong>Mode Pratinjau Invoice</strong> - Anda dapat mencetak langsung atau mengunduh dokumen ini.</span>
        <button onclick="window.print()" style="background: #ffffff; color: #1e3a8a; border: none; padding: 6px 16px; border-radius: 4px; font-weight: bold; cursor: pointer;">Cetak Invoice</button>
    </div>
    @endif

    <div class="header">
        <table class="header-table">
            <tr>
                <td style="vertical-align: top;">
                    <div class="brand-title">CampusCycle</div>
                    <div class="brand-subtitle">Platform E-Commerce Sirkular Civitas Untirta Cilegon</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 5px;">
                        Fakultas Teknik Universitas Sultan Ageng Tirtayasa<br>
                        Jl. Jenderal Sudirman Km 3, Cilegon, Banten 42435
                    </div>
                </td>
                <td class="invoice-badge" style="vertical-align: top;">
                    <div class="invoice-title">INVOICE RESMI</div>
                    <div class="invoice-number">#{{ $order->order_number }}</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        Tanggal: {{ $order->created_at->format('d M Y, H:i') }} WIB
                    </div>
                    @if($order->payment_status === 'paid')
                        <span class="status-pill status-paid">LUNAS (PAID)</span>
                    @elseif($order->status === 'cancelled')
                        <span class="status-pill status-cancelled">DIBATALKAN</span>
                    @else
                        <span class="status-pill status-unpaid">MENUNGGU PEMBAYARAN</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Informasi Pihak Terlibat -->
    <table class="info-grid">
        <tr>
            <td class="info-col">
                <div class="info-card">
                    <div class="info-card-title">Informasi Pembeli</div>
                    <div class="info-name">{{ $order->buyer->name }}</div>
                    <div class="info-detail">NIM: {{ $order->buyer->nim ?: 'Mahasiswa Untirta' }}</div>
                    <div class="info-detail">Fakultas: {{ $order->buyer->faculty }}</div>
                    <div class="info-detail">Email: {{ $order->buyer->email }}</div>
                    <div class="info-detail">Lokasi/Zona: Kampus Untirta {{ $order->destination_zone ?: $order->buyer->campus_zone }}</div>
                </div>
            </td>
            <td class="info-col">
                <div class="info-card right">
                    <div class="info-card-title">Informasi Penjual</div>
                    <div class="info-name">{{ $order->seller->name }}</div>
                    <div class="info-detail">NIM: {{ $order->seller->nim ?: 'Mahasiswa Untirta' }}</div>
                    <div class="info-detail">Fakultas: {{ $order->seller->faculty }}</div>
                    <div class="info-detail">Email: {{ $order->seller->email }}</div>
                    <div class="info-detail">Kampus Asal: {{ $order->seller->campus_zone ?: 'Cilegon' }}</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Rincian Pengiriman & Logistik -->
    <div style="background-color: #f1f5f9; border-radius: 6px; padding: 10px 14px; margin-bottom: 20px; font-size: 11px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 33%;">
                    <strong>Metode Pengambilan/Kirim:</strong><br>
                    {{ $order->delivery_method === 'delivery' ? 'Antar-Kampus (Campus Delivery)' : 'Ambil Sendiri / COD' }}
                </td>
                <td style="width: 33%;">
                    <strong>Metode Pembayaran:</strong><br>
                    {{ strtoupper($order->payment_method) }} ({{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }})
                </td>
                <td style="width: 34%;">
                    <strong>Titik Temu / Alamat:</strong><br>
                    {{ $order->delivery_method === 'delivery' ? $order->destination_address : $order->meetup_location }}
                    @if($order->tracking_number)
                        <br><strong>No. Resi / Plat Mobil:</strong> {{ $order->tracking_number }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabel Rincian Produk -->
    <table class="table-items">
        <thead>
            <tr>
                <th style="width: 50%;">Deskripsi Barang</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 15%;" class="text-right">Harga Normal</th>
                <th style="width: 20%;" class="text-right">Harga Disepakati</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong style="color: #0f172a;">{{ $order->product->title }}</strong>
                    <div style="color: #64748b; font-size: 11px; margin-top: 2px;">
                        Kondisi: {{ ucfirst($order->product->condition) }} | Ukuran Logistik: {{ strtoupper($order->product->size_tier ?: 'small') }}
                    </div>
                </td>
                <td>{{ $order->product->category->name ?? 'Barang Kampus' }}</td>
                <td class="text-right">Rp {{ number_format($order->product->price, 0, ',', '.') }}</td>
                <td class="text-right" style="font-weight: 700; color: #1e3a8a;">
                    Rp {{ number_format($order->total_amount - ($order->shipping_fee ?? 0), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Ringkasan Total Tagihan -->
    <table class="totals-table">
        <tr>
            <td class="total-label">Subtotal Barang:</td>
            <td class="total-value">Rp {{ number_format($order->priceOffer ? $order->priceOffer->offered_price : $order->product->price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="total-label">Ongkos Kirim Antar-Kampus:</td>
            <td class="total-value">Rp {{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="total-label">Biaya Layanan Aplikasi (1.5%):</td>
            <td class="total-value">Rp {{ number_format($order->buyer_app_fee > 0 ? $order->buyer_app_fee : round(($order->priceOffer ? $order->priceOffer->offered_price : $order->product->price) * 0.015, 2), 0, ',', '.') }}</td>
        </tr>
        <tr class="grand-total">
            <td class="total-label" style="font-weight: 800; color: #641E28;">TOTAL PEMBAYARAN:</td>
            <td class="total-value" style="font-weight: 800; color: #641E28;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer-note">
        <strong>Ketentuan Layanan CampusCycle FT Untirta:</strong>
        <p>1. Dokumen ini merupakan bukti transaksi sah berbasis digital yang diverifikasi oleh sistem basis data CampusCycle Untirta.</p>
        <p>2. Saldo penjualan diamankan dengan escrow kampus dan otomatis dicairkan ke dompet penjual via <em>Database Trigger</em> setelah pembeli mengonfirmasi barang diterima dengan baik.</p>
        <p>3. Untuk bantuan atau pelaporan kendala transaksi, hubungi Pusat Bantuan Civitas Kampus FT Cilegon / Sindangsari.</p>
    </div>

    <!-- Tanda Tangan Digital Verifikasi -->
    <table class="signature-table">
        <tr>
            <td class="signature-cell">
                <div>Pembeli / Penerima</div>
                <div class="signature-line"></div>
                <strong>{{ $order->buyer->name }}</strong><br>
                <span style="color: #64748b; font-size: 11px;">NIM. {{ $order->buyer->nim ?: 'Mahasiswa Untirta' }}</span>
            </td>
            <td class="signature-cell">
                <div>CampusCycle Untirta System</div>
                <div class="signature-line"></div>
                <strong>Platform Administrator</strong><br>
                <span style="color: #64748b; font-size: 11px;">Fakultas Teknik Untirta</span>
            </td>
        </tr>
    </table>
</body>
</html>
