<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Dashboard;
use App\Livewire\OrderCheckout;
use App\Models\Category;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class PaymentVaAndReturnFlowTest extends TestCase
{
    use DatabaseTransactions;

    protected User $buyer;
    protected User $seller;
    protected User $admin;
    protected Category $category;
    protected Product $productDelivery;
    protected Product $productCod;
    protected Wallet $buyerWallet;
    protected Wallet $sellerWallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->create([
            'name' => 'Penjual Untirta',
            'email' => 'seller_' . uniqid() . '@untirta.ac.id',
            'nim' => '333722' . rand(1000, 9999),
            'campus_zone' => 'Cilegon',
            'role' => 'student',
        ]);

        $this->buyer = User::factory()->create([
            'name' => 'Pembeli Untirta',
            'email' => 'buyer_' . uniqid() . '@untirta.ac.id',
            'nim' => '666122' . rand(1000, 9999),
            'campus_zone' => 'Sindangsari',
            'role' => 'student',
        ]);

        $this->admin = User::factory()->create([
            'name' => 'Super Administrator',
            'email' => 'admin_' . uniqid() . '@campuscycle.id',
            'role' => 'super_admin',
        ]);

        $this->buyerWallet = Wallet::where('user_id', $this->buyer->id)->first() ?? Wallet::create(['user_id' => $this->buyer->id, 'balance' => 0.00, 'status' => 'active']);
        $this->buyerWallet->update(['balance' => 250000.00]);

        $this->sellerWallet = Wallet::where('user_id', $this->seller->id)->first() ?? Wallet::create(['user_id' => $this->seller->id, 'balance' => 0.00, 'status' => 'active']);
        $this->sellerWallet->update(['balance' => 0.00]);

        $this->category = Category::first() ?? Category::create([
            'name' => 'Peralatan Praktikum',
            'slug' => 'peralatan-praktikum-' . uniqid(),
            'icon' => 'wrench',
        ]);

        $this->productDelivery = Product::create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'title' => 'Helm K3 Proyek FT Untirta',
            'slug' => 'helm-k3-proyek-' . uniqid(),
            'description' => 'Helm proyek teknik standar SNI.',
            'price' => 100000.00,
            'condition' => 'good',
            'status' => 'available',
            'campus_zone' => 'Cilegon',
            'size_tier' => 'small',
        ]);

        $this->productCod = Product::create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'title' => 'Diktat Kalkulus Lanjut',
            'slug' => 'diktat-kalkulus-' . uniqid(),
            'description' => 'Diktat lengkap catatan kuliah.',
            'price' => 50000.00,
            'condition' => 'good',
            'status' => 'available',
            'campus_zone' => 'Cilegon',
            'size_tier' => 'small',
        ]);
    }

    public function test_checkout_rejects_cash_and_only_accepts_cashless(): void
    {
        $this->actingAs($this->buyer);

        Livewire::test(OrderCheckout::class, ['slug' => $this->productDelivery->slug])
            ->set('paymentMethod', 'cash_on_delivery')
            ->call('processCheckout')
            ->assertHasErrors(['paymentMethod']);
    }

    public function test_checkout_calculates_application_fees_properly(): void
    {
        $this->actingAs($this->buyer);

        // Harga 100.000, JNT beda zona tier small = 15.000, App fee pembeli 1.5% = 1.500
        Livewire::test(OrderCheckout::class, ['slug' => $this->productDelivery->slug])
            ->set('deliveryMethod', 'delivery')
            ->set('selectedCourier', 'jnt')
            ->set('destinationZone', 'Sindangsari')
            ->assertSet('itemPrice', 100000.00)
            ->assertSet('shippingFee', 15000.00)
            ->assertSet('buyerAppFee', 1500.00)
            ->assertSet('sellerAppFee', 1500.00)
            ->assertSet('totalAmount', 116500.00); // 100.000 + 15.000 + 1.500
    }

    public function test_buyer_can_checkout_with_virtual_account(): void
    {
        $this->actingAs($this->buyer);

        $component = Livewire::test(OrderCheckout::class, ['slug' => $this->productDelivery->slug])
            ->set('deliveryMethod', 'delivery')
            ->set('selectedCourier', 'jnt')
            ->set('destinationZone', 'Sindangsari')
            ->set('destinationAddress', 'Kosan Barokah Cilegon')
            ->set('paymentMethod', 'va_bca')
            ->call('processCheckout')
            ->assertHasNoErrors()
            ->assertSet('showVaModal', true);

        $order = Order::where('buyer_id', $this->buyer->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('va_bca', $order->payment_method);
        $this->assertEquals('bca', $order->va_bank);
        $this->assertStringStartsWith('80777', $order->va_number);
        $this->assertEquals('unpaid', $order->payment_status);
        $this->assertEquals('pending', $order->status);
        $this->assertEquals(1500.00, (float) $order->buyer_app_fee);
        $this->assertEquals(1500.00, (float) $order->seller_app_fee);

        // Simulasi pelunasan VA
        $component->call('simulateVaPayment', $order->order_number);
        $this->assertEquals('paid', $order->fresh()->payment_status);
        $this->assertEquals('processing', $order->fresh()->status);
    }

    public function test_buyer_and_seller_can_access_purchase_invoice(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-INV-' . uniqid(),
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->productDelivery->id,
            'total_amount' => 116500.00,
            'shipping_fee' => 15000.00,
            'buyer_app_fee' => 1500.00,
            'seller_app_fee' => 1500.00,
            'net_seller_amount' => 113500.00,
            'status' => 'processing',
            'payment_method' => 'va_bca',
            'payment_status' => 'paid',
            'delivery_method' => 'delivery',
            'destination_zone' => 'Sindangsari',
            'destination_address' => 'Kosan Barokah',
            'paid_at' => now(),
        ]);

        // Pembeli melihat faktur
        $this->actingAs($this->buyer)
            ->get('/order/' . $order->order_number . '/invoice')
            ->assertStatus(200)
            ->assertSee($order->order_number)
            ->assertSee('Biaya Layanan Aplikasi (1.5%)');

        // Penjual melihat faktur
        $this->actingAs($this->seller)
            ->get('/order/' . $order->order_number . '/invoice')
            ->assertStatus(200)
            ->assertSee($order->order_number);
    }

    public function test_buyer_can_submit_return_complaint_seller_confirms_and_admin_approves_refund(): void
    {
        // 1. Pesanan non-COD berstatus shipped
        $order = Order::create([
            'order_number' => 'ORD-RET-' . uniqid(),
            'buyer_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
            'product_id' => $this->productDelivery->id,
            'total_amount' => 116500.00,
            'shipping_fee' => 15000.00,
            'buyer_app_fee' => 1500.00,
            'seller_app_fee' => 1500.00,
            'net_seller_amount' => 113500.00,
            'status' => 'shipped',
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'delivery_method' => 'delivery',
            'destination_zone' => 'Sindangsari',
            'destination_address' => 'Gedung FT',
            'tracking_number' => 'JNT-12345',
            'return_status' => 'none',
            'paid_at' => now(),
        ]);

        $this->actingAs($this->buyer);

        // 2. Pembeli mengajukan return via kurir delivery
        Livewire::test(Dashboard::class)
            ->call('openReturnModal', $order->id)
            ->assertSet('showReturnModal', true)
            ->set('returnReason', 'Barang Rusak / Cacat Pengiriman')
            ->set('returnDeliveryMethod', 'delivery')
            ->set('returnCourier', 'jnt')
            ->set('returnDescription', 'Kait pengunci helm patah saat diterima di kosan.')
            ->call('submitReturnRequest')
            ->assertHasNoErrors()
            ->assertSet('showReturnModal', false);

        $order->refresh();
        $this->assertEquals('return_requested', $order->status);
        $this->assertEquals('requested', $order->return_status);
        $this->assertEquals('delivery', $order->return_method);
        $this->assertStringStartsWith('RET-JNT', $order->return_tracking_number);

        $this->assertDatabaseHas('disputes', [
            'order_id' => $order->id,
            'complainant_id' => $this->buyer->id,
            'status' => 'open',
        ]);

        // 3. Penjual mengonfirmasi bahwa barang return telah diterima
        $this->actingAs($this->seller);
        Livewire::test(Dashboard::class)
            ->call('confirmReturnReceivedBySeller', $order->id)
            ->assertHasNoErrors();

        $order->refresh();
        $this->assertEquals('approved_by_seller', $order->return_status);

        // 4. Admin melakukan crosscheck dan menyetujui refund (potong app fee 1.5%)
        $initialBuyerBalance = (float) $this->buyerWallet->fresh()->balance;

        $this->actingAs($this->admin);
        Livewire::test(AdminDashboard::class)
            ->call('approveReturnRefund', $order->id)
            ->assertHasNoErrors();

        $order->refresh();
        $this->assertEquals('returned', $order->status);
        $this->assertEquals('completed', $order->return_status);

        // Harga barang 100.000 dikurangi fee aplikasi 1.5% (1.500) = 98.500
        $expectedRefund = 98500.00;
        $this->assertEquals($expectedRefund, (float) $order->return_refund_amount);

        // Saldo pembeli bertambah sebesar refund
        $this->assertEquals($initialBuyerBalance + $expectedRefund, (float) $this->buyerWallet->fresh()->balance);

        // Mutasi kredit refund tercatat
        $this->assertDatabaseHas('wallet_mutations', [
            'wallet_id' => $this->buyerWallet->id,
            'order_id' => $order->id,
            'type' => 'credit',
            'amount' => $expectedRefund,
            'reference_type' => 'order_return_refund',
        ]);

        // Produk kembali berstatus available
        $this->assertEquals('available', $this->productDelivery->fresh()->status);
    }
}
