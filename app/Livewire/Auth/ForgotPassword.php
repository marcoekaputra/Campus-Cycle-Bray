<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Lupa Kata Sandi - CampusCycle Untirta')]
class ForgotPassword extends Component
{
    public string $login = ''; // NIM atau Email Mahasiswa Untirta
    public string $personalEmail = ''; // Alamat Gmail Pribadi Penerima Tautan
    public ?string $sentEmail = null;
    public ?string $demoResetUrl = null;
    public bool $emailSent = false;

    public function sendResetLink(): void
    {
        $cleanLogin = trim($this->login);
        $cleanPersonalEmail = trim($this->personalEmail);

        // Jika personalEmail kosong namun login berformat email, gunakan login sebagai fallback
        if (empty($cleanPersonalEmail) && filter_var($cleanLogin, FILTER_VALIDATE_EMAIL)) {
            $cleanPersonalEmail = $cleanLogin;
            $this->personalEmail = $cleanPersonalEmail;
        }

        $this->validate([
            'login' => ['required', 'string'],
            'personalEmail' => ['required', 'email'],
        ], [
            'login.required' => 'NIM atau Akun Mahasiswa Untirta wajib diisi.',
            'personalEmail.required' => 'Alamat Gmail pribadi wajib diisi untuk menerima tautan reset kata sandi.',
            'personalEmail.email' => 'Format alamat Gmail pribadi tidak valid (contoh: namaanda@gmail.com).',
        ]);

        $isEmail = filter_var($cleanLogin, FILTER_VALIDATE_EMAIL);

        $user = $isEmail
            ? User::where('email', $cleanLogin)->first()
            : User::where('nim', $cleanLogin)->first();

        if (!$user) {
            $this->addError('login', 'Akun dengan NIM atau Identitas tersebut tidak terdaftar di sistem CampusCycle.');
            return;
        }

        // Buat token reset acak 64 karakter
        $token = Str::random(64);

        // Simpan / perbarui ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);

        $this->sentEmail = $cleanPersonalEmail;
        $this->demoResetUrl = $resetUrl;
        $this->emailSent = true;

        // Kirim email via Laravel Mailer langsung ke Gmail pribadi
        try {
            Mail::send('emails.password-reset', [
                'user' => $user,
                'targetEmail' => $cleanPersonalEmail,
                'resetUrl' => $resetUrl,
            ], function ($message) use ($user, $cleanPersonalEmail) {
                $message->to($cleanPersonalEmail, $user->name)
                        ->subject('Instruksi Reset Kata Sandi Akun CampusCycle Untirta');
            });
        } catch (\Throwable $e) {
            // Mailer fallback logging
            report($e);
        }

        session()->flash('status', "Tautan reset kata sandi telah dikirimkan ke Gmail pribadi Anda: {$cleanPersonalEmail}.");
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
