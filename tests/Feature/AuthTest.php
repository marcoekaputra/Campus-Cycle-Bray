<?php

namespace Tests\Feature;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\User;
use App\Services\PddiktiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_pddikti_service_validates_untirta_api_response(): void
    {
        $service = new PddiktiService();
        $result = $service->validateNim('3337220001');

        $this->assertTrue($result['valid']);
        $this->assertEquals('untirta_verified', $result['source']);
        $this->assertEquals('Universitas Sultan Ageng Tirtayasa', $result['university']);
    }

    public function test_pddikti_service_rejects_non_untirta_api_response(): void
    {
        $service = new PddiktiService();
        $result = $service->validateNim('1234567890');

        $this->assertFalse($result['valid']);
        $this->assertEquals('untirta_invalid', $result['source']);
    }

    public function test_pddikti_service_fallback_regex_on_api_timeout(): void
    {
        $service = new PddiktiService();

        // Tes NIM awalan 333 (Teknik Untirta)
        $result333 = $service->validateNim('3337220001');
        $this->assertTrue($result333['valid']);
        $this->assertEquals('untirta_verified', $result333['source']);

        // Tes NIM awalan 666 (FISIP Untirta)
        $result666 = $service->validateNim('6661220002');
        $this->assertTrue($result666['valid']);
        $this->assertEquals('untirta_verified', $result666['source']);

        // Tes NIM sembarang yang tidak sesuai format Untirta
        $invalid = $service->validateNim('9991234567');
        $this->assertFalse($invalid['valid']);
    }

    public function test_register_page_renders_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('NIM Mahasiswa');
        $response->assertSee('Universitas Sultan Ageng Tirtayasa');
    }

    public function test_livewire_register_realtime_nim_validation_hook(): void
    {
        Livewire::test(Register::class)
            ->set('nim', '3337220001')
            ->assertSet('isNimValid', true)
            ->assertSet('nimSource', 'untirta_verified');
    }

    public function test_user_can_register_and_redirects_to_dashboard(): void
    {
        Http::fake([
            'api-frontend.kemdikbud.go.id/*' => Http::response([], 500),
        ]);

        Livewire::test(Register::class)
            ->set('nim', '3337220001')
            ->set('name', 'Budi Santoso')
            ->set('email', 'budi@untirta.ac.id')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasNoErrors()
            ->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'nim' => '3337220001',
            'email' => 'budi@untirta.ac.id',
            'name' => 'Budi Santoso',
        ]);

        $this->assertAuthenticated();
    }

    public function test_user_can_login_with_nim(): void
    {
        User::create([
            'nim' => '3337220005',
            'name' => 'Siti Aminah',
            'email' => 'siti@untirta.ac.id',
            'password' => bcrypt('secret123'),
        ]);

        Livewire::test(Login::class)
            ->set('login', '3337220005')
            ->set('password', 'secret123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }

    public function test_dashboard_requires_authentication(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');

        $user = User::create([
            'nim' => '3337220009',
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@untirta.ac.id',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Ahmad Dahlan')
            ->assertSee('3337220009');
    }

    public function test_register_and_login_with_nim_ending_in_29_post_route(): void
    {
        $response = $this->post('/register', [
            'nim' => '3337240029',
            'name' => 'Teman Informatika 29',
            'email' => 'teman29@gmail.com',
            'password' => 'untirta2024',
            'password_confirmation' => 'untirta2024',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'nim' => '3337240029',
            'email' => 'teman29@gmail.com',
            'name' => 'Teman Informatika 29',
            'campus_zone' => 'Cilegon',
        ]);

        $this->assertAuthenticated();

        // Logout then test login with NIM
        auth()->logout();
        $this->assertGuest();

        $loginResponse = $this->post('/login', [
            'login' => '3337240029',
            'password' => 'untirta2024',
        ]);

        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }
}
