<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Faktur Pembelian Resmi - CampusCycle Untirta')]
class OrderInvoice extends Component
{
    public Order $order;

    public function mount(string $orderNumber): void
    {
        $this->order = Order::with(['buyer', 'seller', 'product.category'])->where('order_number', $orderNumber)->firstOrFail();

        $user = Auth::user();
        if (!$user) {
            $this->redirect(route('login'));
            return;
        }

        // Hanya pembeli, penjual, atau admin yang berhak melihat faktur
        $isAuthorized = ($user->id === $this->order->buyer_id)
            || ($user->id === $this->order->seller_id)
            || in_array($user->role ?? '', ['super_admin', 'campus_admin']);

        if (!$isAuthorized) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat faktur transaksi ini.');
        }
    }

    public function render()
    {
        return view('livewire.order-invoice');
    }
}
