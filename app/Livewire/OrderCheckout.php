<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\PriceOffer;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\WalletMutation;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Checkout & Pembayaran - CampusCycle Untirta')]
class OrderCheckout extends Component
{
    public Product $product;
    public ?PriceOffer $priceOffer = null;

    // Logistik & Pengiriman
    public string $deliveryMethod = 'delivery'; // pickup (Ambil/COD), delivery (Ekspedisi/Campus Delivery)
    public string $selectedCourier = 'jnt'; // jnt, jne, sicepat, untirta_express, pickup
    public string $destinationZone = 'Sindangsari'; // Cilegon, Sindangsari, Pakupatan, Ciwaru
    public string $destinationAddress = '';
    public string $meetupLocation = '';
    public string $notes = '';

    // Pembayaran Cashless: 'wallet', 'va_bca', 'va_bri', 'va_mandiri'
    public string $paymentMethod = 'wallet';

    // State Virtual Account Pesanan
    public ?array $activeVa = null;
    public bool $showVaModal = false;

    // Modal Top-up Cepat via QRIS
    public bool $showTopupModal = false;
    public string $topupAmount = '100000';
    public ?array $activeTopupQris = null;
    public bool $showTopupQrisModal = false;

    public function mount(string $slug): void
    {
        $this->product = Product::with(['category', 'seller'])->where('slug', $slug)->firstOrFail();

        if (Auth::id() === $this->product->seller_id) {
            session()->flash('error', 'Anda tidak dapat membeli barang dagangan Anda sendiri.');
            $this->redirect(route('product.detail', $this->product->slug), navigate: true);
            return;
        }

        if ($this->product->status === 'sold') {
            session()->flash('error', 'Maaf, barang ini sudah terjual (Sold Out).');
            $this->redirect(route('product.detail', $this->product->slug), navigate: true);
            return;
        }

        $offerId = request()->query('offer_id');
        if ($offerId) {
            $this->priceOffer = PriceOffer::where('id', $offerId)
                ->where('product_id', $this->product->id)
                ->where('buyer_id', Auth::id())
                ->where('status', 'accepted')
                ->first();
        }

        $this->meetupLocation = $this->product->pickup_location ?: 'Kampus Untirta ' . $this->product->campus_zone;
        $this->destinationZone = Auth::user()->campus_zone ?: 'Sindangsari';
        $this->destinationAddress = 'Kosan / Gedung Kuliah Kampus Untirta ' . $this->destinationZone;

        Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00, 'status' => 'active']);
        Wallet::firstOrCreate(['user_id' => $this->product->seller_id], ['balance' => 0.00, 'status' => 'active']);
    }

    public function updatedDeliveryMethod(string $value): void
    {
        if ($value === 'pickup') {
            $this->selectedCourier = 'pickup';
        } elseif ($this->selectedCourier === 'pickup') {
            $this->selectedCourier = 'jnt';
        }
    }

    public function updatedSelectedCourier(string $value): void
    {
        if ($value === 'pickup') {
            $this->deliveryMethod = 'pickup';
        } else {
            $this->deliveryMethod = 'delivery';
        }
    }

    /**
     * Hitung harga barang (harga normal atau harga tawar yang diterima)
     */
    public function getItemPriceProperty(): float
    {
        if ($this->priceOffer && $this->priceOffer->status === 'accepted') {
            return (float) $this->priceOffer->offered_price;
        }

        return (float) $this->product->price;
    }

    /**
     * Hitung ongkos kirim berdasarkan pilihan ekspedisi, rute kampus, dan ukuran barang
     */
    public function calculateCourierFee(string $courierCode): float
    {
        if ($courierCode === 'pickup') {
            return 0.00;
        }

        $sellerZone = $this->product->campus_zone ?: 'Sindangsari';
        $buyerZone = $this->destinationZone ?: 'Sindangsari';
        $isSameZone = ($sellerZone === $buyerZone);
        $sizeTier = $this->product->size_tier ?: 'small';

        return match ($courierCode) {
            'untirta_express' => match ($sizeTier) {
                'bulky' => $isSameZone ? 25000.00 : 40000.00,
                'medium' => $isSameZone ? 12000.00 : 18000.00,
                default => $isSameZone ? 7000.00 : 12000.00,
            },
            'sicepat' => match ($sizeTier) {
                'bulky' => $isSameZone ? 30000.00 : 45000.00,
                'medium' => $isSameZone ? 14000.00 : 20000.00,
                default => $isSameZone ? 9000.00 : 14000.00,
            },
            'jnt' => match ($sizeTier) {
                'bulky' => $isSameZone ? 35000.00 : 85000.00,
                'medium' => $isSameZone ? 15000.00 : 22000.00,
                default => $isSameZone ? 10000.00 : 15000.00,
            },
            'jne' => match ($sizeTier) {
                'bulky' => $isSameZone ? 40000.00 : 55000.00,
                'medium' => $isSameZone ? 18000.00 : 25000.00,
                default => $isSameZone ? 12000.00 : 18000.00,
            },
            default => $isSameZone ? 10000.00 : 15000.00,
        };
    }

    /**
     * Daftar opsi ekspedisi & kurir yang dapat dipilih pembeli
     */
    public function getAvailableCouriersProperty(): array
    {
        return [
            'jnt' => [
                'code' => 'jnt',
                'name' => 'J&T Express',
                'service' => 'EZ (Reguler)',
                'eta' => '1 - 2 Hari',
                'badge' => 'Populer',
                'badge_color' => 'bg-rose-100 text-[#641E28] border-rose-200',
                'icon' => '📦',
                'fee' => $this->calculateCourierFee('jnt'),
                'description' => 'Drop-off gerai terdekat kampus, antar cepat ke kosan / gedung kuliah.',
            ],
            'jne' => [
                'code' => 'jne',
                'name' => 'JNE Express',
                'service' => 'REG (Reguler)',
                'eta' => '1 - 2 Hari',
                'badge' => 'Terpercaya',
                'badge_color' => 'bg-blue-100 text-blue-800 border-blue-200',
                'icon' => '🚚',
                'fee' => $this->calculateCourierFee('jne'),
                'description' => 'Jaringan ekspedisi resmi jangkauan luas Serang, Cilegon & Banten.',
            ],
            'sicepat' => [
                'code' => 'sicepat',
                'name' => 'SiCepat Ekspres',
                'service' => 'HALU (Hemat)',
                'eta' => '1 - 3 Hari',
                'badge' => 'Paling Hemat',
                'badge_color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'icon' => '⚡',
                'fee' => $this->calculateCourierFee('sicepat'),
                'description' => 'Tarif ekonomis ramah kantong mahasiswa.',
            ],
            'untirta_express' => [
                'code' => 'untirta_express',
                'name' => 'Kurir Kilat Untirta',
                'service' => 'Same-Day Antar-Kampus',
                'eta' => '3 - 6 Jam (Same-Day)',
                'badge' => '⚡ Super Cepat',
                'badge_color' => 'bg-amber-100 text-amber-900 border-amber-300',
                'icon' => '🚀',
                'fee' => $this->calculateCourierFee('untirta_express'),
                'description' => 'Kurir resmi mahasiswa antar kampus FT Cilegon - Sindangsari - Pakupatan - Ciwaru.',
            ],
            'pickup' => [
                'code' => 'pickup',
                'name' => 'COD Kampus (Ketemuan Langsung)',
                'service' => 'Janji Temu di Area Kampus Penjual',
                'eta' => 'Langsung (Hari H)',
                'badge' => 'Gratis Ongkir',
                'badge_color' => 'bg-slate-100 text-slate-700 border-slate-200',
                'icon' => '🤝',
                'fee' => 0.00,
                'description' => 'Ketemuan langsung di fakultas/kantin. Pembayaran tetap cashless via Escrow demi keamanan.',
            ],
        ];
    }

    /**
     * Ongkir sesuai ekspedisi yang dipilih
     */
    public function getShippingFeeProperty(): float
    {
        if ($this->deliveryMethod === 'pickup' || $this->selectedCourier === 'pickup') {
            return 0.00;
        }

        return $this->calculateCourierFee($this->selectedCourier);
    }

    /**
     * Application Fee Pembeli (1.5% dari harga barang)
     */
    public function getBuyerAppFeeProperty(): float
    {
        return round($this->itemPrice * 0.015, 2);
    }

    /**
     * Application Fee Penjual (1.5% dari harga barang yang dipotong saat pencairan)
     */
    public function getSellerAppFeeProperty(): float
    {
        return round($this->itemPrice * 0.015, 2);
    }

    /**
     * Total tagihan pembeli = harga barang + ongkos kirim + application fee 1.5%
     */
    public function getTotalAmountProperty(): float
    {
        return $this->itemPrice + $this->shippingFee + $this->buyerAppFee;
    }

    public function getBuyerWalletProperty(): Wallet
    {
        return Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00, 'status' => 'active']);
    }

    public function getWalletProperty(): Wallet
    {
        return $this->buyerWallet;
    }

    public function openTopupModal(): void
    {
        $this->showTopupModal = true;
        $this->showTopupQrisModal = false;
        $this->activeTopupQris = null;
    }

    public function closeTopupModal(): void
    {
        $this->showTopupModal = false;
        $this->showTopupQrisModal = false;
        $this->activeTopupQris = null;
        $this->resetErrorBag();
    }

    public function performTopup(): void
    {
        $amount = (float) $this->topupAmount;
        if ($amount < 10000) {
            $this->addError('topupAmount', 'Minimal top up saldo adalah Rp 10.000');
            return;
        }

        $wallet = $this->buyerWallet;
        $before = (float) $wallet->balance;
        $after = $before + $amount;

        DB::transaction(function () use ($wallet, $amount, $before, $after) {
            $wallet->update(['balance' => $after]);

            WalletMutation::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'description' => 'Top Up Saldo Dompet Instan',
                'reference_type' => 'topup',
            ]);
        });

        $this->closeTopupModal();
        session()->flash('status', 'Top up saldo sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil!');
    }

    public function generateTopupQris(MidtransService $midtransService): void
    {
        $amount = (float) $this->topupAmount;
        if ($amount < 10000) {
            $this->addError('topupAmount', 'Minimal top up saldo adalah Rp 10.000');
            return;
        }

        $user = Auth::user();
        $orderId = 'TOPUP-' . $user->id . '-' . date('YmdHis') . '-' . strtoupper(Str::random(4));

        $this->activeTopupQris = $midtransService->createQrisTransaction(
            $orderId,
            $amount,
            $user,
            'Top Up Saldo CampusWallet Untirta'
        );

        $this->showTopupQrisModal = true;
    }

    public function simulateTopupSuccess(MidtransService $midtransService): void
    {
        if (!$this->activeTopupQris) {
            return;
        }

        $refId = $this->activeTopupQris['order_id'];
        $amount = (float) $this->activeTopupQris['gross_amount'];

        $midtransService->confirmPayment($refId, $amount);
        $this->closeTopupModal();
        session()->flash('status', '⚡ [Simulasi Sandbox Berhasil] Top up saldo Rp ' . number_format($amount, 0, ',', '.') . ' telah masuk ke dompet Anda!');
    }

    public function processCheckout(): void
    {
        $rules = [
            'deliveryMethod' => ['required', 'in:pickup,delivery'],
            'paymentMethod' => ['required', 'in:wallet,va_bca,va_bri,va_mandiri'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];

        if ($this->deliveryMethod === 'delivery') {
            $rules['destinationZone'] = ['required', 'in:Cilegon,Sindangsari,Pakupatan,Ciwaru'];
            $rules['destinationAddress'] = ['required', 'string', 'max:255'];
        } else {
            $rules['meetupLocation'] = ['required', 'string', 'max:255'];
        }

        $this->validate($rules, [
            'meetupLocation.required' => 'Titik kumpul COD di kampus wajib diisi.',
            'destinationAddress.required' => 'Alamat tujuan pengiriman antar-kampus wajib diisi.',
            'paymentMethod.required' => 'Pilih salah satu metode pembayaran cashless yang tersedia.',
            'paymentMethod.in' => 'Metode pembayaran tidak valid.',
        ]);

        $totalAmount = $this->totalAmount;
        $wallet = $this->buyerWallet;
        $method = $this->paymentMethod;

        // Validasi Saldo jika membayar via Dompet (Wallet)
        if ($method === 'wallet' && $wallet->balance < $totalAmount) {
            $this->addError('paymentMethod', 'Saldo dompet tidak mencukupi (Saldo: Rp ' . number_format($wallet->balance, 0, ',', '.') . ', Total: Rp ' . number_format($totalAmount, 0, ',', '.') . '). Silakan lakukan Top Up terlebih dahulu.');
            return;
        }

        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // Siapkan detail ekspedisi & nomor resi otomatis
        $courierInfo = $this->availableCouriers[$this->selectedCourier] ?? null;
        $courierName = $courierInfo ? $courierInfo['name'] . ' - ' . $courierInfo['service'] : 'Ekspedisi';

        $trackingNumber = match ($this->selectedCourier) {
            'jnt' => 'JNT-CC' . date('Ymd') . rand(1000, 9999),
            'jne' => 'JNE-CC' . date('Ymd') . rand(1000, 9999),
            'sicepat' => 'SCP-CC' . date('Ymd') . rand(1000, 9999),
            'untirta_express' => 'UNT-EXP' . date('Ymd') . rand(1000, 9999),
            default => 'COD-' . strtoupper(Str::random(8)),
        };

        $meetupText = ($this->deliveryMethod === 'delivery')
            ? 'Ekspedisi: ' . $courierName . ' ke Kampus ' . $this->destinationZone . ' (' . $this->destinationAddress . ')'
            : 'Titik Temu COD: ' . $this->meetupLocation;

        $orderNotes = trim(($this->notes ? $this->notes . "\n" : '') . 'Ekspedisi: ' . $courierName . ' | Resi: ' . $trackingNumber);

        // 1. Jika Pembayaran via Virtual Account (BCA, BRI, Mandiri)
        if (in_array($method, ['va_bca', 'va_bri', 'va_mandiri'])) {
            $bank = match ($method) {
                'va_bca' => 'bca',
                'va_bri' => 'bri',
                'va_mandiri' => 'mandiri',
            };

            $vaPrefix = match ($bank) {
                'bca' => '80777',
                'bri' => '88888',
                'mandiri' => '89508',
            };

            $vaNumber = $vaPrefix . mt_rand(10000000, 99999999);
            $vaExpiredAt = now()->addHours(24);

            try {
                DB::transaction(function () use ($orderNumber, $totalAmount, $trackingNumber, $meetupText, $orderNotes, $bank, $vaNumber, $vaExpiredAt) {
                    $lockedProduct = Product::where('id', $this->product->id)->lockForUpdate()->firstOrFail();
                    if ($lockedProduct->status === 'sold') {
                        throw new \Exception('Maaf, produk ini baru saja dibeli oleh mahasiswa lain.');
                    }

                    Order::create([
                        'order_number' => $orderNumber,
                        'buyer_id' => Auth::id(),
                        'seller_id' => $this->product->seller_id,
                        'product_id' => $this->product->id,
                        'price_offer_id' => $this->priceOffer?->id,
                        'total_amount' => $totalAmount,
                        'status' => 'pending',
                        'payment_method' => $this->paymentMethod,
                        'payment_status' => 'unpaid',
                        'delivery_method' => $this->deliveryMethod,
                        'destination_zone' => $this->deliveryMethod === 'delivery' ? $this->destinationZone : null,
                        'destination_address' => $this->deliveryMethod === 'delivery' ? $this->destinationAddress : null,
                        'shipping_fee' => $this->shippingFee,
                        'buyer_app_fee' => $this->buyerAppFee,
                        'seller_app_fee' => $this->sellerAppFee,
                        'net_seller_amount' => ($this->itemPrice - $this->sellerAppFee) + $this->shippingFee,
                        'va_bank' => $bank,
                        'va_number' => $vaNumber,
                        'va_expired_at' => $vaExpiredAt,
                        'tracking_number' => $trackingNumber,
                        'meetup_location' => $meetupText,
                        'notes' => $orderNotes,
                        'paid_at' => null,
                    ]);

                    $lockedProduct->update(['status' => 'reserved']);
                });

                $this->activeVa = [
                    'order_number' => $orderNumber,
                    'bank' => $bank,
                    'bank_name' => match ($bank) {
                        'bca' => 'BCA Virtual Account',
                        'bri' => 'BRI Virtual Account (BRIVA)',
                        'mandiri' => 'Mandiri Virtual Account',
                    },
                    'va_number' => $vaNumber,
                    'amount' => $totalAmount,
                    'expired_at' => $vaExpiredAt->format('d M Y, H:i') . ' WIB',
                ];

                $this->showVaModal = true;
                return;
            } catch (\Throwable $e) {
                $this->addError('paymentMethod', 'Terjadi kesalahan sistem: ' . $e->getMessage());
                return;
            }
        }

        // 2. Jika Pembayaran via CampusWallet
        try {
            DB::transaction(function () use ($orderNumber, $totalAmount, $wallet, $trackingNumber, $meetupText, $orderNotes) {
                $lockedProduct = Product::where('id', $this->product->id)->lockForUpdate()->firstOrFail();
                if ($lockedProduct->status === 'sold') {
                    throw new \Exception('Maaf, produk ini baru saja dibeli oleh mahasiswa lain.');
                }

                $lockedWallet = Wallet::where('id', $wallet->id)->lockForUpdate()->firstOrFail();
                if ($lockedWallet->balance < $totalAmount) {
                    throw new \Exception('Saldo dompet tidak mencukupi untuk melakukan pembayaran.');
                }

                $balanceBefore = (float) $lockedWallet->balance;
                $balanceAfter = $balanceBefore - $totalAmount;

                $lockedWallet->update(['balance' => $balanceAfter]);

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'buyer_id' => Auth::id(),
                    'seller_id' => $this->product->seller_id,
                    'product_id' => $this->product->id,
                    'price_offer_id' => $this->priceOffer?->id,
                    'total_amount' => $totalAmount,
                    'status' => 'processing',
                    'payment_method' => 'wallet',
                    'payment_status' => 'paid',
                    'delivery_method' => $this->deliveryMethod,
                    'destination_zone' => $this->deliveryMethod === 'delivery' ? $this->destinationZone : null,
                    'destination_address' => $this->deliveryMethod === 'delivery' ? $this->destinationAddress : null,
                    'shipping_fee' => $this->shippingFee,
                    'buyer_app_fee' => $this->buyerAppFee,
                    'seller_app_fee' => $this->sellerAppFee,
                    'net_seller_amount' => ($this->itemPrice - $this->sellerAppFee) + $this->shippingFee,
                    'tracking_number' => $trackingNumber,
                    'meetup_location' => $meetupText,
                    'notes' => $orderNotes,
                    'paid_at' => now(),
                ]);

                WalletMutation::create([
                    'wallet_id' => $lockedWallet->id,
                    'order_id' => $order->id,
                    'type' => 'debit',
                    'amount' => $totalAmount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'description' => 'Pembayaran Pesanan #' . $orderNumber . ' (Termasuk Biaya Layanan Aplikasi 1.5%)',
                    'reference_type' => 'order_payment',
                    'reference_id' => $order->id,
                ]);

                $lockedProduct->update(['status' => 'reserved']);
            });

            session()->flash('status', 'Pesanan #' . $orderNumber . ' berhasil dibuat & dibayar via CampusWallet! Faktur pembelian resmi dapat diakses di Dashboard.');
            $this->redirect(route('dashboard'), navigate: true);
        } catch (\Throwable $e) {
            $this->addError('paymentMethod', 'Transaksi gagal: ' . $e->getMessage());
        }
    }

    /**
     * Simulasi instan pelunasan Virtual Account pada sandbox
     */
    public function simulateVaPayment(string $orderNumber): void
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
            'paid_at' => now(),
        ]);

        $this->showVaModal = false;
        session()->flash('status', '⚡ [Simulasi Berhasil] Pembayaran ' . $order->formattedVaBank() . ' #' . $orderNumber . ' terverifikasi lunas! Dana tersimpan aman di Escrow Untirta.');
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function closeVaModal(): void
    {
        $this->showVaModal = false;
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.order-checkout');
    }
}
