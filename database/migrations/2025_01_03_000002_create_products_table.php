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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->boolean('is_negotiable')->default(true)->comment('Apakah harga bisa dinegosiasi/ditawar');
            $table->enum('condition', ['new', 'like_new', 'good', 'fair'])->default('good');
            $table->enum('status', ['available', 'reserved', 'sold', 'archived'])->default('available');
            $table->string('image_url')->nullable();
            $table->string('pickup_location')->nullable()->comment('Lokasi COD / Serah terima barang di lingkungan kampus');
            $table->timestamps();

            $table->index(['seller_id', 'status']);
            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
