<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Livewire\ProductCatalog;
use App\Livewire\ProductDetail;
use App\Models\Category;
use App\Models\PriceOffer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CatalogAndNegotiationTest extends TestCase
{
    use RefreshDatabase;

    protected User $seller;
    protected User $buyer1;
    protected User $buyer2;
    protected Category $categoryBuku;
    protected Category $categoryElektronik;
    protected Product $productKalkulus;
    protected Product $productMonitor;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat User Seller dan Pembeli
        $this->seller = User::create([
            'nim' => '3337220001',
            'name' => 'Aditya Seller',
            'email' => 'aditya@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'password' => bcrypt('password123'),
        ]);

        $this->buyer1 = User::create([
            'nim' => '6661220002',
            'name' => 'Budi Pembeli 1',
            'email' => 'budi1@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'password' => bcrypt('password123'),
        ]);

        $this->buyer2 = User::create([
            'nim' => '2281220003',
            'name' => 'Citra Pembeli 2',
            'email' => 'citra2@untirta.ac.id',
            'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            'password' => bcrypt('password123'),
        ]);

        // 2. Buat Kategori
        $this->categoryBuku = Category::create([
            'name' => 'Buku & Diktat Kuliah',
            'slug' => 'buku-diktat-kuliah',
            'is_active' => true,
        ]);

        $this->categoryElektronik = Category::create([
            'name' => 'Elektronik & Gadget',
            'slug' => 'elektronik-gadget',
            'is_active' => true,
        ]);

        // 3. Buat Produk
        $this->productKalkulus = Product::create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->categoryBuku->id,
            'title' => 'Buku Kalkulus Purcel Edisi 9',
            'slug' => 'buku-kalkulus-purcel-edisi-9',
            'description' => 'Buku kalkulus lengkap tanpa coretan.',
            'price' => 70000.00,
            'is_negotiable' => true,
            'condition' => 'like_new',
            'condition_grade' => 'Grade A (Mulus)',
            'status' => 'available',
            'campus_zone' => 'Cilegon',
            'pickup_location' => 'FT Cilegon',
        ]);

        $this->productMonitor = Product::create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->categoryElektronik->id,
            'title' => 'Monitor LED LG 22 Inch IPS',
            'slug' => 'monitor-led-lg-22-inch-ips',
            'description' => 'Monitor kerja normal mulus.',
            'price' => 800000.00,
            'is_negotiable' => true,
            'condition' => 'good',
            'condition_grade' => 'Grade B+',
            'status' => 'available',
            'campus_zone' => 'Sindangsari',
            'pickup_location' => 'Rektorat Sindangsari',
        ]);
    }

    public function test_catalog_page_renders_and_displays_products(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Buku Kalkulus Purcel Edisi 9')
            ->assertSee('Monitor LED LG 22 Inch IPS')
            ->assertSee('Cilegon')
            ->assertSee('Sindangsari');
    }

    public function test_catalog_filters_by_campus_zone(): void
    {
        Livewire::test(ProductCatalog::class)
            ->set('selectedZone', 'Cilegon')
            ->assertSee('Buku Kalkulus Purcel Edisi 9')
            ->assertDontSee('Monitor LED LG 22 Inch IPS');

        Livewire::test(ProductCatalog::class)
            ->set('selectedZone', 'Sindangsari')
            ->assertSee('Monitor LED LG 22 Inch IPS')
            ->assertDontSee('Buku Kalkulus Purcel Edisi 9');
    }

    public function test_catalog_filters_by_category(): void
    {
        Livewire::test(ProductCatalog::class)
            ->set('selectedCategory', $this->categoryBuku->id)
            ->assertSee('Buku Kalkulus Purcel Edisi 9')
            ->assertDontSee('Monitor LED LG 22 Inch IPS');
    }

    public function test_catalog_searches_by_keyword(): void
    {
        Livewire::test(ProductCatalog::class)
            ->set('search', 'Kalkulus')
            ->assertSee('Buku Kalkulus Purcel Edisi 9')
            ->assertDontSee('Monitor LED LG 22 Inch IPS');
    }

    public function test_product_detail_page_renders(): void
    {
        $this->get('/product/' . $this->productKalkulus->slug)
            ->assertStatus(200)
            ->assertSee('Buku Kalkulus Purcel Edisi 9')
            ->assertSee('Rp 70.000')
            ->assertSee('Grade A (Mulus)');
    }

    public function test_guest_sees_login_prompt_on_detail_page(): void
    {
        $this->get('/product/' . $this->productKalkulus->slug)
            ->assertSee('Login untuk Membeli atau Menawar');
    }

    public function test_authenticated_buyer_can_submit_price_offer(): void
    {
        $this->actingAs($this->buyer1);

        Livewire::test(ProductDetail::class, ['slug' => $this->productKalkulus->slug])
            ->assertSee('Tawar Harga (Nego)')
            ->call('openOfferModal')
            ->assertSet('showOfferModal', true)
            ->set('offeredPrice', '55000')
            ->set('offerMessage', 'Bisa COD hari Selasa di Kantin Cilegon?')
            ->call('submitOffer')
            ->assertHasNoErrors()
            ->assertSet('showOfferModal', false);

        $this->assertDatabaseHas('price_offers', [
            'product_id' => $this->productKalkulus->id,
            'buyer_id' => $this->buyer1->id,
            'offered_price' => 55000.00,
            'status' => 'pending',
            'message' => 'Bisa COD hari Selasa di Kantin Cilegon?',
        ]);
    }

    public function test_seller_cannot_submit_offer_on_own_product(): void
    {
        $this->actingAs($this->seller);

        Livewire::test(ProductDetail::class, ['slug' => $this->productKalkulus->slug])
            ->assertSee('Ini adalah produk Anda')
            ->assertDontSee('Tawar Harga (Nego)')
            ->set('offeredPrice', '50000')
            ->call('submitOffer')
            ->assertHasErrors(['offeredPrice']);
    }

    public function test_seller_dashboard_displays_received_offers(): void
    {
        // Buyer 1 buat tawaran
        PriceOffer::create([
            'product_id' => $this->productKalkulus->id,
            'buyer_id' => $this->buyer1->id,
            'offered_price' => 50000.00,
            'message' => 'Nego 50rb kak',
            'status' => 'pending',
        ]);

        $this->actingAs($this->seller);

        Livewire::test(Dashboard::class)
            ->assertSee('Budi Pembeli 1')
            ->assertSee('Rp 50.000')
            ->assertSee('Terima')
            ->assertSee('Tolak');
    }

    public function test_accepting_an_offer_rejects_other_offers_for_the_same_product(): void
    {
        // 2 Tawaran masuk untuk buku kalkulus
        $offer1 = PriceOffer::create([
            'product_id' => $this->productKalkulus->id,
            'buyer_id' => $this->buyer1->id,
            'offered_price' => 60000.00,
            'status' => 'pending',
        ]);

        $offer2 = PriceOffer::create([
            'product_id' => $this->productKalkulus->id,
            'buyer_id' => $this->buyer2->id,
            'offered_price' => 55000.00,
            'status' => 'pending',
        ]);

        $this->actingAs($this->seller);

        // Penjual menerima tawaran pertama ($offer1)
        Livewire::test(Dashboard::class)
            ->call('acceptOffer', $offer1->id)
            ->assertHasNoErrors();

        // Verifikasi: Tawaran 1 menjadi accepted
        $this->assertEquals('accepted', $offer1->fresh()->status);

        // Verifikasi penting sesuai PRD: Tawaran 2 otomatis menjadi rejected karena produk pre-loved hanya 1 unit
        $this->assertEquals('rejected', $offer2->fresh()->status);

        // Status produk berubah menjadi reserved
        $this->assertEquals('reserved', $this->productKalkulus->fresh()->status);
    }

    public function test_seller_can_reject_an_offer(): void
    {
        $offer = PriceOffer::create([
            'product_id' => $this->productKalkulus->id,
            'buyer_id' => $this->buyer1->id,
            'offered_price' => 30000.00,
            'status' => 'pending',
        ]);

        $this->actingAs($this->seller);

        Livewire::test(Dashboard::class)
            ->call('rejectOffer', $offer->id)
            ->assertHasNoErrors();

        $this->assertEquals('rejected', $offer->fresh()->status);
    }
}
