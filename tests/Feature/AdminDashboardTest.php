<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard;
use App\Models\Category;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_guest_is_redirected_from_admin_console(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_student_cannot_access_admin_console(): void
    {
        $student = User::where('role', 'student')->first() ?? User::factory()->create([
            'role' => 'student',
        ]);

        $response = $this->actingAs($student)->get('/admin');
        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }

    public function test_super_admin_can_access_admin_console(): void
    {
        $admin = User::where('role', 'super_admin')->first() ?? User::factory()->create([
            'role' => 'super_admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Admin Console');
        $response->assertSee('Ringkasan Platform');
    }

    public function test_admin_can_takedown_and_restore_product(): void
    {
        $admin = User::where('role', 'super_admin')->first() ?? User::factory()->create(['role' => 'super_admin']);
        $seller = User::where('role', 'student')->first() ?? User::factory()->create(['role' => 'student']);
        $category = Category::first() ?? Category::create(['name' => 'Buku', 'slug' => 'buku-' . uniqid()]);

        $product = Product::create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'title' => 'Buku Kalkulus Melanggar',
            'slug' => 'buku-kalkulus-melanggar-' . uniqid(),
            'description' => 'Buku bajakan ilegal',
            'price' => 50000,
            'status' => 'available',
        ]);

        Livewire::actingAs($admin)
            ->test(Dashboard::class)
            ->call('openTakedownModal', $product->id)
            ->set('takedownReason', 'Barang bajakan')
            ->call('takedownProduct');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_flagged' => true,
            'status' => 'archived',
            'takedown_reason' => 'Barang bajakan',
        ]);

        Livewire::actingAs($admin)
            ->test(Dashboard::class)
            ->call('restoreProduct', $product->id);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_flagged' => false,
            'status' => 'available',
        ]);
    }

    public function test_admin_can_toggle_user_suspension(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $student = User::factory()->create(['role' => 'student', 'is_suspended' => false]);

        Livewire::actingAs($admin)
            ->test(Dashboard::class)
            ->call('toggleSuspendUser', $student->id);

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'is_suspended' => true,
        ]);
    }

    public function test_admin_can_approve_withdrawal(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $student = User::factory()->create(['role' => 'student']);
        $wallet = Wallet::where('user_id', $student->id)->first();
        if ($wallet) {
            $wallet->update(['balance' => 200000]);
        }

        $withdrawal = Withdrawal::create([
            'user_id' => $student->id,
            'amount' => 100000,
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => $student->name,
            'status' => 'pending',
        ]);

        Livewire::actingAs($admin)
            ->test(Dashboard::class)
            ->call('approveWithdrawal', $withdrawal->id);

        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_monitor_student_chats(): void
    {
        $admin = User::where('role', 'super_admin')->first() ?? User::factory()->create(['role' => 'super_admin']);
        $buyer = User::factory()->create(['role' => 'student']);
        $seller = User::factory()->create(['role' => 'student']);

        $conv = \App\Models\Conversation::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'last_message_at' => now(),
            'status' => 'active',
        ]);

        \App\Models\ChatMessage::create([
            'conversation_id' => $conv->id,
            'sender_id' => $buyer->id,
            'message' => 'Halo apakah barang ini masih ada?',
            'is_read' => false,
        ]);

        Livewire::actingAs($admin)
            ->test(Dashboard::class)
            ->set('activeTab', 'chats')
            ->assertSee('Pusat Pengawasan')
            ->assertSee('Inspeksi Chat');
    }
}
