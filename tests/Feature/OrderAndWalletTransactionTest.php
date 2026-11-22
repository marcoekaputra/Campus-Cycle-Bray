<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Livewire\OrderCheckout;
use App\Models\Category;
use App\Models\Order;
use App\Models\PriceOffer;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletMutation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class OrderAndWalletTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected User $seller;
    protected User $buyer;
    protected Category $category;
    protected Product $product;
    protected Wallet $sellerWallet;
    protected Wallet $buyerWallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::create([
            'nim' => '3337220010',
            'name' => 'Seller Hendra',
            'email' => 'hendra.ft@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'password' => bcrypt('password123'),
        ]);

        $this->buyer = User::create([
            'nim' => '6661220020',
            'name' => 'Buyer Rina',
            'email' => 'rina.fisip@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'password' => bcrypt('password123'),
        ]);

        // Dompet dibuat otomatis oleh Database Trigger trg_auto_create_user_wallet
        $this->sellerWallet = Wallet::firstOrCreate(['user_id' => $this->seller->id], ['balance' => 0.00, 'status' => 'active']);
        $this->buyerWallet = Wallet::firstOrCreate(['user_id' => $this->buyer->id], ['balance' => 0.00, 'status' => 'active']);
        $this->buyerWallet->update(['balance' => 200000.00]);

        $this->category = Category::create([
            'name' => 'Buku Kuliah',
            'slug' => 'buku-kuliah',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'title' => 'Buku Fisika Dasar Halliday Resnick',
            'slug' => 'buku-fisika-dasar-halliday-resnick',
            'description' => 'Buku teks fisika dasar edisi terbaru.',
            'price' => 100000.00,
            'is_negotiable' => true,
            'condition' => 'like_new',
            'condition_grade' => 'Grade A',
            'status' => 'available',
            'campus_zone' => 'Cilegon',
            'pickup_location' => 'Lobby Gedung D FT Cilegon',
        ]);
    }

    public function test_buyer_can_access_checkout_page(): void
    {
        $this->actingAs($this->buyer);

        $this->get('/checkout/' . $this->product->slug)
            ->assertStatus(200)
            ->assertSee('Buku Fisika Dasar Halliday Resnick')
            ->assertSee('Rp 100.000')
            ->assertSee('Lobby Gedung D FT Cilegon');
    }

    public function test_buyer_can_top_up_wallet_in_checkout(): void
    {
        $this->actingAs($this->buyer);

        Livewire::test(OrderCheckout::class, ['slug' => $this->product->slug])
            ->set('topupAmount', '50000')
            ->call('performTopup')
            ->assertHasNoErrors();

        $this->assertEquals(250000.00, $this->buyerWallet->fresh()->balance);

        $this->assertDatabaseHas('wallet_mutations', [
            'wallet_id' => $this->buyerWallet->id,
            'type' => 'credit',
            'amount' => 50000.00,
            'reference_type' => 'topup',
        ]);
    }

    public function test_buyer_can_checkout_with_wallet_payment(): void
    {
        $this->actingAs($this->buyer);

        Livewire::test(OrderCheckout::class, ['slug' => $this->product->slug])
            ->set('deliveryMethod', 'pickup')
            ->set('paymentMethod', 'wallet')
            ->set('meetupLocation', 'Kantin FT Cilegon')
            ->set('notes', 'COD jam 1 siang')
            ->call('processCheckout')
            ->assertHasNoErrors()
            ->assertRedirect('/dashboard');

        // Saldo pembeli terpotong Rp 101.500 (dari 200.000 jadi 98.500, termasuk application fee 1.5% = Rp 1.500)
        $this->assertEquals(98500.00, $this->buyerWallet->fresh()->balance);

        // Mutasi debit tercatat
        $this->assertDatabaseHas('wallet_mutations', [
            'wallet_id' => $this->buyerWallet->id,
            'type' => 'debit',
            'amount' => 101500.00,
            'reference_type' => 'order_payment',
        ]);

        // Order tersimpan dengan status processing & paid
        $this->assertDatabaseHas('orders', [
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 101500.00,
            'buyer_app_fee' => 1500.00,
            'seller_app_fee' => 1500.00,
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        // Status produk berubah jadi reserved
        $this->assertEquals('reserved', $this->product->fresh()->status);
    }

    public function test_checkout_applies_accepted_negotiated_price(): void
    {
        $this->actingAs($this->buyer);

        // Tawaran disetujui sebesar 80.000 (harga asli 100.000)
        $offer = PriceOffer::create([
            'product_id' => $this->product->id,
            'buyer_id' => $this->buyer->id,
            'offered_price' => 80000.00,
            'status' => 'accepted',
        ]);

        Livewire::withQueryParams(['offer_id' => $offer->id])
            ->test(OrderCheckout::class, ['slug' => $this->product->slug])
            ->set('deliveryMethod', 'pickup')
            ->set('paymentMethod', 'wallet')
            ->set('meetupLocation', 'Perpustakaan Untirta')
            ->call('processCheckout')
            ->assertHasNoErrors();

        // Total yang dipotong sesuai harga nego 80.000 + fee 1.5% (1.200) = 81.200 (saldo dari 200.000 jadi 118.800)
        $this->assertEquals(118800.00, $this->buyerWallet->fresh()->balance);

        $this->assertDatabaseHas('orders', [
            'price_offer_id' => $offer->id,
            'total_amount' => 81200.00,
            'buyer_app_fee' => 1200.00,
        ]);
    }

    public function test_complete_order_triggers_automatic_fund_disbursement_and_marks_product_sold(): void
    {
        // 1. Buat order yang sudah dibayar via wallet
        $order = Order::create([
            'order_number' => 'ORD-20261025-TEST1',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 100000.00,
            'status' => 'processing',
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'meetup_location' => 'Kantin FT Cilegon',
        ]);

        // Saldo awal seller adalah 0
        $this->assertEquals(0.00, $this->sellerWallet->fresh()->balance);

        $this->actingAs($this->buyer);

        // 2. Pembeli mengonfirmasi pesanan selesai
        Livewire::test(Dashboard::class)
            ->call('completeOrder', $order->id)
            ->assertHasNoErrors();

        // 3. Verifikasi Database Trigger (trg_auto_disburse_completed_order):
        // a. Saldo penjual OTOMATIS bertambah Rp 100.000
        $this->assertEquals(100000.00, $this->sellerWallet->fresh()->balance);

        // b. Mutasi kredit tercatat di tabel wallet_mutations
        $this->assertDatabaseHas('wallet_mutations', [
            'wallet_id' => $this->sellerWallet->id,
            'order_id' => $order->id,
            'type' => 'credit',
            'amount' => 100000.00,
            'reference_type' => 'order_disbursement',
        ]);

        // c. Status produk OTOMATIS diubah trigger menjadi 'sold'
        $this->assertEquals('sold', $this->product->fresh()->status);

        // d. Status order menjadi 'completed'
        $this->assertEquals('completed', $order->fresh()->status);
    }

    public function test_seller_statistics_view_aggregates_sales_correctly(): void
    {
        // Selesaikan 1 pesanan senilai Rp 100.000
        $order = Order::create([
            'order_number' => 'ORD-20261025-STAT1',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 100000.00,
            'status' => 'completed',
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'meetup_location' => 'FT Cilegon',
        ]);

        // Cek data agregasi langsung dari Database View v_seller_statistics
        $stats = DB::table('v_seller_statistics')
            ->where('seller_id', $this->seller->id)
            ->first();

        $this->assertNotNull($stats);
        $this->assertEquals('Seller Hendra', $stats->seller_name);
        $this->assertEquals(1, $stats->completed_orders);
        $this->assertEquals(100000.00, (float) $stats->total_revenue);
    }
}
