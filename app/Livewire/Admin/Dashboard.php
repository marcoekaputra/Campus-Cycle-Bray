<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletMutation;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Console Administrator - CampusCycle Untirta')]
class Dashboard extends Component
{
    use WithPagination;

    // Active Navigation Tab: 'overview', 'products', 'users', 'orders', 'finance', 'disputes'
    public string $activeTab = 'overview';

    // Filters: Produk
    public string $productSearch = '';
    public string $productCategory = '';
    public string $productZone = '';
    public string $productStatus = '';

    // Filters: Pengguna
    public string $userSearch = '';
    public string $userRole = '';
    public string $userZone = '';

    // Filters: Pesanan
    public string $orderSearch = '';
    public string $orderStatus = '';
    public string $orderDeliveryMethod = '';

    // Filters: Keuangan & Sengketa
    public string $withdrawalFilter = 'all';
    public string $disputeFilter = 'all';

    // Filters & Modal: Monitoring Chat Civitas
    public string $chatSearch = '';
    public ?int $inspectConversationId = null;

    // Modal: Takedown Produk
    public bool $showTakedownModal = false;
    public ?int $selectedProductId = null;
    public string $takedownReason = '';

    // Modal: Penyesuaian Saldo Dompet User
    public bool $showBalanceModal = false;
    public ?int $selectedUserId = null;
    public string $balanceAction = 'credit'; // 'credit' atau 'debit'
    public string $balanceAmount = '';
    public string $balanceNotes = '';

    // Modal: Resolusi Sengketa
    public bool $showDisputeModal = false;
    public ?int $selectedDisputeId = null;
    public string $disputeResolutionNotes = '';

    // Reset pagination saat filter diubah
    public function updatingProductSearch(): void { $this->resetPage('productsPage'); }
    public function updatingProductCategory(): void { $this->resetPage('productsPage'); }
    public function updatingProductStatus(): void { $this->resetPage('productsPage'); }
    public function updatingUserSearch(): void { $this->resetPage('usersPage'); }
    public function updatingOrderSearch(): void { $this->resetPage('ordersPage'); }
    public function updatingOrderStatus(): void { $this->resetPage('ordersPage'); }
    public function updatingChatSearch(): void { $this->resetPage('chatsPage'); }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    // ==========================================
    // MONITORING CHAT MAHASISWA
    // ==========================================
    public function openInspectChat(int $conversationId): void
    {
        $this->inspectConversationId = $conversationId;
    }

    public function closeInspectChat(): void
    {
        $this->inspectConversationId = null;
    }

    // ==========================================
    // 1. MODERASI PRODUK (QC & TAKEDOWN)
    // ==========================================
    public function openTakedownModal(int $productId): void
    {
        $this->selectedProductId = $productId;
        $this->takedownReason = 'Melanggar Pedoman Konten Barang Kampus Untirta (Barang Terlarang/Informasi Palsu).';
        $this->showTakedownModal = true;
    }

    public function closeTakedownModal(): void
    {
        $this->showTakedownModal = false;
        $this->selectedProductId = null;
        $this->takedownReason = '';
    }

    public function takedownProduct(): void
    {
        if (!$this->selectedProductId) return;

        $product = Product::findOrFail($this->selectedProductId);
        $product->update([
            'status' => 'archived',
            'is_flagged' => true,
            'takedown_reason' => $this->takedownReason ?: 'Dibekukan oleh Administrator platform.',
        ]);

        $this->closeTakedownModal();
        session()->flash('status', 'Produk "' . $product->title . '" berhasil DITAKEDOWN dan disembunyikan dari katalog.');
    }

    public function restoreProduct(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $product->update([
            'status' => 'available',
            'is_flagged' => false,
            'takedown_reason' => null,
        ]);

        session()->flash('status', 'Produk "' . $product->title . '" berhasil DIPULIHKAN dan kembali aktif di katalog.');
    }

