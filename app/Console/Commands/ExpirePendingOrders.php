<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\PriceOffer;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpirePendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan otomatis pesanan QRIS pending dan tawaran harga yang menggantung lebih dari 24 jam, serta pulihkan stok produk';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai pengecekan pesanan pending dan penawaran menggantung (> 24 jam)...');

        $expiryThreshold = now()->subHours(24);
        $expiredOrdersCount = 0;
        $expiredOffersCount = 0;

        // 1. Cari pesanan QRIS / Unpaid yang masih 'pending' > 24 jam
        $pendingOrders = Order::with('product')
            ->where('status', 'pending')
            ->where('created_at', '<=', $expiryThreshold)
            ->get();

        foreach ($pendingOrders as $order) {
            DB::transaction(function () use ($order, &$expiredOrdersCount) {
                // Kunci order
                $order->lockForUpdate();

                $order->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                    'notes' => trim(($order->notes ?? '') . ' [Batal Otomatis: Batas waktu bayar 24 jam terlampaui]'),
                ]);

                // Kembalikan status barang dari 'reserved' menjadi 'available'
                if ($order->product && $order->product->status === 'reserved') {
                    $order->product->update(['status' => 'available']);
                }

                $expiredOrdersCount++;
                Log::info("Order #{$order->order_number} expired & cancelled automatically.");
            });
        }

        // 2. Cari tawaran harga (price offers) pending yang menggantung > 24 jam
        $pendingOffers = PriceOffer::with('product')
            ->where('status', 'pending')
            ->where('created_at', '<=', $expiryThreshold)
            ->get();

        foreach ($pendingOffers as $offer) {
            DB::transaction(function () use ($offer, &$expiredOffersCount) {
                $offer->update([
                    'status' => 'cancelled',
                    'seller_note' => 'Kadaluarsa otomatis: Penawaran tidak direspons lebih dari 24 jam.',
                ]);

                $expiredOffersCount++;
                Log::info("PriceOffer #{$offer->id} expired automatically.");
            });
        }

        // 3. Cari tawaran accepted yang sudah lewat 24 jam tapi tidak pernah dicheckout
        $staleAcceptedOffers = PriceOffer::with('product')
            ->where('status', 'accepted')
            ->where('updated_at', '<=', $expiryThreshold)
            ->whereDoesntHave('order', function ($q) {
                $q->whereIn('status', ['pending', 'processing', 'shipped', 'completed']);
            })
            ->get();

        foreach ($staleAcceptedOffers as $staleOffer) {
            DB::transaction(function () use ($staleOffer, &$expiredOffersCount) {
                $staleOffer->update([
                    'status' => 'cancelled',
                    'seller_note' => 'Kadaluarsa otomatis: Calon pembeli tidak melakukan checkout dalam 24 jam.',
                ]);

                // Pulihkan produk jika masih 'reserved' dan tidak ada pesanan aktif
                if ($staleOffer->product && $staleOffer->product->status === 'reserved') {
                    $hasOtherActive = Order::where('product_id', $staleOffer->product_id)
                        ->whereIn('status', ['pending', 'processing', 'shipped'])
                        ->exists();

                    if (!$hasOtherActive) {
                        $staleOffer->product->update(['status' => 'available']);
                    }
                }

                $expiredOffersCount++;
            });
        }

        $this->info("Pembersihan selesai: {$expiredOrdersCount} pesanan dibatalkan & {$expiredOffersCount} tawaran kadaluarsa dipulihkan.");

        return Command::SUCCESS;
    }
}
