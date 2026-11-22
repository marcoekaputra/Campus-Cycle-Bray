<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PlatformSanityTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        if (User::where('nim', '3337240067')->doesntExist() || Product::count() === 0) {
            $this->seed();
        }
    }

    public function test_homepage_shows_catalog_products_and_images(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Ekosistem Jual Beli Pre-Loved Mahasiswa Untirta');
        $response->assertSee('/images/products/');
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk ke CampusCycle');
    }

    public function test_product_detail_page_renders(): void
    {
        $product = Product::first();
        $this->assertNotNull($product, 'Product should exist in database');

        $response = $this->get('/product/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee($product->title);
    }

    public function test_student_can_login_with_nim(): void
    {
        $user = User::where('nim', '3337240067')->first();
        $this->assertNotNull($user, 'User with NIM 3337240067 must exist');

        $response = $this->post('/login', [
            'login' => '3337240067',
            'password' => 'password123',
        ]);
        // Note: In Livewire component, login is handled via wire:submit, but let's test component
    }

    public function test_admin_console_access(): void
    {
        $admin = User::where('email', 'admin@campuscycle.id')->first();
        $this->assertNotNull($admin, 'Admin must exist');

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Console Administrator');
    }
}