    // ==========================================
    // 2. MANAJEMEN PENGGUNA (SUSPEND & SALDO)
    // ==========================================
    public function toggleSuspendUser(int $userId): void
    {
        $user = User::findOrFail($userId);

        if ($user->id === Auth::id()) {
            session()->flash('error', 'Anda tidak dapat membekukan akun administrator Anda sendiri.');
            return;
        }

        $user->update([
            'is_suspended' => !$user->is_suspended,
        ]);

        $statusText = $user->is_suspended ? 'DIBEKUKAN (SUSPEND)' : 'DIAKTIFKAN KEMBALI';
        session()->flash('status', 'Akun mahasiswa ' . $user->name . ' (' . $user->nim . ') berhasil ' . $statusText . '.');
    }

    public function openBalanceModal(int $userId): void
    {
        $this->selectedUserId = $userId;
        $this->balanceAction = 'credit';
        $this->balanceAmount = '50000';
        $this->balanceNotes = 'Kompensasi / Penyesuaian Saldo oleh Administrator Platform.';
        $this->showBalanceModal = true;
    }

    public function closeBalanceModal(): void
    {
        $this->showBalanceModal = false;
        $this->selectedUserId = null;
        $this->balanceAmount = '';
        $this->balanceNotes = '';
    }

    public function applyBalanceAdjustment(): void
    {
        $this->validate([
            'balanceAmount' => ['required', 'numeric', 'min:1000'],
            'balanceNotes' => ['required', 'string', 'max:255'],
        ]);

        $user = User::with('wallet')->findOrFail($this->selectedUserId);
        $amount = (float) $this->balanceAmount;

        DB::transaction(function () use ($user, $amount) {
            $wallet = $user->wallet ?: Wallet::create(['user_id' => $user->id, 'balance' => 0.00, 'status' => 'active']);
            $currentBalance = (float) $wallet->balance;

            if ($this->balanceAction === 'credit') {
                $newBalance = $currentBalance + $amount;
                $wallet->update(['balance' => $newBalance]);

                WalletMutation::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'credit',
                    'amount' => $amount,
                    'balance_before' => $currentBalance,
                    'balance_after' => $newBalance,
                    'description' => 'Penyesuaian Kredit oleh Admin: ' . $this->balanceNotes,
                    'reference_type' => 'admin_adjustment',
                    'reference_id' => Auth::id(),
                ]);
            } else {
                if ($currentBalance < $amount) {
                    session()->flash('error', 'Saldo dompet pengguna tidak mencukupi untuk pengurangan sebesar ini.');
                    return;
                }
                $newBalance = $currentBalance - $amount;
                $wallet->update(['balance' => $newBalance]);

                WalletMutation::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'debit',
                    'amount' => $amount,
                    'balance_before' => $currentBalance,
                    'balance_after' => $newBalance,
                    'description' => 'Pengurangan Saldo oleh Admin: ' . $this->balanceNotes,
                    'reference_type' => 'admin_adjustment',
                    'reference_id' => Auth::id(),
                ]);
            }
        });

        $this->closeBalanceModal();
        session()->flash('status', 'Penyesuaian saldo pada akun ' . $user->name . ' berhasil diproses.');
    }

    // ==========================================
    // 3. OPERASIONAL PESANAN & LOGISTIK
    // ==========================================
    public function forceCompleteOrder(int $orderId): void
    {
        $order = Order::with(['seller', 'buyer', 'product'])->findOrFail($orderId);

        if ($order->status === 'completed') {
            session()->flash('error', 'Pesanan ini sudah berstatus selesai.');
            return;
        }

        DB::transaction(function () use ($order) {
            // Trigger MySQL trg_auto_disburse_completed_order akan otomatis mencairkan dana ke penjual & mark produk sold
            $order->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        });

        session()->flash('status', 'Pesanan #' . $order->order_number . ' diselesaikan secara paksa oleh Admin. Dana otomatis diteruskan ke dompet penjual.');
    }

    public function forceCancelAndRefund(int $orderId): void
    {
        $order = Order::with(['buyer.wallet', 'seller', 'product'])->findOrFail($orderId);

        if (in_array($order->status, ['completed', 'cancelled'])) {
            session()->flash('error', 'Pesanan yang sudah selesai atau sudah dibatalkan tidak dapat diproses.');
            return;
        }

        DB::transaction(function () use ($order) {
            // Jika pesanan sudah dibayar oleh pembeli, lakukan pengembalian dana (refund)
            if ($order->payment_status === 'paid' && $order->buyer) {
                $wallet = $order->buyer->wallet ?: Wallet::create(['user_id' => $order->buyer_id, 'balance' => 0.00, 'status' => 'active']);
                $currentBalance = (float) $wallet->balance;
                $refundAmount = (float) $order->total_amount;
                $newBalance = $currentBalance + $refundAmount;

                $wallet->update(['balance' => $newBalance]);

                WalletMutation::create([
                    'wallet_id' => $wallet->id,
                    'order_id' => $order->id,
                    'type' => 'credit',
                    'amount' => $refundAmount,
                    'balance_before' => $currentBalance,
                    'balance_after' => $newBalance,
                    'description' => 'Pengembalian Dana (Auto-Refund) Pesanan #' . $order->order_number . ' oleh Admin.',
                    'reference_type' => 'order_refund',
                    'reference_id' => $order->id,
                ]);

                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'refunded',
                    'cancelled_at' => now(),
                ]);
            } else {
                $order->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
            }

            // Kembalikan produk ke status available
            if ($order->product) {
                $order->product->update(['status' => 'available']);
            }
        });

        session()->flash('status', 'Pesanan #' . $order->order_number . ' berhasil dibatalkan dan dana dikembalikan penuh ke dompet pembeli.');
    }

    // ==========================================
    // 4. KEUANGAN & PENCAIRAN SALDO (WITHDRAWAL)
    // ==========================================
    public function approveWithdrawal(int $withdrawalId): void
    {
        $w = Withdrawal::with('user.wallet')->findOrFail($withdrawalId);

        if ($w->status !== 'pending') {
            session()->flash('error', 'Permintaan pencairan ini sudah diproses sebelumnya.');
            return;
        }

        DB::transaction(function () use ($w) {
            $w->update([
                'status' => 'approved',
                'admin_notes' => 'Dana telah berhasil ditransfer ke rekening mahasiswa bersangkutan.',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);

            // Catat mutasi penarikan dana jika belum dipotong saat pengajuan
            if ($w->user && $w->user->wallet) {
                $wallet = $w->user->wallet;
                $current = (float) $wallet->balance;
                if ($current >= (float) $w->amount) {
                    $new = $current - (float) $w->amount;
                    $wallet->update(['balance' => $new]);

                    WalletMutation::create([
                        'wallet_id' => $wallet->id,
                        'type' => 'debit',
                        'amount' => $w->amount,
                        'balance_before' => $current,
                        'balance_after' => $new,
                        'description' => 'Pencairan Dana (Withdrawal) ke ' . $w->bank_name . ' (' . $w->account_number . ') Disetujui Admin',
                        'reference_type' => 'withdrawal',
                        'reference_id' => $w->id,
                    ]);
                }
            }
        });

        session()->flash('status', 'Pencairan dana sebesar Rp ' . number_format($w->amount, 0, ',', '.') . ' untuk ' . $w->account_holder . ' berhasil DISETUJUI.');
    }

    public function rejectWithdrawal(int $withdrawalId): void
    {
        $w = Withdrawal::findOrFail($withdrawalId);

        if ($w->status !== 'pending') {
            session()->flash('error', 'Permintaan pencairan ini sudah diproses.');
            return;
        }

        $w->update([
            'status' => 'rejected',
            'admin_notes' => 'Nomor rekening atau nama pemilik tidak cocok dengan data PDDIKTI mahasiswa.',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        session()->flash('status', 'Permintaan pencairan dana berhasil DITOLAK.');
    }

    public function createDemoWithdrawal(): void
    {
        $student = User::where('role', 'student')->first();
        if (!$student) return;

        Withdrawal::create([
            'user_id' => $student->id,
            'amount' => 150000.00,
            'bank_name' => 'Bank Mandiri',
            'account_number' => '1370018928371',
            'account_holder' => $student->name,
            'status' => 'pending',
            'admin_notes' => null,
        ]);

        session()->flash('status', 'Contoh pengajuan pencairan dana (Withdrawal) berhasil dibuat untuk pengujian audit.');
    }

    // ==========================================
    // 5. PUSAT RESOLUSI & SENGKETA (DISPUTES)
    // ==========================================
    public function resolveDisputeRefundBuyer(int $disputeId): void
    {
        $dispute = Dispute::with(['order', 'complainant', 'respondent'])->findOrFail($disputeId);

        DB::transaction(function () use ($dispute) {
            $dispute->update([
                'status' => 'resolved_refund_buyer',
                'resolution_notes' => 'Admin memutuskan pengembalian dana penuh kepada pembeli berdasarkan bukti yang sah.',
                'resolved_by' => Auth::id(),
                'resolved_at' => now(),
            ]);

            // Eksekusi auto-refund pada pesanan
            $this->forceCancelAndRefund($dispute->order_id);
        });

        session()->flash('status', 'Sengketa diselesaikan: Dana berhasil di-refund penuh ke pembeli (' . $dispute->complainant->name . ').');
    }

    public function resolveDisputeReleaseSeller(int $disputeId): void
    {
        $dispute = Dispute::with(['order', 'complainant', 'respondent'])->findOrFail($disputeId);

        DB::transaction(function () use ($dispute) {
            $dispute->update([
                'status' => 'resolved_release_seller',
                'resolution_notes' => 'Penjual telah terbukti mengirimkan barang sesuai spesifikasi. Dana escrow dicairkan ke penjual.',
                'resolved_by' => Auth::id(),
                'resolved_at' => now(),
            ]);

            // Eksekusi penyelesaian pesanan
            $this->forceCompleteOrder($dispute->order_id);
        });

        session()->flash('status', 'Sengketa diselesaikan: Dana pesanan berhasil diteruskan ke penjual (' . $dispute->respondent->name . ').');
    }

    /**
     * Admin melakukan crosscheck dan menyetujui pengembalian dana return ke pembeli (dipotong app fee 1.5%)
     */
    public function approveReturnRefund(int $orderId): void
    {
        $order = Order::with(['buyer.wallet', 'seller', 'product'])->findOrFail($orderId);

        if ($order->return_status === 'completed') {
            session()->flash('error', 'Pesanan ini sudah selesai di-refund sebelumnya.');
            return;
        }

        DB::transaction(function () use ($order) {
            // Hitung nilai refund: harga produk dikurangi application fee 1.5%
            $productPrice = (float) $order->total_amount - (float) $order->shipping_fee - (float) $order->buyer_app_fee;
            if ($productPrice <= 0) {
                $productPrice = (float) $order->total_amount;
            }

            $buyerAppFee = (float) $order->buyer_app_fee > 0 ? (float) $order->buyer_app_fee : round($productPrice * 0.015, 2);
            $refundAmount = max(0, $productPrice - $buyerAppFee);

            $wallet = $order->buyer->wallet ?: Wallet::create(['user_id' => $order->buyer_id, 'balance' => 0.00, 'status' => 'active']);
            $balanceBefore = (float) $wallet->balance;
            $balanceAfter = $balanceBefore + $refundAmount;

            $wallet->update(['balance' => $balanceAfter]);

            WalletMutation::create([
                'wallet_id' => $wallet->id,
                'order_id' => $order->id,
                'type' => 'credit',
                'amount' => $refundAmount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => "Pengembalian Dana (Refund Return #{$order->order_number}) - Dipotong Biaya Layanan Aplikasi 1.5%",
                'reference_type' => 'order_return_refund',
                'reference_id' => $order->id,
            ]);

            $order->update([
                'status' => 'returned',
                'return_status' => 'completed',
                'return_refund_amount' => $refundAmount,
                'return_admin_approved_at' => now(),
            ]);

            if ($order->product) {
                $order->product->update(['status' => 'available']);
            }

            Dispute::where('order_id', $order->id)->update([
                'status' => 'resolved_refund_buyer',
                'resolution_notes' => 'Admin menyetujui pengembalian dana return sebesar Rp ' . number_format($refundAmount, 0, ',', '.') . ' ke pembeli (setelah dipotong fee aplikasi 1.5%).',
                'resolved_by' => Auth::id(),
                'resolved_at' => now(),
            ]);
        });

        session()->flash('status', 'Persetujuan Return Berhasil: Refund Rp ' . number_format($order->return_refund_amount, 0, ',', '.') . ' telah dicairkan ke saldo pembeli (' . $order->buyer->name . ').');
    }

    public function createDemoDispute(): void
    {
        $order = Order::where('status', '!=', 'cancelled')->latest()->first();
        if (!$order) {
            session()->flash('error', 'Tidak ada pesanan aktif untuk dibuatkan tiket sengketa demo.');
            return;
        }

        Dispute::create([
            'order_id' => $order->id,
            'complainant_id' => $order->buyer_id,
            'respondent_id' => $order->seller_id,
            'reason' => 'Kondisi barang tidak sesuai deskripsi (Ada cacat/kerusakan tidak dilaporkan)',
            'description' => 'Barang yang diterima saat COD kampus kondisinya ada retak di bagian belakang, tidak seperti yang tertera di foto katalog.',
            'status' => 'open',
            'proof_image' => $order->product->image_url ?? null,
        ]);

        session()->flash('status', 'Tiket sengketa demo berhasil dibuat untuk pesanan #' . $order->order_number . '.');
    }

    public function render()
    {
        // 1. Data Ringkasan (Executive Metrics)
        $totalGmv = Order::where('status', 'completed')->sum('total_amount');
        $escrowBalance = Order::whereIn('status', ['paid', 'processing', 'shipped'])->sum('total_amount');
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $activeProductsCount = Product::where('status', 'available')->count();
        $flaggedProductsCount = Product::where('is_flagged', true)->count();
        $totalOrdersCount = Order::count();
        $completedOrdersCount = Order::where('status', 'completed')->count();
        $pendingDisputesCount = Dispute::whereIn('status', ['open', 'under_review'])->count();
        $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')->count();

        // Metrik Kampus (Order per Zona)
        $zoneStats = Order::select('destination_zone', DB::raw('count(*) as total'))
            ->whereNotNull('destination_zone')
            ->groupBy('destination_zone')
            ->pluck('total', 'destination_zone')
            ->toArray();

        // 2. Query Tab Produk
        $productsQuery = Product::with(['seller', 'category'])->latest();
        if ($this->productSearch) {
            $productsQuery->where(function ($q) {
                $q->where('title', 'like', '%' . $this->productSearch . '%')
                  ->orWhereHas('seller', fn($s) => $s->where('name', 'like', '%' . $this->productSearch . '%')->orWhere('nim', 'like', '%' . $this->productSearch . '%'));
            });
        }
        if ($this->productCategory) {
            $productsQuery->where('category_id', $this->productCategory);
        }
        if ($this->productZone) {
            $productsQuery->where('campus_zone', $this->productZone);
        }
        if ($this->productStatus) {
            if ($this->productStatus === 'flagged') {
                $productsQuery->where('is_flagged', true);
            } else {
                $productsQuery->where('status', $this->productStatus);
            }
        }
        $products = $productsQuery->paginate(10, ['*'], 'productsPage');

        // 3. Query Tab Pengguna
        $usersQuery = User::with(['wallet'])->withCount(['products', 'orders', 'sales'])->latest();
        if ($this->userSearch) {
            $usersQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->userSearch . '%')
                  ->orWhere('nim', 'like', '%' . $this->userSearch . '%')
                  ->orWhere('email', 'like', '%' . $this->userSearch . '%');
            });
        }
        if ($this->userRole) {
            $usersQuery->where('role', $this->userRole);
        }
        if ($this->userZone) {
            $usersQuery->where('campus_zone', $this->userZone);
        }
        $users = $usersQuery->paginate(10, ['*'], 'usersPage');

        // 4. Query Tab Pesanan
        $ordersQuery = Order::with(['buyer', 'seller', 'product'])->latest();
        if ($this->orderSearch) {
            $ordersQuery->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->orderSearch . '%')
                  ->orWhereHas('buyer', fn($b) => $b->where('name', 'like', '%' . $this->orderSearch . '%')->orWhere('nim', 'like', '%' . $this->orderSearch . '%'))
                  ->orWhereHas('seller', fn($s) => $s->where('name', 'like', '%' . $this->orderSearch . '%'));
            });
        }
        if ($this->orderStatus) {
            $ordersQuery->where('status', $this->orderStatus);
        }
        if ($this->orderDeliveryMethod) {
            $ordersQuery->where('delivery_method', $this->orderDeliveryMethod);
        }
        $orders = $ordersQuery->paginate(10, ['*'], 'ordersPage');

        // 5. Query Tab Keuangan (Withdrawals & Escrow)
        $withdrawalsQuery = Withdrawal::with('user')->latest();
        if ($this->withdrawalFilter !== 'all') {
            $withdrawalsQuery->where('status', $this->withdrawalFilter);
        }
        $withdrawals = $withdrawalsQuery->paginate(10, ['*'], 'withdrawalsPage');

        $escrowOrders = Order::with(['buyer', 'seller', 'product'])
            ->whereIn('status', ['paid', 'processing', 'shipped'])
            ->latest()
            ->take(8)
            ->get();

        // 6. Query Tab Sengketa (Disputes)
        $disputesQuery = Dispute::with(['order', 'complainant', 'respondent', 'resolver'])->latest();
        if ($this->disputeFilter !== 'all') {
            $disputesQuery->where('status', $this->disputeFilter);
        }
        $disputes = $disputesQuery->paginate(10, ['*'], 'disputesPage');

        // 7. Query Tab Monitoring Chat Civitas
        $totalConversationsCount = Conversation::count();
        $chatsQuery = Conversation::with(['buyer', 'seller', 'product', 'latestMessage'])
            ->withCount('messages')
            ->latest('last_message_at');

        if ($this->chatSearch) {
            $term = '%' . $this->chatSearch . '%';
            $chatsQuery->where(function ($q) use ($term) {
                $q->whereHas('buyer', fn($u) => $u->where('name', 'like', $term)->orWhere('nim', 'like', $term))
                  ->orWhereHas('seller', fn($u) => $u->where('name', 'like', $term)->orWhere('nim', 'like', $term))
                  ->orWhereHas('product', fn($p) => $p->where('title', 'like', $term));
            });
        }
        $chats = $chatsQuery->paginate(10, ['*'], 'chatsPage');

        $inspectConversation = null;
        if ($this->inspectConversationId) {
            $inspectConversation = Conversation::with(['buyer', 'seller', 'product', 'messages.sender'])
                ->find($this->inspectConversationId);
        }

        $categories = Category::all();

        return view('livewire.admin.dashboard', compact(
            'totalGmv',
            'escrowBalance',
            'totalUsers',
            'totalProducts',
            'activeProductsCount',
            'flaggedProductsCount',
            'totalOrdersCount',
            'completedOrdersCount',
            'pendingDisputesCount',
            'pendingWithdrawalsCount',
            'totalConversationsCount',
            'zoneStats',
            'products',
            'users',
            'orders',
            'withdrawals',
            'escrowOrders',
            'disputes',
            'chats',
            'inspectConversation',
            'categories'
        ));
    }
}

