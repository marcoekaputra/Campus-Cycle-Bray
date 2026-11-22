<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel reviews untuk sistem rating & ulasan pembeli ke penjual.
     * Setiap order yang completed bisa memiliki satu review.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->comment('Nilai 1-5 bintang');
            $table->text('comment')->nullable();
            $table->timestamps();

            // Satu order hanya bisa direview sekali
            $table->unique('order_id', 'reviews_order_id_unique');
            // Index untuk query agregasi rating per penjual
            $table->index(['seller_id', 'rating'], 'reviews_seller_rating_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
