<?php

namespace App\Livewire;

use App\Models\Dispute;
use App\Models\Order;
use App\Models\PriceOffer;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wallet;
use App\Models\WalletMutation;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Dashboard Mahasiswa - CampusCycle Untirta')]
class Dashboard extends Component
{
    use WithFileUploads;

    // Active Tab: 'offers', 'orders', 'sales', 'wallet', 'stats', 'products'
    public string $activeTab = 'offers';

    // Form input resi / plat nomor mobil pick-up per order id
    public array $inputTrackingNumber = [];

    // Modal Top-up di Dashboard
    public bool $showTopupModal = false;
    public string $topupAmount = '100000';
    public ?array $activeTopupQris = null;
    public bool $showTopupQrisModal = false;

    // Modal Bayar Pesanan Tertunda via QRIS
    public ?array $activeOrderQris = null;
    public bool $showOrderQrisModal = false;

    // Modal Rating & Ulasan (Review)
    public bool $showReviewModal = false;
    public ?int $reviewOrderId = null;
    public int $reviewRating = 5;
    public string $reviewComment = '';

    // Modal Komplain & Pengajuan Return
    public bool $showReturnModal = false;
    public ?int $returnOrderId = null;
    public string $returnReason = 'Barang Rusak / Cacat Pengiriman';
    public string $returnDescription = '';
    public $returnProofImage = null;
    public string $returnDeliveryMethod = 'cod'; // 'cod' (Janji temu via chat) atau 'delivery' (Jasa kurir tersistem)
    public string $returnCourier = 'jnt';

    /**
     * Terima tawaran harga dari calon pembeli
     */
    public function acceptOffer(int $offerId): void
    {
        $offer = PriceOffer::with(['product', 'buyer'])->findOrFail($offerId);

        if ($offer->product->seller_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak memiliki hak akses untuk mengelola tawaran ini.');
            return;
        }

        DB::transaction(function () use ($offer) {
            $offer->update([
                'status' => 'accepted',
                'seller_note' => 'Tawaran diterima oleh penjual. Silakan lanjutkan checkout pesanan.',
            ]);

            PriceOffer::where('product_id', $offer->product_id)
                ->where('id', '!=', $offer->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'seller_note' => 'Penjual telah menerima tawaran pembeli lain untuk barang ini.',
                ]);

            $offer->product->update(['status' => 'reserved']);
        });

