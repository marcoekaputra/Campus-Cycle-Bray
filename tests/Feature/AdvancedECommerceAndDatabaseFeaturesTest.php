<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Models\Category;
use App\Models\Order;
use App\Models\PriceOffer;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class AdvancedECommerceAndDatabaseFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected User $seller;
    protected User $buyer;
    protected User $otherUser;
    protected Category $category;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::create([
            'nim' => '3337220001',
            'name' => 'Penjual FT Untirta',
            'email' => 'seller.ft@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'campus_zone' => 'Cilegon',
            'password' => bcrypt('password123'),
        ]);

        $this->buyer = User::create([
            'nim' => '3337220002',
            'name' => 'Pembeli FT Untirta',
            'email' => 'buyer.ft@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'campus_zone' => 'Cilegon',
            'password' => bcrypt('password123'),
        ]);

        $this->otherUser = User::create([
            'nim' => '1111220003',
            'name' => 'Mahasiswa FH',
            'email' => 'fh.user@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'campus_zone' => 'Pakupatan',
            'password' => bcrypt('password123'),
        ]);

        Wallet::firstOrCreate(['user_id' => $this->seller->id], ['balance' => 0.00, 'status' => 'active']);
        Wallet::firstOrCreate(['user_id' => $this->buyer->id], ['balance' => 200000.00, 'status' => 'active']);

        $this->category = Category::create([
            'name' => 'Alat Laboratorium',
            'slug' => 'alat-laboratorium',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'title' => 'Multimeter Digital Sanwa CD800a FT',
            'slug' => 'multimeter-digital-sanwa-cd800a-ft-' . time(),
            'description' => 'Multimeter presisi untuk praktikum dasar teknik elektro Untirta.',
            'price' => 120000.00,
            'condition' => 'like_new',
            'status' => 'available',
            'size_tier' => 'small',
            'campus_zone' => 'Cilegon',
            'pickup_location' => 'Gedung COE Lantai 2 FT Cilegon',
        ]);
    }

    /**
     * Test 1: Console Command ExpirePendingOrders membatalkan pesanan pending > 24 jam dan memulihkan stok
     */
    public function test_expire_pending_orders_command_cancels_old_orders_and_restores_product_status(): void
    {
        $this->product->update(['status' => 'reserved']);

        // Buat pesanan yang dibuat 25 jam yang lalu
        $order = Order::create([
            'order_number' => 'ORD-EXP-001',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 120000.00,
            'status' => 'pending',
            'payment_method' => 'qris',
            'payment_status' => 'unpaid',
            'delivery_method' => 'pickup',
            'shipping_fee' => 0.00,
            'meetup_location' => 'Kantin FT Untirta',
        ]);

        // Set created_at ke 25 jam yang lalu di database
        DB::table('orders')->where('id', $order->id)->update([
            'created_at' => now()->subHours(25),
            'updated_at' => now()->subHours(25),
        ]);

        // Eksekusi Console Command
        $exitCode = Artisan::call('orders:expire-pending');
        $this->assertEquals(0, $exitCode);

        // Verifikasi status pesanan dibatalkan
        $order->refresh();
        $this->assertEquals('cancelled', $order->status);
        $this->assertNotNull($order->cancelled_at);

        // Verifikasi status barang dipulihkan ke available
        $this->product->refresh();
        $this->assertEquals('available', $this->product->status);
    }

    /**
     * Test 2: Console Command ExpirePendingOrders membatalkan tawaran harga pending > 24 jam
     */
    public function test_expire_pending_orders_command_cancels_old_price_offers(): void
    {
        $offer = PriceOffer::create([
            'product_id' => $this->product->id,
            'buyer_id' => $this->buyer->id,
            'offered_price' => 100000.00,
            'message' => 'Boleh nego 100rb kak?',
            'status' => 'pending',
        ]);

        // Set created_at ke 26 jam yang lalu di database
        DB::table('price_offers')->where('id', $offer->id)->update([
            'created_at' => now()->subHours(26),
            'updated_at' => now()->subHours(26),
        ]);

        Artisan::call('orders:expire-pending');

        $offer->refresh();
        $this->assertEquals('cancelled', $offer->status);
    }


    /**
     * Test 3: Pembeli dapat memberikan rating dan ulasan pada pesanan yang sudah selesai
     */
    public function test_buyer_can_submit_rating_and_review_for_completed_order(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-REV-001',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 120000.00,
            'status' => 'completed',
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'delivery_method' => 'pickup',
            'shipping_fee' => 0.00,
            'meetup_location' => 'Gedung Jurusan Elektro FT',
            'completed_at' => now(),
        ]);

        Livewire::actingAs($this->buyer)
            ->test(Dashboard::class)
            ->call('openReviewModal', $order->id)
            ->assertSet('showReviewModal', true)
            ->assertSet('reviewOrderId', $order->id)
            ->set('reviewRating', 5)
            ->set('reviewComment', 'Barang sangat mulus dan bekerja 100%. Penjual sesama anak elektro sangat komunikatif!')
            ->call('submitReview')
            ->assertSet('showReviewModal', false);

        $this->assertDatabaseHas('reviews', [
            'order_id' => $order->id,
            'reviewer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'rating' => 5,
        ]);
    }

    /**
     * Test 4: Database View v_seller_statistics mengkalkulasi average_rating dan total_reviews
     */
    public function test_database_view_calculates_average_rating_and_total_reviews(): void
    {
        $order1 = Order::create([
            'order_number' => 'ORD-V-001',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 120000.00,
            'status' => 'completed',
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'delivery_method' => 'pickup',
            'completed_at' => now(),
        ]);

        $order2 = Order::create([
            'order_number' => 'ORD-V-002',
            'buyer_id' => $this->otherUser->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 120000.00,
            'status' => 'completed',
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'delivery_method' => 'pickup',
            'completed_at' => now(),
        ]);

        // Review 1: 5 bintang
        Review::create([
            'order_id' => $order1->id,
            'reviewer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'rating' => 5,
            'comment' => 'Mantap sekali',
        ]);

        // Review 2: 4 bintang
        Review::create([
            'order_id' => $order2->id,
            'reviewer_id' => $this->otherUser->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'rating' => 4,
            'comment' => 'Bagus dan cepat',
        ]);

        // Query ke Database View v_seller_statistics
        $stats = DB::table('v_seller_statistics')
            ->where('seller_id', $this->seller->id)
            ->first();

        $this->assertNotNull($stats);
        $this->assertEquals(2, $stats->total_reviews);
        // Rata-rata (5 + 4) / 2 = 4.5
        $this->assertEquals(4.5, (float) $stats->average_rating);
    }

    /**
     * Test 5: Invoice PDF dapat diakses pembeli dan penjual, serta dibatasi untuk orang lain (403)
     */
    public function test_invoice_access_authorization(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-INV-001',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->product->id,
            'total_amount' => 120000.00,
            'status' => 'completed',
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'delivery_method' => 'pickup',
            'shipping_fee' => 0.00,
            'meetup_location' => 'Perpustakaan Untirta Sindangsari',
            'completed_at' => now(),
        ]);

        // 1. Pembeli mengakses preview invoice -> 200 OK
        $responseBuyer = $this->actingAs($this->buyer)
            ->get(route('orders.invoice', ['order' => $order->id, 'preview' => 1]));
        $responseBuyer->assertStatus(200);
        $responseBuyer->assertSee($order->order_number);
        $responseBuyer->assertSee('INVOICE RESMI');

        // 2. Penjual mengakses preview invoice -> 200 OK
        $responseSeller = $this->actingAs($this->seller)
            ->get(route('orders.invoice', ['order' => $order->id, 'preview' => 1]));
        $responseSeller->assertStatus(200);

        // 3. User lain tanpa izin mengakses invoice -> 403 Forbidden
        $responseUnauthorized = $this->actingAs($this->otherUser)
            ->get(route('orders.invoice', ['order' => $order->id, 'preview' => 1]));
        $responseUnauthorized->assertStatus(403);
    }
}
