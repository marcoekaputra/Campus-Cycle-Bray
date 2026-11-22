<?php

namespace App\Livewire;

use App\Models\PriceOffer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ProductDetail extends Component
{
    public Product $product;

    // State Modal Penawaran Harga (Nego)
    public bool $showOfferModal = false;
    public string $offeredPrice = '';
    public string $offerMessage = '';

    public function mount(string $slug): void
    {
        $this->product = Product::with(['category', 'seller', 'priceOffers.buyer'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Default harga tawaran diset sedikit di bawah harga asli untuk kenyamanan user
        if (empty($this->offeredPrice) && $this->product->price > 0) {
            $this->offeredPrice = (string) round($this->product->price * 0.9);
        }
    }

    public function openOfferModal(): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk menawar barang ini.');
            $this->redirect(route('login'), navigate: true);
            return;
        }

        if (Auth::id() === $this->product->seller_id) {
            session()->flash('error', 'Anda tidak dapat menawar barang dagangan Anda sendiri.');
            return;
        }

        $this->showOfferModal = true;
    }

    public function closeOfferModal(): void
    {
        $this->showOfferModal = false;
        $this->resetErrorBag();
    }

    public function submitOffer(): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        if (Auth::id() === $this->product->seller_id) {
            $this->addError('offeredPrice', 'Anda adalah penjual barang ini.');
            return;
        }

        $this->validate([
            'offeredPrice' => ['required', 'numeric', 'min:1000', 'max:' . $this->product->price],
            'offerMessage' => ['nullable', 'string', 'max:500'],
        ], [
            'offeredPrice.required' => 'Nominal harga tawaran wajib diisi.',
            'offeredPrice.numeric' => 'Nominal harga harus berupa angka.',
            'offeredPrice.min' => 'Nominal penawaran minimal Rp 1.000.',
            'offeredPrice.max' => 'Nominal penawaran tidak boleh melebihi harga katalog (Rp ' . number_format($this->product->price, 0, ',', '.') . ').',
        ]);

        PriceOffer::create([
            'product_id' => $this->product->id,
            'buyer_id' => Auth::id(),
            'offered_price' => $this->offeredPrice,
            'message' => $this->offerMessage ?: 'Halo, saya tertarik dengan barang ini. Apakah boleh ditawar?',
            'status' => 'pending',
        ]);

        $this->showOfferModal = false;
        $this->offerMessage = '';

        session()->flash('offer_success', 'Tawaran harga sebesar Rp ' . number_format($this->offeredPrice, 0, ',', '.') . ' berhasil dikirimkan ke penjual! Tunggu konfirmasi di dashboard Anda.');

        // Refresh model relations
        $this->product->load('priceOffers');
    }

    public function render()
    {
        $existingOffer = null;
        if (Auth::check()) {
            $existingOffer = PriceOffer::where('product_id', $this->product->id)
                ->where('buyer_id', Auth::id())
                ->latest()
                ->first();
        }

        return view('livewire.product-detail', [
            'existingOffer' => $existingOffer,
        ])->title($this->product->title . ' - CampusCycle Untirta');
    }
}
