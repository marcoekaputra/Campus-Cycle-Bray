<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambahkan size_tier pada tabel products
        Schema::table('products', function (Blueprint $table) {
            $table->enum('size_tier', ['small', 'medium', 'bulky'])
                ->default('small')
                ->after('condition_grade')
                ->comment('Kategori Ukuran: small (Kecil/Reguler), medium (Sedang/Kargo), bulky (Besar/Bulky)');
        });

        // 2. Tambahkan campus_zone pada tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->enum('campus_zone', ['Cilegon', 'Sindangsari', 'Pakupatan', 'Ciwaru'])
                ->default('Sindangsari')
                ->after('campus_name')
                ->comment('Zona Kampus Utama Mahasiswa / Penjual');
        });

        // 3. Tambahkan kolom logistik dan pengiriman pada tabel orders
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('delivery_method', ['pickup', 'delivery'])
                ->default('pickup')
                ->after('payment_status')
                ->comment('pickup: Ambil Sendiri / COD, delivery: Campus Delivery (Antar-Kampus)');
            $table->enum('destination_zone', ['Cilegon', 'Sindangsari', 'Pakupatan', 'Ciwaru'])
                ->nullable()
                ->after('delivery_method');
            $table->text('destination_address')->nullable()->after('destination_zone');
            $table->decimal('shipping_fee', 12, 2)->default(0.00)->after('destination_address');
            $table->string('tracking_number', 100)
                ->nullable()
                ->after('shipping_fee')
                ->comment('Nomor Resi Kurir atau Plat Nomor Mobil Pick-up');
            // Pastikan status dan payment_method dapat menampung 'shipped' dan 'midtrans'
            $table->string('status', 50)->default('pending')->change();
            $table->string('payment_method', 50)->default('wallet')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_method',
                'destination_zone',
                'destination_address',
                'shipping_fee',
                'tracking_number',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['campus_zone']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['size_tier']);
        });
    }
};
