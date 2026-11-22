<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Jual Barang Pre-loved - CampusCycle FT Untirta')]
class ProductCreate extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public string $price = '';
    public string $condition = 'good';
    public string $condition_grade = 'Grade A (Mulus)';
    public ?int $category_id = null;
    public string $size_tier = 'small'; // small, medium, bulky
    
    // Upload & Image selection
    public $image = null;
    public string $imageUrlInput = '';
    public string $uploadMode = 'file'; // 'file' or 'url' or 'preset'

    public string $pickup_location = '';
    public bool $is_negotiable = true;
    public string $campus_zone = 'Cilegon';

    public function mount(): void
    {
        $user = Auth::user();
        $this->campus_zone = $user->campus_zone ?: 'Cilegon';
        $this->pickup_location = 'Kampus Untirta ' . $this->campus_zone;

        $firstCategory = Category::first();
        if ($firstCategory) {
            $this->category_id = $firstCategory->id;
        }
    }

    public function selectPresetImage(string $url, string $presetTitle = '', string $tier = 'small'): void
    {
        $this->imageUrlInput = $url;
        $this->image = null;
        if ($presetTitle && empty($this->title)) {
            $this->title = $presetTitle;
        }
        if ($tier) {
            $this->size_tier = $tier;
        }
    }

    public function removeImage(): void
    {
        $this->image = null;
        $this->imageUrlInput = '';
    }

    public function saveProduct(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'price' => ['required', 'numeric', 'min:1000'],
            'condition_grade' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'size_tier' => ['required', 'in:small,medium,bulky'],
            'image' => ['nullable', 'image', 'max:8192'], // up to 8MB
            'imageUrlInput' => ['nullable', 'string', 'max:1000'],
            'pickup_location' => ['nullable', 'string', 'max:255'],
        ], [
            'title.required' => 'Judul barang wajib diisi.',
            'description.required' => 'Deskripsi barang wajib diisi minimal 10 karakter.',
            'price.required' => 'Harga barang wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal adalah Rp 1.000.',
            'category_id.required' => 'Pilih kategori barang.',
            'size_tier.required' => 'Pilih kategori ukuran logistik barang.',
            'image.image' => 'File harus berupa format gambar (JPG, PNG, JPEG, WEBP).',
            'image.max' => 'Ukuran foto maksimal adalah 8MB.',
        ]);

        $user = Auth::user();

        // Tentukan URL Foto Barang
        $imageUrl = null;
        if ($this->image) {
            $path = $this->image->store('products', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif (!empty($this->imageUrlInput)) {
            $imageUrl = $this->imageUrlInput;
        } else {
            // Placeholder default berkualitas tinggi
            $imageUrl = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=800&auto=format&fit=crop&q=80';
        }

        // Buat slug unik
        $slug = Str::slug($this->title) . '-' . Str::lower(Str::random(6));

        // Simpan Produk
        $product = Product::create([
            'seller_id' => $user->id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $slug,
            'description' => $this->description,
            'price' => $this->price,
            'condition' => $this->condition,
            'condition_grade' => $this->condition_grade,
            'size_tier' => $this->size_tier,
            'campus_zone' => $user->campus_zone ?: $this->campus_zone,
            'pickup_location' => $this->pickup_location ?: 'Kampus Untirta ' . $this->campus_zone,
            'image_url' => $imageUrl,
            'is_negotiable' => $this->is_negotiable,
            'status' => 'available',
        ]);

        session()->flash('status', 'Barang "' . $product->title . '" berhasil ditayangkan di katalog CampusCycle!');
        $this->redirect(route('product.detail', $product->slug), navigate: true);
    }

    public function render()
    {
        $categories = Category::where('is_active', true)->get();

        return view('livewire.product-create', [
            'categories' => $categories,
        ]);
    }
}
