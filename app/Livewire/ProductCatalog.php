<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('CampusCycle - Marketplace Pre-loved Mahasiswa Fakultas Teknik & Untirta')]
class ProductCatalog extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'category', history: true)]
    public ?int $selectedCategory = null;

    #[Url(as: 'zone', history: true)]
    public string $selectedZone = '';

    #[Url(as: 'faculty', history: true)]
    public string $selectedFaculty = '';

    #[Url(as: 'tier', history: true)]
    public string $selectedTier = '';

    #[Url(as: 'sort', history: true)]
    public string $sortBy = 'latest';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedZone(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedFaculty(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedTier(): void
    {
        $this->resetPage();
    }

    public function filterCategory(?int $categoryId): void
    {
        $this->selectedCategory = ($this->selectedCategory === $categoryId) ? null : $categoryId;
        $this->resetPage();
    }

    public function filterZone(string $zone): void
    {
        $this->selectedZone = ($this->selectedZone === $zone) ? '' : $zone;
        $this->resetPage();
    }

    public function filterFaculty(string $facultyCode): void
    {
        $this->selectedFaculty = ($this->selectedFaculty === $facultyCode) ? '' : $facultyCode;
        $this->resetPage();
    }

    public function filterTier(string $tier): void
    {
        $this->selectedTier = ($this->selectedTier === $tier) ? '' : $tier;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'selectedCategory', 'selectedZone', 'selectedFaculty', 'selectedTier', 'sortBy']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['category', 'seller'])
            ->where('status', 'available');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . trim($this->search) . '%')
                  ->orWhere('description', 'like', '%' . trim($this->search) . '%');
            });
        }

        if (!empty($this->selectedCategory)) {
            $query->where('category_id', $this->selectedCategory);
        }

        if (!empty($this->selectedZone)) {
            $query->where('campus_zone', $this->selectedZone);
        }

        if (!empty($this->selectedTier)) {
            $query->where('size_tier', $this->selectedTier);
        }

        if (!empty($this->selectedFaculty)) {
            $facultyCode = $this->selectedFaculty;
            $query->whereHas('seller', function ($q) use ($facultyCode) {
                match ($facultyCode) {
                    'FT' => $q->where('nim', 'like', '333%')->orWhere('campus_zone', 'Cilegon'),
                    'FEB' => $q->where('nim', 'like', '222%'),
                    'FKIP' => $q->where(function ($sub) {
                        $sub->where('nim', 'like', '777%')
                            ->orWhere('nim', 'like', '228%')
                            ->orWhere('campus_zone', 'Ciwaru');
                    }),
                    'FISIP' => $q->where('nim', 'like', '666%'),
                    'FH' => $q->where('nim', 'like', '111%'),
                    'FP' => $q->where('nim', 'like', '444%'),
                    'FK' => $q->where('nim', 'like', '555%'),
                    default => null,
                };
            });
        }

        match ($this->sortBy) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $zones = ['Cilegon', 'Sindangsari', 'Pakupatan', 'Ciwaru'];

        $faculties = [
            [
                'code' => 'FT',
                'name' => 'Fakultas Teknik (FT)',
                'campus' => 'Kampus Cilegon',
                'icon' => '',
                'description' => 'Informatika, Mesin, Elektro, Industri, Metalurgi, Kimia, Sipil',
                'bg_gradient' => 'from-blue-900 via-indigo-900 to-slate-900',
                'accent' => 'text-blue-400',
                'border' => 'border-blue-500/30',
                'featured' => true,
            ],
            [
                'code' => 'FEB',
                'name' => 'Ekonomi & Bisnis (FEB)',
                'campus' => 'Kampus Sindangsari',
                'icon' => '',
                'description' => 'Manajemen, Akuntansi, Ekonomi Pembangunan',
                'bg_gradient' => 'from-amber-900 via-yellow-950 to-slate-900',
                'accent' => 'text-amber-400',
                'border' => 'border-amber-500/30',
                'featured' => false,
            ],
            [
                'code' => 'FKIP',
                'name' => 'Keguruan & Pendidikan (FKIP)',
                'campus' => 'Kampus Ciwaru & Pakupatan',
                'icon' => '',
                'description' => 'Pendidikan Bahasa, Sains, Matematika, PGSD',
                'bg_gradient' => 'from-sky-900 via-cyan-950 to-slate-900',
                'accent' => 'text-sky-400',
                'border' => 'border-sky-500/30',
                'featured' => false,
            ],
            [
                'code' => 'FISIP',
                'name' => 'Ilmu Sosial & Politik (FISIP)',
                'campus' => 'Kampus Sindangsari',
                'icon' => '',
                'description' => 'Ilmu Komunikasi, Administrasi Publik, Pemerintahan',
                'bg_gradient' => 'from-orange-900 via-amber-950 to-slate-900',
                'accent' => 'text-orange-400',
                'border' => 'border-orange-500/30',
                'featured' => false,
            ],
            [
                'code' => 'FH',
                'name' => 'Fakultas Hukum (FH)',
                'campus' => 'Kampus Sindangsari',
                'icon' => '',
                'description' => 'Ilmu Hukum Pidana, Perdata, Tata Negara',
                'bg_gradient' => 'from-red-950 via-rose-950 to-slate-900',
                'accent' => 'text-rose-400',
                'border' => 'border-rose-500/30',
                'featured' => false,
            ],
            [
                'code' => 'FP',
                'name' => 'Fakultas Pertanian (FP)',
                'campus' => 'Kampus Sindangsari',
                'icon' => '',
                'description' => 'Agribisnis, Agroekoteknologi, Perikanan',
                'bg_gradient' => 'from-emerald-950 via-teal-950 to-slate-900',
                'accent' => 'text-emerald-400',
                'border' => 'border-emerald-500/30',
                'featured' => false,
            ],
            [
                'code' => 'FK',
                'name' => 'Fakultas Kedokteran (FK)',
                'campus' => 'Kampus Cilegon & Pakupatan',
                'icon' => '',
                'description' => 'Pendidikan Dokter, Keperawatan, Ilmu Gizi',
                'bg_gradient' => 'from-teal-950 via-cyan-950 to-slate-900',
                'accent' => 'text-teal-400',
                'border' => 'border-teal-500/30',
                'featured' => false,
            ],
        ];

        return view('livewire.product-catalog', [
            'products' => $products,
            'categories' => $categories,
            'zones' => $zones,
            'faculties' => $faculties,
            'totalActiveProducts' => Product::where('status', 'available')->count(),
        ]);
    }
}
