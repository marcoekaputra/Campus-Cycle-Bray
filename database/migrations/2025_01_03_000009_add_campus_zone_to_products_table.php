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
        Schema::table('products', function (Blueprint $table) {
            $table->enum('campus_zone', ['Cilegon', 'Sindangsari', 'Pakupatan', 'Ciwaru'])
                ->default('Sindangsari')
                ->after('status')
                ->comment('Zona Kampus Untirta untuk lokasi serah terima / COD');
            $table->string('condition_grade', 50)
                ->nullable()
                ->after('condition')
                ->comment('Grade kondisi: e.g. Grade A (Mulus), Grade B (Normal)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['campus_zone', 'condition_grade']);
        });
    }
};
