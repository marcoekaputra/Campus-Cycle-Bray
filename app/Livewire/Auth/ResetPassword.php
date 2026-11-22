<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Atur Ulang Kata Sandi - CampusCycle Untirta')]
class ResetPassword extends Component
{
    public string $token = '';
    public string $email = '';
    public ?User $user = null;
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
        if ($this->email) {
            $this->user = User::where('email', $this->email)->first();
        }
    }

    public function resetPassword(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Verifikasi token di tabel password_reset_tokens
        $record = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->token)
            ->first();

        if (!$record) {
            $this->addError('password', 'Tautan reset kata sandi tidak valid atau sudah kedaluwarsa.');
            return;
        }

        // Cek kedaluwarsa (maks 60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $this->email)->delete();
            $this->addError('password', 'Tautan reset kata sandi telah kedaluwarsa. Silakan ajukan permintaan baru.');
            return;
        }

        $user = User::where('email', $this->email)->first();
        if (!$user) {
            $this->addError('email', 'Pengguna tidak ditemukan.');
            return;
        }

        // Update password baru
        $user->forceFill([
            'password' => Hash::make($this->password),
        ])->save();

        // Hapus token yang sudah dipakai
        DB::table('password_reset_tokens')->where('email', $this->email)->delete();

        session()->flash('status', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru.');
        $this->redirect(route('login'), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}

