<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderInvoiceController extends Controller
{
    /**
     * Download atau pratinjau invoice resmi transaksi pesanan
     */
    public function download(Request $request, Order $order)
    {
        // Pastikan hanya pembeli atau penjual yang dapat mengakses invoice pesanan ini
        if ($order->buyer_id !== Auth::id() && $order->seller_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat invoice pesanan ini.');
        }

        $order->load(['buyer', 'seller', 'product.category']);

        // Pratinjau langsung di browser (bisa langsung cetak via browser print)
        if ($request->has('preview')) {
            return view('invoices.order-receipt', compact('order'));
        }

        // Generate file PDF menggunakan Barryvdh/DomPDF
        $pdf = Pdf::loadView('invoices.order-receipt', compact('order'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Invoice-CampusCycle-{$order->order_number}.pdf");
    }
}
