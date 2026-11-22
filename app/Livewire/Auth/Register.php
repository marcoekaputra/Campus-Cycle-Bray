<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\PddiktiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Daftar Akun Mahasiswa - CampusCycle Untirta')]
class Register extends Component
{
    public string $nim = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Status validasi NIM realtime saat user mengetik
    public bool $isValidatingNim = false;
    public ?bool $isNimValid = null;
    public ?string $nimMessage = null;
    public ?string $nimSource = null;

    /**
     * Hook Livewire: Dipanggil secara real-time saat user mengetik pada input NIM
     */
    public function updatedNim(string $value, PddiktiService $pddiktiService): void
    {
        $value = trim($value);

        if (empty($value)) {
            $this->resetNimStatus();
            return;
        }

        if (strlen($value) === 10) {
            $this->isValidatingNim = true;
            $result = $pddiktiService->validateNim($value);

            $this->isNimValid = $result['valid'];
            $this->nimMessage = $result['message'];
            $this->nimSource = $result['source'];

            if ($result['valid'] && !empty($result['student_name']) && empty($this->name)) {
                $this->name = ucwords(strtolower($result['student_name']));
            }

            $this->isValidatingNim = false;
        } elseif (strlen($value) < 10) {
            $this->isNimValid = null;
            $this->nimMessage = 'Ketik ' . (10 - strlen($value)) . ' digit lagi untuk verifikasi format NIM Untirta.';
            $this->nimSource = 'format_hint';
            $this->isValidatingNim = false;
        } else {
            $this->isNimValid = false;
            $this->nimMessage = 'Format NIM resmi Untirta terdiri dari tepat 10 digit.';
            $this->nimSource = 'format_error';
            $this->isValidatingNim = false;
        }
    }

    public function resetNimStatus(): void
    {
        $this->isNimValid = null;
        $this->nimMessage = null;
        $this->nimSource = null;
        $this->isValidatingNim = false;
    }

    /**
     * Proses pendaftaran akun pengguna baru
     */
    public function register(PddiktiService $pddiktiService): void
    {
        // 1. Validasi form
        $this->validate([
            'nim' => ['required', 'string', 'max:30', 'unique:users,nim'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM ini sudah pernah didaftarkan di CampusCycle.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 2. Validasi ulang NIM ke PddiktiService (PDDIKTI API + Fallback Regex Untirta)
        $validation = $pddiktiService->validateNim($this->nim);

        if (!$validation['valid']) {
            $this->addError('nim', $validation['message']);
            return;
        }

        // 3. Tentukan zona kampus berdasarkan fakultas mahasiswa
        $prefix = substr($this->nim, 0, 3);
        $campusZone = match ($prefix) {
            '333' => 'Cilegon',
            '111', '228', '777' => 'Ciwaru',
            default => 'Sindangsari',
        };

        // Simpan data user ke database
        $user = User::create([
            'nim' => $this->nim,
            'campus_name' => $validation['university'] ?? 'Universitas Sultan Ageng Tirtayasa',
            'campus_zone' => $campusZone,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // 4. Login otomatis
        Auth::login($user);
        session()->regenerate();

        session()->flash('status', 'Selamat datang di CampusCycle Untirta, ' . $user->name . '! Akun Anda berhasil dibuat.');

        // 5. Arahkan user ke halaman /dashboard
        $this->redirect('/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
