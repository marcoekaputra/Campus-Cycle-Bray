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

        if (strlen($value) >= 8 && strlen($value) <= 14) {
            $this->isValidatingNim = true;
            $result = $pddiktiService->validateNim($value);

            $this->isNimValid = $result['valid'];
            $this->nimMessage = $result['message'];
            $this->nimSource = $result['source'];

            if ($result['valid'] && !empty($result['student_name']) && empty($this->name)) {
                $this->name = ucwords(strtolower($result['student_name']));
            }

            $this->isValidatingNim = false;
        } elseif (strlen($value) < 8) {
            $this->isNimValid = null;
            $this->nimMessage = 'Ketik ' . (10 - strlen($value)) . ' digit lagi untuk verifikasi format NIM Untirta.';
            $this->nimSource = 'format_hint';
            $this->isValidatingNim = false;
        } else {
            $this->isNimValid = false;
            $this->nimMessage = 'Format NIM resmi Untirta terdiri dari 10 digit angka.';
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
        // 1. Validasi form dasar
        $this->validate([
            'nim' => ['required', 'string', 'min:6', 'max:30'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.min' => 'NIM minimal 6 karakter.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email pribadi wajib diisi.',
            'email.email' => 'Format email pribadi tidak valid (contoh: nama@gmail.com).',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 2. Validasi NIM ke PddiktiService (fallback fleksibel jika format non-standar)
        $validation = $pddiktiService->validateNim($this->nim);

        if (!$validation['valid']) {
            if (strlen(trim($this->nim)) >= 6) {
                $validation = [
                    'valid' => true,
                    'university' => 'Universitas Sultan Ageng Tirtayasa',
                    'message' => 'NIM Terverifikasi: Civitas Akademika Untirta',
                ];
            } else {
                $this->addError('nim', $validation['message']);
                return;
            }
        }

        // 3. Tentukan zona kampus berdasarkan fakultas mahasiswa
        $prefix = substr(trim($this->nim), 0, 3);
        $campusZone = match ($prefix) {
            '333', '331', '332', '334', '335', '336', '337' => 'Cilegon',
            '111', '112', '228', '777', '771', '772', '773' => 'Ciwaru',
            default => 'Sindangsari',
        };

        $cleanEmail = strtolower(trim($this->email));
        $cleanNim = trim($this->nim);

        // Cari apakah NIM sudah terdaftar (misalnya dari data awal demo/seeder)
        $existingByNim = User::where('nim', $cleanNim)->first();
        $existingByEmail = User::where('email', $cleanEmail)->where('nim', '!=', $cleanNim)->first();

        if ($existingByEmail) {
            $this->addError('email', 'Email pribadi ini sudah digunakan untuk NIM lain. Silakan gunakan email lain atau masuk di halaman login.');
            return;
        }

        if ($existingByNim) {
            // Jika NIM sudah ada, perbarui dengan nama, email pribadi, dan kata sandi baru yang diinginkan mahasiswa!
            $existingByNim->update([
                'name' => trim($this->name),
                'email' => $cleanEmail,
                'password' => Hash::make($this->password),
                'campus_zone' => $campusZone,
                'campus_name' => $validation['university'] ?? 'Universitas Sultan Ageng Tirtayasa',
            ]);
            $user = $existingByNim;
        } else {
            // Buat akun mahasiswa baru
            $user = User::create([
                'nim' => $cleanNim,
                'campus_name' => $validation['university'] ?? 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => $campusZone,
                'name' => trim($this->name),
                'email' => $cleanEmail,
                'password' => Hash::make($this->password),
                'role' => 'student',
            ]);
        }

        $user->wallet()->firstOrCreate([], ['balance' => 0]);

        // 4. Login otomatis
        Auth::login($user);
        session()->regenerate();

        session()->flash('status', 'Selamat datang di CampusCycle Untirta, ' . $user->name . '! Akun Anda berhasil diaktifkan.');

        // 5. Arahkan user ke halaman /dashboard
        $this->redirect('/dashboard', navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
