<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Chat;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class NewFeaturesChatAndForgotPasswordTest extends TestCase
{
    use DatabaseTransactions;

    public function test_student_can_open_chat_and_send_message(): void
    {
        $buyer = User::where('role', 'student')->first() ?? User::factory()->create(['role' => 'student']);
        $seller = User::where('role', 'student')->where('id', '!=', $buyer->id)->first() ?? User::factory()->create(['role' => 'student']);

        $product = Product::first();

        // 1. Inisiasi obrolan
        $conv = Conversation::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'product_id' => $product?->id,
            'last_message_at' => now(),
            'status' => 'active',
        ]);

        // 2. Kirim pesan via Livewire Chat
        Livewire::actingAs($buyer)
            ->test(Chat::class, ['activeConversationId' => $conv->id])
            ->set('newMessage', 'Halo kak, barang masih ada?')
            ->call('sendMessage')
            ->assertHasNoErrors()
            ->assertSet('newMessage', '');

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conv->id,
            'sender_id' => $buyer->id,
            'message' => 'Halo kak, barang masih ada?',
        ]);
    }

    public function test_forgot_password_generates_token(): void
    {
        $user = User::first() ?? User::factory()->create(['nim' => '3337240099']);

        Livewire::test(ForgotPassword::class)
            ->set('login', $user->nim ?? $user->email)
            ->set('personalEmail', 'personal.student@gmail.com')
            ->call('sendResetLink')
            ->assertHasNoErrors()
            ->assertSet('emailSent', true)
            ->assertSet('sentEmail', 'personal.student@gmail.com');

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_reset_password_updates_user_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test_reset_' . uniqid() . '@untirta.ac.id',
            'password' => Hash::make('old_password'),
        ]);

        $token = 'test_token_' . uniqid();
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Livewire::test(ResetPassword::class, ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'new_password123')
            ->set('password_confirmation', 'new_password123')
            ->call('resetPassword')
            ->assertHasNoErrors()
            ->assertRedirect(route('login'));

        $user->refresh();
        $this->assertTrue(Hash::check('new_password123', $user->password));
    }

    public function test_admin_can_inspect_chat_transcript(): void
    {
        $admin = User::where('role', 'super_admin')->first() ?? User::factory()->create(['role' => 'super_admin']);
        $buyer = User::factory()->create(['role' => 'student']);
        $seller = User::factory()->create(['role' => 'student']);

        $conv = Conversation::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'last_message_at' => now(),
            'status' => 'active',
        ]);

        ChatMessage::create([
            'conversation_id' => $conv->id,
            'sender_id' => $buyer->id,
            'message' => 'Pesan pengawasan admin',
            'is_read' => false,
        ]);

        Livewire::actingAs($admin)
            ->test(Dashboard::class)
            ->set('activeTab', 'chats')
            ->call('openInspectChat', $conv->id)
            ->assertSet('inspectConversationId', $conv->id)
            ->assertSee('Transkrip Audit Percakapan')
            ->assertSee('Pesan pengawasan admin');
    }
}
