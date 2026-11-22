<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Buat Akun Administrator CampusCycle
        $admin = User::updateOrCreate(
            ['email' => 'admin@campuscycle.id'],
            [
                'nim' => '0000000001',
                'name' => 'Administrator CampusCycle',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Cilegon',
                'role' => 'super_admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $adminUntirta = User::updateOrCreate(
            ['email' => 'admin@untirta.ac.id'],
            [
                'nim' => '3330000001',
                'name' => 'Admin Universitas Untirta',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Sindangsari',
                'role' => 'campus_admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // 1. Buat Akun Mahasiswa Untirta Multi-Fakultas
        $sellerCilegon = User::updateOrCreate(
            ['email' => 'aditya.ft@untirta.ac.id'],
            [
                'nim' => '3337220001',
                'name' => 'Aditya Pratama (FT Cilegon)',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Cilegon',
                'password' => Hash::make('password123'),
            ]
        );

        $sellerSindangsari = User::updateOrCreate(
            ['email' => 'nadia.fisip@untirta.ac.id'],
            [
                'nim' => '6661220002',
                'name' => 'Nadia Salsabila (FISIP Sindangsari)',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Sindangsari',
                'password' => Hash::make('password123'),
            ]
        );

        $sellerFeb = User::updateOrCreate(
            ['email' => 'rizky.feb@untirta.ac.id'],
            [
                'nim' => '2221220004',
                'name' => 'Rizky Alamsyah (FEB Sindangsari)',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Sindangsari',
                'password' => Hash::make('password123'),
            ]
        );

        $sellerPakupatan = User::updateOrCreate(
            ['email' => 'dimas.fkip@untirta.ac.id'],
            [
                'nim' => '2281220003',
                'name' => 'Dimas Arya (FKIP Pakupatan)',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Pakupatan',
                'password' => Hash::make('password123'),
            ]
        );

        $sellerFk = User::updateOrCreate(
            ['email' => 'sarah.fk@untirta.ac.id'],
            [
                'nim' => '5551220005',
                'name' => 'Sarah Nabila (FK Kedokteran)',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Cilegon',
                'password' => Hash::make('password123'),
            ]
        );

        $sellerFh = User::updateOrCreate(
            ['email' => 'fajar.fh@untirta.ac.id'],
            [
                'nim' => '1111220006',
                'name' => 'Fajar Ramadhan (FH Hukum)',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Sindangsari',
                'password' => Hash::make('password123'),
            ]
        );

        $sellerFp = User::updateOrCreate(
            ['email' => 'bima.fp@untirta.ac.id'],
            [
                'nim' => '4441220007',
                'name' => 'Bima Pangestu (FP Pertanian)',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Sindangsari',
                'password' => Hash::make('password123'),
            ]
        );

        $marco = User::updateOrCreate(
            ['nim' => '3337240067'],
            [
                'email' => 'marco.naibaho@untirta.ac.id',
                'name' => 'Marco Eka Putra Naibaho',
                'campus_name' => 'Universitas Sultan Ageng Tirtayasa',
                'campus_zone' => 'Cilegon',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]
        );

        // Pastikan setiap user memiliki wallet aktif dengan saldo awal untuk pengujian
        $allUsers = [$admin, $adminUntirta, $sellerCilegon, $sellerSindangsari, $sellerFeb, $sellerPakupatan, $sellerFk, $sellerFh, $sellerFp, $marco];
        foreach ($allUsers as $u) {
            \App\Models\Wallet::firstOrCreate(
                ['user_id' => $u->id],
                ['balance' => 500000.00, 'status' => 'active']
            );
        }

        // 2. Buat Kategori Barang Kampus
        $categories = [
            [
                'name' => 'Buku & Diktat Kuliah',
                'slug' => 'buku-diktat-kuliah',
                'description' => 'Buku teks referensi, modul praktikum, dan catatan kuliah Untirta',
                'icon' => 'book-open',
            ],
            [
                'name' => 'Elektronik & Gadget',
                'slug' => 'elektronik-gadget',
                'description' => 'Laptop, monitor, mouse, keyboard, dan perangkat penunjang belajar',
                'icon' => 'device-laptop',
            ],
            [
                'name' => 'Perlengkapan Kos',
                'slug' => 'perlengkapan-kos',
                'description' => 'Lemari 4 box, dispenser, rice cooker, meja lipat, dan perabotan kosan',
                'icon' => 'home',
            ],
            [
                'name' => 'Alat Praktikum & Lab',
                'slug' => 'alat-praktikum-lab',
                'description' => 'Helm safety proyek, jas lab, kacamata safety, kalkulator saintifik',
                'icon' => 'beaker',
            ],
            [
                'name' => 'Transportasi Kampus',
                'slug' => 'transportasi-kampus',
                'description' => 'Sepeda lipat, helm gowes, dan aksesoris mobilitas antar gedung kampus',
                'icon' => 'truck',
            ],
            [
                'name' => 'Fashion & Merchandise Untirta',
                'slug' => 'fashion-merchandise-untirta',
                'description' => 'Hoodie maroon, kemeja sidang, jas almamater, dan totebag kampus',
                'icon' => 'sparkles',
            ],
        ];

        $categoryMap = [];
        foreach ($categories as $cat) {
            $created = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
            $categoryMap[$cat['slug']] = $created->id;
        }

        // 3. Daftar 20 Produk Dummy Realistis Mahasiswa dengan Foto Asli
        $dummyProducts = [
            // 1. LEMARI PAKAIAN 4 BOX
            [
                'seller_id' => $sellerSindangsari->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Lemari Pakaian Portable 4 Box Modular Kosan (Kondisi Sangat Mulus)',
                'slug' => 'lemari-pakaian-portable-4-box-modular-kosan',
                'description' => 'Lemari pakaian plastik modular 4 susun andalan anak kosan sekitar kampus Untirta Sindangsari. Rangka besi kokoh, pintu transparan magnetik rapat anti-debu dan kecoa, muat banyak baju gantung & lipat. Dijual karena mau pindah kontrakan setelah wisuda.',
                'price' => 165000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade S (Mulus Bersih & Lengkap Part)',
                'size_tier' => 'bulky',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Kosan Sekitar Gerbang Utama Untirta Sindangsari',
                'image_url' => '/images/products/lemari-4box.jpg',
            ],

            // 2. HELM SAFETY PROYEK FT UNTIRTA
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['alat-praktikum-lab'],
                'title' => 'Helm Safety Proyek SNI FT Untirta Kuning + Rompi Lapangan',
                'slug' => 'helm-safety-proyek-sni-ft-untirta-kuning',
                'description' => 'Helm proyek resmi standar SNI K3 warna kuning untuk praktikum lapangan Teknik Sipil, Mesin, dan Industri FT Untirta Cilegon. Sudah ada inner strap putar pengatur ukuran kepala dan bonus rompi reflektor hijau scotlite.',
                'price' => 75000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade A (Standar SNI Tanpa Retak)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Gedung Laboratorium Terpadu COE FT Untirta Cilegon',
                'image_url' => '/images/products/helm-proyek-ft.jpg',
            ],

            // 3. KALKULATOR SAINTIFIK CASIO FX-991EX
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['alat-praktikum-lab'],
                'title' => 'Kalkulator Saintifik Casio FX-991EX Classwiz Asli FT Untirta',
                'slug' => 'kalkulator-saintifik-casio-fx-991ex-classwiz-asli',
                'description' => 'Kalkulator wajib untuk ujian dan tugas mahasiswa Teknik Sipil, Mesin, Elektro, Industri, dan Kimia FT Untirta. Layar resolusi tinggi, 552 fungsi matriks/vektor/integral, solar dual power baterai sangat awet. Kondisi tombol prima tidak ada macet.',
                'price' => 195000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade A (Original & Baterai Awet)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Gedung Jurusan Elektro FT Untirta Cilegon',
                'image_url' => '/images/products/kalkulator-casio.jpg',
            ],

            // 4. BUKU KALKULUS PURCELL
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['buku-diktat-kuliah'],
                'title' => 'Kalkulus Edisi 9 Jilid 1 & 2 - Dale Varberg & Edwin Purcell (Sampul Mika)',
                'slug' => 'kalkulus-edisi-9-dale-varberg-purcell',
                'description' => 'Buku teks utama kalkulus semester 1 & 2 untuk jurusan Teknik & FMIPA Untirta. Kondisi masih sangat mulus, bersampul mika rapi, tidak ada coretan pulpen mengganggu atau halaman sobek. Sangat menghemat ketimbang beli baru di toko buku.',
                'price' => 65000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade A (Mulus Bersampul Mika)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Kantin FT Untirta Cilegon / Gedung COE',
                'image_url' => '/images/products/buku-kalkulus.jpg',
            ],

            // 5. BUKU FISIKA DASAR HALLIDAY RESNICK
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['buku-diktat-kuliah'],
                'title' => 'Fisika Dasar Edisi 10 - Halliday Resnick Walker (Bahasa Indonesia)',
                'slug' => 'fisika-dasar-edisi-10-halliday-resnick-walker',
                'description' => 'Buku rujukan utama praktikum dan kuliah Fisika Dasar I & II Fakultas Teknik Untirta. Membahas mekanika, termodinamika, gelombang, medan elektromagnetik lengkap dengan contoh soal ujian semester.',
                'price' => 80000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade A- (Lengkap Tanpa Halaman Hilang)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Perpustakaan FT Untirta Cilegon',
                'image_url' => '/images/products/buku-fisika.jpg',
            ],

            // 6. JAS LAB UNTIRTA + GOGGLES
            [
                'seller_id' => $sellerFk->id,
                'category_id' => $categoryMap['alat-praktikum-lab'],
                'title' => 'Jas Lab Untirta Katun Drill Tebal (Size L) + Safety Goggles Anti-Fog',
                'slug' => 'jas-lab-untirta-katun-tebal-size-l-safety-goggles',
                'description' => 'Jas laboratorium resmi warna putih bahan drill tebal standar praktikum Kimia, Biologi, dan Kedokteran Untirta. Sudah dicuci laundry higienis, kancing lengkap, bonus kacamata safety google bening anti-fog.',
                'price' => 55000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade A (Sudah Laundry & Bersih)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Lobby Gedung D Laboratorium Terpadu',
                'image_url' => '/images/products/jas-lab.jpg',
            ],

            // 7. RICE COOKER MINI ANAK KOS MIYAKO
            [
                'seller_id' => $sellerSindangsari->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Rice Cooker Mini Miyako 0.6L Hemat Listrik 300W Anak Kosan',
                'slug' => 'rice-cooker-mini-miyako-06l-anak-kosan',
                'description' => 'Rice cooker mungil 0.6 Liter pas untuk 1-2 porsi makan anak kos. Panci teflon anti lengket mulus tidak baret parah, fungsi masak dan warm normal 100%. Daya listrik rendah 300W tidak jepret di meteran kosan.',
                'price' => 110000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade A (Fungsi Normal & Kabel Utuh)',
                'size_tier' => 'medium',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Depan Rektorat Untirta Sindangsari',
                'image_url' => '/images/products/rice-cooker.jpg',
            ],

            // 8. KIPAS ANGIN MEJA COSMOS 12 INCH
            [
                'seller_id' => $sellerSindangsari->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Kipas Angin Meja Meja Cosmos 12 Inch 3 Speed Angin Kencang Dingin',
                'slug' => 'kipas-angin-meja-cosmos-12-inch-3-speed',
                'description' => 'Penyelamat hawa panas kamar kosan Serang & Cilegon. Putaran baling-baling kencang, osilasi kiri-kanan lancar senyap tanpa suara berisik. Kabel power panjang dan tombol kecepatan berfungsi baik.',
                'price' => 95000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade A- (Angin Kencang Bersih)',
                'size_tier' => 'medium',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Kosan Sekitar Gerbang B Untirta Sindangsari',
                'image_url' => '/images/products/kipas-angin.jpg',
            ],

            // 9. MONITOR LED LG 24 INCH FULL HD IPS
            [
                'seller_id' => $sellerFeb->id,
                'category_id' => $categoryMap['elektronik-gadget'],
                'title' => 'Monitor LED LG 24 Inch IPS Full HD (75Hz FreeSync) Box Lengkap HDMI',
                'slug' => 'monitor-led-lg-24-inch-ips-full-hd',
                'description' => 'Sangat cocok untuk coding skripsi, riset jurnal, analisis data FEB, dan multitasking tugas kuliah. Panel IPS warna tajam akurat, port HDMI & VGA lancar, no dead-pixel. Lengkap dengan kabel power, adaptor, dan kardus original.',
                'price' => 850000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade S (Mulus Box Lengkap)',
                'size_tier' => 'medium',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Perpustakaan Pusat Untirta Sindangsari',
                'image_url' => '/images/products/monitor-lg.jpg',
            ],

            // 10. MEJA LIPAT LESEHAN LAPTOP
            [
                'seller_id' => $sellerPakupatan->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Meja Lipat Lesehan Laptop Kayu Mahoni Kokoh + Cup Holder & Slot Tablet',
                'slug' => 'meja-lipat-lesehan-laptop-kayu-mahoni',
                'description' => 'Meja lipat kokoh untuk belajar di kamar kosan. Dilengkapi lubang cup holder minum dan slot penyangga tablet/smartphone. Kaki besi dilapisi karet anti selip, praktis dilipat saat tidak dipakai.',
                'price' => 45000.00,
                'is_negotiable' => false,
                'condition' => 'good',
                'condition_grade' => 'Grade A- (Kokoh Bebas Rayap)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Pakupatan',
                'pickup_location' => 'Halte Untirta Pakupatan Serang',
                'image_url' => '/images/products/meja-lipat.jpg',
            ],

            // 11. KASUR BUSA LIPAT INOAC KOSAN
            [
                'seller_id' => $sellerSindangsari->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Kasur Busa Lipat Inoac Single 90x200cm Tebal 10cm Empuk Nyaman',
                'slug' => 'kasur-busa-lipat-inoac-single-90x200cm',
                'description' => 'Kasur busa lipat merk Inoac asli density tinggi anti-kempes. Sangat empuk untuk tidur nyenyak setelah seharian kuliah praktikum. Sarung resleting bisa dilepas dan dicuci. Dijual karena kamar kosan baru sudah full furnished.',
                'price' => 220000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade A (Busa Padat Tidak Amblas)',
                'size_tier' => 'bulky',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Kosan Putri Sindangsari (Bisa Bantu Gotong ke Mobil/Motor)',
                'image_url' => '/images/products/kasur-lipat.jpg',
            ],

            // 12. SEPEDA LIPAT POLYGON URBANO 3
            [
                'seller_id' => $sellerFeb->id,
                'category_id' => $categoryMap['transportasi-kampus'],
                'title' => 'Sepeda Lipat Polygon Urbano 3 - Transportasi Mahasiswa Untirta',
                'slug' => 'sepeda-lipat-polygon-urbano-3-transportasi-kampus',
                'description' => 'Sangat praktis untuk gowes keliling luasnya kampus Untirta Sindangsari dari gedung Rektorat ke FEB, FISIP, dan Perpustakaan. Shifter 7 speed responsif, rem pakem, ban masih tebal siap pakai tanpa perlu servis.',
                'price' => 1450000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade B+ (Siap Gowes Harian)',
                'size_tier' => 'bulky',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Parkiran Rektorat Untirta Sindangsari',
                'image_url' => '/images/products/sepeda-lipat.jpg',
            ],

            // 13. TEKO LISTRIK STAINLESS 1.5L
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Teko Listrik Pemanas Air Stainless Steel 1.5L Auto Off Cepat Mendidih',
                'slug' => 'teko-listrik-pemanas-air-stainless-15l',
                'description' => 'Teko listrik andalan anak kosan saat begadang tugas akhir. Mendidihkan air dalam waktu 3 menit untuk seduh kopi, teh, atau mie instan. Fitur auto-off otomatis mati saat air mendidih sehingga aman dari bahaya konslet.',
                'price' => 65000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade A (Stainless Bersih Berfungsi Normal)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Kantin FT Cilegon / Gedung COE',
                'image_url' => '/images/products/teko-listrik.jpg',
            ],

            // 14. RAK SEPATU STAINLESS SUSUN 4
            [
                'seller_id' => $sellerPakupatan->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Rak Sepatu Sandal Stainless Steel Susun 4 Tingkat Muat 12 Pasang',
                'slug' => 'rak-sepatu-sandal-stainless-susun-4',
                'description' => 'Rak sepatu susun 4 tingkat rangka pipa stainless kokoh tidak berkarat. Bikin lorong depan kamar kosan jadi rapi tertata. Muat hingga 12 pasang sepatu kuliah dan sandal.',
                'price' => 40000.00,
                'is_negotiable' => false,
                'condition' => 'good',
                'condition_grade' => 'Grade A- (Pipa Kokoh Lengkap Sambungan)',
                'size_tier' => 'medium',
                'status' => 'available',
                'campus_zone' => 'Pakupatan',
                'pickup_location' => 'Depan Kampus Untirta Pakupatan',
                'image_url' => '/images/products/rak-sepatu.jpg',
            ],

            // 15. MOUSE WIRELESS LOGITECH M220
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['elektronik-gadget'],
                'title' => 'Mouse Wireless Logitech M220 Silent Click Asli (Baterai Awet 18 Bulan)',
                'slug' => 'mouse-wireless-logitech-m220-silent-click',
                'description' => 'Mouse original Logitech dengan teknologi Silent Click, tidak berisik saat dipakai ngerjain tugas di perpustakaan atau ruang belajar. Dongle nano USB mulus plug-and-play, bonus baterai AA alkaline baru.',
                'price' => 85000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade S (Original & Mulus Tanpa Minus)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Gedung Jurusan Informatika FT Untirta',
                'image_url' => '/images/products/mouse-logitech.jpg',
            ],

            // 16. KEYBOARD MECHANICAL RK61
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['elektronik-gadget'],
                'title' => 'Keyboard Mechanical Royal Kludge RK61 Wireless Bluetooth & Type-C',
                'slug' => 'keyboard-mechanical-royal-kludge-rk61',
                'description' => 'Keyboard 60% compact favorit mahasiswa teknik informatika. Dilengkapi switch tactile empuk untuk coding santai, koneksi triple mode (Bluetooth 5.0, 2.4Ghz dongle, dan kabel Type-C). Lampu RGB warna-warni dinamis.',
                'price' => 290000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade A+ (Semua Keycap & Switch Normal)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Lab Komputer FT Untirta Cilegon',
                'image_url' => '/images/products/keyboard-mechanical.jpg',
            ],

            // 17. HOODIE MAROON UNTIRTA JAWARA
            [
                'seller_id' => $sellerPakupatan->id,
                'category_id' => $categoryMap['fashion-merchandise-untirta'],
                'title' => 'Hoodie Maroon Edition Untirta Jawara (Size XL) Katun Fleece Tebal',
                'slug' => 'hoodie-maroon-edition-untirta-jawara-size-xl',
                'description' => 'Merchandise resmi kebanggaan mahasiswa Untirta. Bahan cotton fleece tebal dan hangat untuk kuliah pagi di lab ber-AC. Warna maroon solid tidak luntur, bordir logo Untirta rapi dan berwibawa.',
                'price' => 125000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade A (Jarang Dipakai & Warna Pekat)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Ciwaru',
                'pickup_location' => 'Kampus Untirta Ciwaru / Sekitar Alun-Alun Serang',
                'image_url' => '/images/products/hoodie-untirta.jpg',
            ],

            // 18. KEMEJA PUTIH & CELANA HITAM SIDANG
            [
                'seller_id' => $sellerFh->id,
                'category_id' => $categoryMap['fashion-merchandise-untirta'],
                'title' => 'Setelan Kemeja Putih Formal Katun + Celana Bahan Hitam Sidang Skripsi (Size L)',
                'slug' => 'setelan-kemeja-putih-celana-hitam-sidang-skripsi',
                'description' => 'Pakaian wajib mahasiswa untuk sidang proposal, seminar hasil, dan sidang skripsi / yudisium. Kemeja putih katun tidak terawang, celana bahan wool hitam slim fit rapi. Hanya dipakai sekali saat wisuda.',
                'price' => 90000.00,
                'is_negotiable' => true,
                'condition' => 'like_new',
                'condition_grade' => 'Grade S (Hanya Dipakai 1x Sidang)',
                'size_tier' => 'small',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Gedung Fakultas Hukum Untirta Sindangsari',
                'image_url' => '/images/products/kemeja-sidang.jpg',
            ],

            // 19. PENGGARIS T-SQUARE & ALAT GAMBAR TEKNIK
            [
                'seller_id' => $sellerCilegon->id,
                'category_id' => $categoryMap['alat-praktikum-lab'],
                'title' => 'Penggaris T-Square Akrilik 80cm + Meja Gambar & Tabung Gambar Drafting FT',
                'slug' => 'penggaris-t-square-80cm-tabung-gambar-teknik',
                'description' => 'Paket alat gambar teknik lengkap untuk mahasiswa Teknik Sipil, Mesin, dan Arsitektur Untirta Cilegon. Sudah termasuk penggaris T-Square akrilik presisi 80cm, tabung gambar drafting anti-air, dan sepasang segitiga rotring.',
                'price' => 85000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade A (Presisi Tanpa Sompal)',
                'size_tier' => 'medium',
                'status' => 'available',
                'campus_zone' => 'Cilegon',
                'pickup_location' => 'Studio Gambar Teknik Gedung B FT Untirta',
                'image_url' => '/images/products/t-square-drawing.jpg',
            ],

            // 20. DISPENSER AIR KOSAN MAHASISWA
            [
                'seller_id' => $sellerSindangsari->id,
                'category_id' => $categoryMap['perlengkapan-kos'],
                'title' => 'Dispenser Air Minum Galon Atas Miyako Hot & Normal Hemat Listrik',
                'slug' => 'dispenser-air-minum-galon-atas-miyako',
                'description' => 'Dispenser air standing galon atas warna putih bersih. Kran panas berfungsi sangat baik untuk seduh kopi/mie instan saat begadang tugas akhir. Hemat daya, tangki stainless anti karat, bonus galon kosong.',
                'price' => 135000.00,
                'is_negotiable' => true,
                'condition' => 'good',
                'condition_grade' => 'Grade A (Fungsi Normal 100%)',
                'size_tier' => 'medium',
                'status' => 'available',
                'campus_zone' => 'Sindangsari',
                'pickup_location' => 'Indomaret Point Sindangsari Serang',
                'image_url' => '/images/products/dispenser-kosan.jpg',
            ],
        ];

        foreach ($dummyProducts as $productData) {
            Product::updateOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );
        }
    }
}
