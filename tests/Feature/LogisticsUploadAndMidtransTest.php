<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Livewire\OrderCheckout;
use App\Livewire\ProductCreate;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class LogisticsUploadAndMidtransTest extends TestCase
{
    use RefreshDatabase;

    protected User $seller;
    protected User $sellerSindangsari;
    protected User $buyer;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::create([
            'nim' => '3337220050',
            'name' => 'Seller Cilegon',
            'email' => 'seller.ft@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'campus_zone' => 'Cilegon',
            'password' => bcrypt('password123'),
        ]);

        $this->sellerSindangsari = User::create([
            'nim' => '2221220055',
            'name' => 'Seller Sindangsari',
            'email' => 'seller.feb@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'campus_zone' => 'Sindangsari',
            'password' => bcrypt('password123'),
        ]);

        $this->buyer = User::create([
            'nim' => '6661220060',
            'name' => 'Buyer Sindangsari',
            'email' => 'buyer.fisip@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'campus_zone' => 'Sindangsari',
            'password' => bcrypt('password123'),
        ]);

        Wallet::where('user_id', $this->seller->id)->update(['balance' => 0.00]);
        Wallet::where('user_id', $this->sellerSindangsari->id)->update(['balance' => 0.00]);
        Wallet::where('user_id', $this->buyer->id)->update(['balance' => 500000.00]);

        $this->category = Category::create([
            'name' => 'Perlengkapan Kos',
            'slug' => 'perlengkapan-kos',
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_upload_product_with_size_tier(): void
    {
        Storage::fake('public');

        $this->actingAs($this->seller);

        // Gunakan fake()->create() agar tidak membutuhkan ekstensi PHP GD
        $fakeImage = UploadedFile::fake()->create('kulkas.jpg', 100, 'image/jpeg');

        Livewire::test(ProductCreate::class)
            ->set('title', 'Kulkas Mini Portable Kosan')
            ->set('description', 'Kulkas mini dingin normal hemat listrik cuma 60 watt.')
            ->set('price', '450000')
            ->set('condition_grade', 'Grade A (Mulus)')
            ->set('category_id', $this->category->id)
            ->set('size_tier', 'bulky')
            ->set('image', $fakeImage)
            ->set('pickup_location', 'Kosan Cilegon Dekat FT Untirta')
            ->call('saveProduct')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'seller_id' => $this->seller->id,
            'title' => 'Kulkas Mini Portable Kosan',
            'size_tier' => 'bulky',
            'campus_zone' => 'Cilegon', // Otomatis terikat zona penjual
            'price' => 450000.00,
        ]);
    }

    public function test_tiered_logistics_calculation_same_zone(): void
    {
        // Penjual di zona Sindangsari
        $product = Product::create([
            'seller_id' => $this->sellerSindangsari->id,
            'category_id' => $this->category->id,
            'title' => 'Buku Catatan Kuliah',
            'slug' => 'buku-catatan-kuliah',
            'description' => 'Buku catatan semester 3.',
            'price' => 20000.00,
            'size_tier' => 'small',
            'status' => 'available',
            'campus_zone' => 'Sindangsari',
        ]);

        $this->actingAs($this->buyer); // Pembeli juga di Sindangsari

        // Tier Small, Zona Sama (Sindangsari ke Sindangsari) = Rp 10.000 + Biaya Aplikasi 1.5% (Rp 300)
        Livewire::test(OrderCheckout::class, ['slug' => $product->slug])
            ->set('deliveryMethod', 'delivery')
            ->set('destinationZone', 'Sindangsari')
            ->assertSet('shippingFee', 10000.00)
            ->assertSet('buyerAppFee', 300.00)
            ->assertSet('totalAmount', 30300.00); // 20.000 + 10.000 + 300
    }

    public function test_tiered_logistics_calculation_different_zone_bulky(): void
    {
        // Barang Bulky di Cilegon
        $productBulky = Product::create([
            'seller_id' => $this->seller->id, // Seller di Cilegon
            'category_id' => $this->category->id,
            'title' => 'Sepeda Lipat Kampus',
            'slug' => 'sepeda-lipat-kampus',
            'description' => 'Sepeda lipat siap pakai.',
            'price' => 1000000.00,
            'size_tier' => 'bulky',
            'status' => 'available',
            'campus_zone' => 'Cilegon',
        ]);

        $this->actingAs($this->buyer); // Pembeli di Sindangsari

        // Beda Zona (Cilegon ke Sindangsari) Tier Bulky = Rp 85.000 + Biaya Aplikasi 1.5% (Rp 15.000)
        Livewire::test(OrderCheckout::class, ['slug' => $productBulky->slug])
            ->set('deliveryMethod', 'delivery')
            ->set('destinationZone', 'Sindangsari')
            ->assertSet('shippingFee', 85000.00)
            ->assertSet('buyerAppFee', 15000.00)
            ->assertSet('totalAmount', 1100000.00); // 1.000.000 + 85.000 + 15.000
    }

    public function test_midtrans_webhook_callback_verifies_order_payment(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-20261025-MIDTRANS1',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => Product::create([
                'seller_id' => $this->seller->id,
                'category_id' => $this->category->id,
                'title' => 'Modul Praktikum',
                'slug' => 'modul-praktikum',
                'description' => 'Modul lengkap.',
                'price' => 50000.00,
                'status' => 'available',
                'campus_zone' => 'Cilegon',
            ])->id,
            'total_amount' => 50000.00,
            'status' => 'pending',
            'payment_method' => 'midtrans',
            'payment_status' => 'unpaid',
        ]);

        // Simulasikan request webhook dari Midtrans
        $response = $this->postJson('/api/midtrans/callback', [
            'order_id' => 'ORD-20261025-MIDTRANS1',
            'transaction_status' => 'settlement',
            'gross_amount' => '50000.00',
        ]);

        $response->assertStatus(200);

        // Status pesanan otomatis menjadi 'processing' dan payment_status 'paid'
        $this->assertEquals('paid', $order->fresh()->payment_status);
        $this->assertEquals('processing', $order->fresh()->status);
    }

    public function test_midtrans_webhook_callback_tops_up_wallet(): void
    {
        $wallet = Wallet::where('user_id', $this->buyer->id)->first();
        $initialBalance = (float) $wallet->balance;

        $topupRef = 'TOPUP-' . $this->buyer->id . '-123456';

        $response = $this->postJson('/api/midtrans/callback', [
            'order_id' => $topupRef,
            'transaction_status' => 'settlement',
            'gross_amount' => '100000.00',
        ]);

        $response->assertStatus(200);

        // Saldo bertambah 100.000
        $this->assertEquals($initialBalance + 100000.00, (float) $wallet->fresh()->balance);

        $this->assertDatabaseHas('wallet_mutations', [
            'wallet_id' => $wallet->id,
            'type' => 'credit',
            'amount' => 100000.00,
            'reference_type' => 'midtrans_topup',
        ]);
    }

    public function test_seller_can_input_tracking_number_or_pickup_plate(): void
    {
        $product = Product::create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'title' => 'Meja Belajar Kayu',
            'slug' => 'meja-belajar-kayu',
            'description' => 'Meja belajar kokoh.',
            'price' => 150000.00,
            'size_tier' => 'bulky',
            'status' => 'reserved',
            'campus_zone' => 'Cilegon',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-20261025-SHIP1',
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $product->id,
            'total_amount' => 150000.00,
            'status' => 'processing',
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'delivery_method' => 'delivery',
            'destination_zone' => 'Sindangsari',
        ]);

        $this->actingAs($this->seller);

        // Penjual memasukkan plat nomor mobil pick-up untuk barang bulky
        Livewire::test(Dashboard::class)
            ->set('activeTab', 'sales')
            ->set("inputTrackingNumber.{$order->id}", 'A 8912 BC (Pick-up Carry Hitam)')
            ->call('shipOrder', $order->id)
            ->assertHasNoErrors();

        // Status pesanan menjadi shipped dan tracking_number tersimpan
        $this->assertEquals('shipped', $order->fresh()->status);
        $this->assertEquals('A 8912 BC (Pick-up Carry Hitam)', $order->fresh()->tracking_number);
    }
}
