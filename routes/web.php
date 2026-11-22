<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\OrderCheckout;
use App\Livewire\ProductCatalog;
use App\Livewire\ProductCreate;
use App\Livewire\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. Beranda Marketplace (ProductCatalog Component)
Route::get('/', ProductCatalog::class)->name('home');

// 2. Upload Barang / Jual Produk (Wajib sebelum /product/{slug})
Route::middleware('auth')->group(function () {
    Route::get('/product/create', ProductCreate::class)->name('product.create');
    Route::get('/checkout/{slug}', OrderCheckout::class)->name('order.checkout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/chat', \App\Livewire\Chat::class)->name('chat');
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\OrderInvoiceController::class, 'download'])->name('orders.invoice');
    Route::get('/order/{orderNumber}/invoice', \App\Livewire\OrderInvoice::class)->name('order.invoice.view');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});

// 3. Detail Produk & Fitur Tawar Menawar (Nego)
Route::get('/product/{slug}', ProductDetail::class)->name('product.detail');

// 4. Guest Routes (Login & Register & Password Reset)
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::post('/register', function (Request $request, \App\Services\PddiktiService $pddiktiService) {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'min:6', 'max:30'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.min' => 'NIM minimal 6 karakter.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email pribadi wajib diisi.',
            'email.email' => 'Format email pribadi tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $cleanNim = trim($validated['nim']);
        $cleanEmail = strtolower(trim($validated['email']));
        $cleanName = trim($validated['name']);

        $existingEmailUser = \App\Models\User::where('email', $cleanEmail)->where('nim', '!=', $cleanNim)->first();
        if ($existingEmailUser) {
            return back()->withErrors(['email' => 'Email ini sudah dipakai oleh akun lain. Silakan gunakan email pribadi lain.'])->withInput();
        }

        $prefix = substr($cleanNim, 0, 3);
        $campusZone = match ($prefix) {
            '333', '331', '332', '334', '335', '336', '337' => 'Cilegon',
            '111', '112', '228', '777', '771', '772', '773' => 'Ciwaru',
            default => 'Sindangsari',
        };

        $user = \App\Models\User::where('nim', $cleanNim)->first();
        if ($user) {
            $user->update([
                'name' => $cleanName,
                'email' => $cleanEmail,
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'campus_zone' => $campusZone,
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
            ]);
        } else {
            $user = \App\Models\User::create([
                'nim' => $cleanNim,
                'name' => $cleanName,
                'email' => $cleanEmail,
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => $campusZone,
                'role' => 'student',
            ]);
        }

        $user->wallet()->firstOrCreate([], ['balance' => 0]);

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->flash('status', 'Selamat datang di CampusCycle Untirta, ' . $user->name . '! Akun Anda berhasil diaktifkan.');

        return redirect()->intended('/dashboard');
    })->name('register.post');

    Route::get('/login', Login::class)->name('login');
    Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');
    Route::post('/login', function (Request $request) {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'NIM atau Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $cleanLogin = trim($request->input('login'));
        $isEmail = filter_var($cleanLogin, FILTER_VALIDATE_EMAIL);
        $loginField = $isEmail ? 'email' : 'nim';
        $loginValue = $isEmail ? strtolower($cleanLogin) : $cleanLogin;
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        $attempt = Auth::attempt([$loginField => $loginValue, 'password' => $password], $remember);
        if (!$attempt) {
            $attempt = Auth::attempt(['email' => strtolower($cleanLogin), 'password' => $password], $remember);
        }
        if (!$attempt) {
            $attempt = Auth::attempt(['nim' => $cleanLogin, 'password' => $password], $remember);
        }

        if (!$attempt) {
            return back()->withErrors([
                'login' => 'Kombinasi akun (NIM/Email dan Kata Sandi) tidak sesuai.',
            ])->withInput($request->only('login'));
        }

        $request->session()->regenerate();
        $request->session()->flash('status', 'Berhasil masuk ke akun Anda.');

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/dashboard');
    })->name('login.post');
});

// 5. Admin Console Routes (Back-Office & Operations Platform)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
});