        session()->flash('status', 'Tawaran dari ' . $offer->buyer->name . ' sebesar Rp ' . number_format($offer->offered_price, 0, ',', '.') . ' berhasil DITERIMA! Pembeli dapat melanjutkan ke checkout.');
    }

    /**
     * Tolak tawaran harga dari pembeli
     */
    public function rejectOffer(int $offerId): void
    {
        $offer = PriceOffer::with('product')->findOrFail($offerId);

        if ($offer->product->seller_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak memiliki hak akses untuk mengelola tawaran ini.');
            return;
        }

        $offer->update([
            'status' => 'rejected',
            'seller_note' => 'Maaf, penawaran harga ini ditolak oleh penjual.',
        ]);

        session()->flash('status', 'Tawaran harga berhasil DITOLAK.');
    }

    /**
     * Penjual menginput No. Resi atau Plat Nomor Mobil Pick-up sebelum mengubah status menjadi 'shipped' (Dikirim)
     */
    public function shipOrder(int $orderId): void
    {
        $order = Order::with('product')->findOrFail($orderId);

        if ($order->seller_id !== Auth::id()) {
            session()->flash('error', 'Hanya penjual barang ini yang dapat menginput bukti pengiriman.');
            return;
        }

        $tracking = trim($this->inputTrackingNumber[$orderId] ?? '');

        if (empty($tracking)) {
            $this->addError("tracking_{$orderId}", 'Nomor Resi Kurir atau Plat Nomor Mobil Pick-up wajib diisi.');
            return;
        }

        $order->update([
            'status' => 'shipped',
            'tracking_number' => $tracking,
        ]);

        session()->flash('status', 'Pesanan #' . $order->order_number . ' telah dikirim! Bukti Pengiriman/Plat Mobil: ' . $tracking);
    }

    /**
     * Pembeli mengonfirmasi bahwa barang telah diterima (Pesanan Selesai).
     * ⚡ Dibungkus DB::transaction() & Memicu Database Trigger trg_auto_disburse_completed_order
     */
    public function completeOrder(int $orderId): void
    {
        $order = null;

        try {
            DB::transaction(function () use ($orderId, &$order) {
                $order = Order::with('product')->lockForUpdate()->findOrFail($orderId);

                if ($order->buyer_id !== Auth::id()) {
                    throw new \Exception('Hanya pembeli yang berhak mengonfirmasi penerimaan barang.');
                }

                if ($order->status === 'completed') {
                    return;
                }

                $order->update([
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'completed_at' => now(),
                ]);

                // Pastikan produk terkait tercatat sold
                if ($order->product) {
                    $order->product->update(['status' => 'sold']);
                }
            });

            // Buka modal rating & review untuk pesanan ini
            if ($order) {
                $this->openReviewModal($order->id);
            }

            session()->flash('status', 'Pesanan #' . $order->order_number . ' telah selesai! Dana Rp ' . number_format($order->total_amount, 0, ',', '.') . ' otomatis dicairkan ke saldo penjual. Silakan berikan ulasan penilaian Anda.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menyelesaikan pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Buka modal pengajuan komplain & return (khusus non-COD / pengiriman)
     */
    public function openReturnModal(int $orderId): void
    {
        $order = Order::with('product')->where('buyer_id', Auth::id())->findOrFail($orderId);

        if ($order->delivery_method !== 'delivery') {
            session()->flash('error', 'Pengajuan return hanya berlaku untuk transaksi dengan jasa pengiriman / non-COD.');
            return;
        }

        if ($order->return_status !== 'none' && $order->return_status !== null) {
            session()->flash('error', 'Pesanan ini sudah memiliki riwayat pengajuan return.');
            return;
        }

        $this->returnOrderId = $orderId;
        $this->returnReason = 'Barang Rusak / Cacat Pengiriman';
        $this->returnDescription = '';
        $this->returnProofImage = null;
        $this->returnDeliveryMethod = 'cod';
        $this->returnCourier = 'jnt';
        $this->showReturnModal = true;
    }

    public function closeReturnModal(): void
    {
        $this->showReturnModal = false;
        $this->returnOrderId = null;
        $this->resetErrorBag();
    }

    /**
     * Kirimkan formulir komplain pengajuan return
     */
    public function submitReturnRequest(): void
    {
        $this->validate([
            'returnReason' => ['required', 'string'],
            'returnDescription' => ['required', 'string', 'min:10'],
            'returnDeliveryMethod' => ['required', 'in:cod,delivery'],
            'returnProofImage' => ['nullable', 'image', 'max:2048'],
        ], [
            'returnDescription.min' => 'Mohon jelaskan kendala barang secara rinci minimal 10 karakter.',
            'returnProofImage.image' => 'File bukti kerusakan harus berupa format gambar (JPG, PNG).',
        ]);

        $order = Order::with('product')->where('buyer_id', Auth::id())->findOrFail($this->returnOrderId);

        $imagePath = null;
        if ($this->returnProofImage) {
            $imagePath = $this->returnProofImage->store('returns', 'public');
            $imagePath = '/storage/' . $imagePath;
        }

        $returnTrackingNumber = match ($this->returnDeliveryMethod) {
            'delivery' => 'RET-' . strtoupper($this->returnCourier) . '-' . date('Ymd') . rand(1000, 9999),
            default => 'RET-COD-' . date('Ymd') . rand(1000, 9999),
        };

        // Ongkir pengembalian barang via kurir ditanggung oleh pembeli
        $returnShippingFee = ($this->returnDeliveryMethod === 'delivery') ? 10000.00 : 0.00;

        DB::transaction(function () use ($order, $imagePath, $returnTrackingNumber, $returnShippingFee) {
            $order->update([
                'status' => 'return_requested',
                'return_status' => 'requested',
                'return_method' => $this->returnDeliveryMethod,
                'return_courier' => $this->returnDeliveryMethod === 'delivery' ? $this->returnCourier : null,
                'return_tracking_number' => $returnTrackingNumber,
                'return_shipping_fee' => $returnShippingFee,
                'return_reason' => $this->returnReason,
                'return_description' => $this->returnDescription,
                'return_proof_image' => $imagePath,
                'return_requested_at' => now(),
            ]);

            Dispute::create([
                'order_id' => $order->id,
                'complainant_id' => Auth::id(),
                'respondent_id' => $order->seller_id,
                'reason' => 'Pengajuan Return: ' . $this->returnReason,
                'description' => $this->returnDescription . "\n\nMetode Pengembalian: " . ($this->returnDeliveryMethod === 'delivery' ? 'Kurir ' . strtoupper($this->returnCourier) . ' (Resi: ' . $returnTrackingNumber . ' - Ongkir ditanggung pembeli)' : 'COD Kampus via Chat'),
                'proof_image' => $imagePath,
                'status' => 'open',
            ]);
        });

        $this->showReturnModal = false;
        session()->flash('status', 'Pengajuan return untuk pesanan #' . $order->order_number . ' berhasil dikirim! Menunggu konfirmasi penerimaan barang dari penjual dan verifikasi Admin.');
    }

    /**
     * Penjual mengonfirmasi bahwa barang return telah diterima kembali
     */
    public function confirmReturnReceivedBySeller(int $orderId): void
    {
        $order = Order::where('seller_id', Auth::id())->findOrFail($orderId);

        if ($order->return_status !== 'requested') {
            session()->flash('error', 'Status return pesanan ini tidak dapat dikonfirmasi.');
            return;
        }

        DB::transaction(function () use ($order) {
            $order->update([
                'return_status' => 'approved_by_seller',
                'return_seller_confirmed_at' => now(),
            ]);

            Dispute::where('order_id', $order->id)->update([
                'status' => 'under_review',
                'resolution_notes' => 'Penjual telah mengonfirmasi bahwa barang return telah diterima kembali dengan baik. Menunggu persetujuan admin.',
            ]);
        });

        session()->flash('status', 'Anda telah mengonfirmasi bahwa barang return pesanan #' . $order->order_number . ' telah diterima kembali. Admin akan melakukan crosscheck akhir untuk mencairkan saldo refund pembeli.');
    }

    /**
     * Buka modal pemberian rating dan ulasan pesanan
     */
    public function openReviewModal(int $orderId): void
    {
        $order = Order::with('review')->where('buyer_id', Auth::id())->where('status', 'completed')->find($orderId);
        if (!$order) {
            session()->flash('error', 'Pesanan tidak ditemukan atau belum selesai.');
            return;
        }

        if ($order->review) {
            session()->flash('status', 'Anda sudah memberikan penilaian untuk pesanan ini.');
            return;
        }

        $this->reviewOrderId = $orderId;
        $this->reviewRating = 5;
        $this->reviewComment = '';
        $this->showReviewModal = true;
    }

    public function closeReviewModal(): void
    {
        $this->showReviewModal = false;
        $this->reviewOrderId = null;
        $this->reviewRating = 5;
        $this->reviewComment = '';
        $this->resetErrorBag();
    }

    /**
     * Simpan ulasan dan rating pembeli ke penjual dengan aman
     */
    public function submitReview(): void
    {
        $this->validate([
            'reviewRating' => ['required', 'integer', 'min:1', 'max:5'],
            'reviewComment' => ['nullable', 'string', 'max:1000'],
        ]);

        if (!$this->reviewOrderId) {
            return;
        }

        $order = Order::where('id', $this->reviewOrderId)
            ->where('buyer_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        DB::transaction(function () use ($order) {
            Review::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'reviewer_id' => Auth::id(),
                    'seller_id' => $order->seller_id,
                    'product_id' => $order->product_id,
                    'rating' => $this->reviewRating,
                    'comment' => $this->reviewComment,
                ]
            );
        });

        $rating = $this->reviewRating;
        $this->closeReviewModal();
        session()->flash('status', "⭐ Terima kasih! Penilaian bintang {$rating} dan ulasan Anda berhasil disimpan.");
    }


    /**
     * Top Up saldo dompet mahasiswa dengan QRIS Midtrans Langsung
     */
    public function performTopup(MidtransService $midtransService): void
    {
        $amount = (float) $this->topupAmount;
        if ($amount < 10000) {
            $this->addError('topupAmount', 'Nominal minimal top up adalah Rp 10.000.');
            return;
        }

        $referenceId = 'TOPUP-' . Auth::id() . '-' . time();
        $user = Auth::user();

        // Request Dynamic QRIS Langsung via Midtrans Core API
        $this->activeTopupQris = $midtransService->createQrisTransaction(
            $referenceId,
            $amount,
            $user,
            'Top Up Saldo CampusWallet Untirta'
        );

        $this->showTopupModal = false;
        $this->showTopupQrisModal = true;
    }

    /**
     * Polling cek status top up QRIS
     */
    public function checkTopupStatus(MidtransService $midtransService): void
    {
        if (!$this->activeTopupQris) {
            return;
        }

        $refId = $this->activeTopupQris['order_id'];
        $amount = (float) $this->activeTopupQris['gross_amount'];

        $alreadyCredited = WalletMutation::where('description', 'like', "%#{$refId}%")->exists();
        if ($alreadyCredited) {
            $this->showTopupQrisModal = false;
            $this->activeTopupQris = null;
            session()->flash('status', 'Top up saldo sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil diverifikasi! Saldo Anda telah bertambah.');
            return;
        }

        $status = $midtransService->checkTransactionStatus($refId);
        if ($status && in_array($status['transaction_status'] ?? '', ['settlement', 'capture'])) {
            $midtransService->confirmPayment($refId, $amount);
            $this->showTopupQrisModal = false;
            $this->activeTopupQris = null;
            session()->flash('status', 'Top up saldo sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil!');
        }
    }

    /**
     * Tombol instant testing di Sandbox mode untuk simulasi scan bayar QRIS Top Up
     */
    public function simulateSuccessTopup(MidtransService $midtransService): void
    {
        if (!$this->activeTopupQris) {
            return;
        }

        $refId = $this->activeTopupQris['order_id'];
        $amount = (float) $this->activeTopupQris['gross_amount'];

        $midtransService->confirmPayment($refId, $amount);
        $this->showTopupQrisModal = false;
        $this->activeTopupQris = null;
        session()->flash('status', '⚡ [Simulasi Sandbox Berhasil] Top up saldo Rp ' . number_format($amount, 0, ',', '.') . ' telah masuk ke dompet Anda!');
    }

    public function closeTopupQrisModal(): void
    {
        $this->showTopupQrisModal = false;
        $this->activeTopupQris = null;
    }

    /**
     * Bayar pesanan yang masih pending via QRIS langsung dari Dashboard
     */
    public function payOrderQris(int $orderId, MidtransService $midtransService): void
    {
        $order = Order::with('product')->where('buyer_id', Auth::id())->findOrFail($orderId);

        if ($order->payment_status === 'paid') {
            session()->flash('status', 'Pesanan ini sudah berstatus lunas.');
            return;
        }

        $this->activeOrderQris = $midtransService->createQrisTransaction(
            $order->order_number,
            (float) $order->total_amount,
            Auth::user(),
            $order->product->title
        );

        $this->showOrderQrisModal = true;
    }

    public function checkOrderPaymentStatus(MidtransService $midtransService): void
    {
        if (!$this->activeOrderQris) {
            return;
        }

        $orderNumber = $this->activeOrderQris['order_id'];
        $order = Order::where('order_number', $orderNumber)->first();

        if ($order && $order->payment_status === 'paid') {
            $this->showOrderQrisModal = false;
            $this->activeOrderQris = null;
            session()->flash('status', '🎉 Pembayaran QRIS untuk Pesanan #' . $orderNumber . ' telah Sukses!');
            return;
        }

        $status = $midtransService->checkTransactionStatus($orderNumber);
        if ($status && in_array($status['transaction_status'] ?? '', ['settlement', 'capture'])) {
            $midtransService->confirmPayment($orderNumber, (float) $this->activeOrderQris['gross_amount']);
            $this->showOrderQrisModal = false;
            $this->activeOrderQris = null;
            session()->flash('status', '🎉 Pembayaran QRIS untuk Pesanan #' . $orderNumber . ' telah Diverifikasi!');
        }
    }

    public function simulateSuccessOrderPayment(MidtransService $midtransService): void
    {
        if (!$this->activeOrderQris) {
            return;
        }

        $orderNumber = $this->activeOrderQris['order_id'];
        $amount = (float) $this->activeOrderQris['gross_amount'];

        $midtransService->confirmPayment($orderNumber, $amount);
        $this->showOrderQrisModal = false;
        $this->activeOrderQris = null;
        session()->flash('status', '⚡ [Simulasi Sandbox Berhasil] Pesanan #' . $orderNumber . ' telah Lunas via QRIS!');
    }

    public function closeOrderQrisModal(): void
    {
        $this->showOrderQrisModal = false;
        $this->activeOrderQris = null;
    }

    public function render()
    {
        $user = Auth::user();

        $wallet = Wallet::firstOrCreate(['user_id' => $user->id], ['balance' => 0.00, 'status' => 'active']);

        $receivedOffers = PriceOffer::whereHas('product', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })
        ->with(['product', 'buyer'])
        ->latest()
        ->get();

        $mySentOffers = PriceOffer::where('buyer_id', $user->id)
            ->with(['product.seller'])
            ->latest()
            ->get();

        $myBuyerOrders = Order::where('buyer_id', $user->id)
            ->with(['product', 'seller', 'review'])
            ->latest()
            ->get();

        $mySellerOrders = Order::where('seller_id', $user->id)
            ->with(['product', 'buyer', 'review'])
            ->latest()
            ->get();


        $walletMutations = WalletMutation::where('wallet_id', $wallet->id)
            ->latest()
            ->get();

        $sellerStats = DB::table('v_seller_statistics')
            ->where('seller_id', $user->id)
            ->first();

        $myProducts = Product::where('seller_id', $user->id)
            ->with('category')
            ->latest()
            ->get();

        return view('livewire.dashboard', [
            'user' => $user,
            'wallet' => $wallet,
            'receivedOffers' => $receivedOffers,
            'mySentOffers' => $mySentOffers,
            'myBuyerOrders' => $myBuyerOrders,
            'mySellerOrders' => $mySellerOrders,
            'walletMutations' => $walletMutations,
            'sellerStats' => $sellerStats,
            'myProducts' => $myProducts,
            'pendingOffersCount' => $receivedOffers->where('status', 'pending')->count(),
            'activeOrdersCount' => $myBuyerOrders->whereIn('status', ['pending', 'processing', 'shipped'])->count(),
        ]);
    }
}
