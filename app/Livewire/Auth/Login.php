<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Masuk - CampusCycle Untirta')]
class Login extends Component
{
    public string $login = ''; // Mendukung login via Email atau NIM
    public string $password = '';
    public bool $remember = false;

    /**
     * Proses autentikasi login (dipanggil oleh form wire:submit="authenticate")
     */
    public function authenticate(): void
    {
        $this->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'NIM atau Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Deteksi apakah kredensial berupa email atau NIM
        $cleanLogin = trim($this->login);
        $isEmail = filter_var($cleanLogin, FILTER_VALIDATE_EMAIL);
        $credentials = [
            $isEmail ? 'email' : 'nim' => $cleanLogin,
            'password' => $this->password,
        ];

        if (!Auth::attempt($credentials, $this->remember)) {
            throw ValidationException::withMessages([
                'login' => 'Kombinasi akun (NIM/Email dan Kata Sandi) tidak sesuai.',
            ]);
        }

        session()->regenerate();
        session()->flash('status', 'Berhasil masuk ke akun Anda.');

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            $this->redirect('/admin', navigate: false);
            return;
        }

        // Jika bukan admin, pastikan tidak diarahkan ke intended URL /admin
        $intended = session()->get('url.intended');
        if ($intended && str_contains($intended, '/admin')) {
            session()->forget('url.intended');
        }

        $this->redirectIntended(default: '/dashboard', navigate: false);
    }

    /**
     * Alias method untuk kompatibilitas pengujian otomatis
     */
    public function login(): void
    {
        $this->authenticate();
    }

    public function fillDemo(string $type): void
    {
        if ($type === 'admin') {
            $this->login = 'admin@campuscycle.id';
            $this->password = 'admin123';
        } elseif ($type === 'admin_untirta') {
            $this->login = 'admin@untirta.ac.id';
            $this->password = 'admin123';
        } elseif ($type === 'student') {
            $this->login = '3337240067';
            $this->password = 'password123';
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
