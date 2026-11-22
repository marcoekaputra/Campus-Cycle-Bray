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
        Schema::create('wallet_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->enum('type', ['credit', 'debit'])->comment('credit: saldo bertambah, debit: saldo berkurang');
            $table->decimal('amount', 12, 2)->comment('Nominal mutasi');
            $table->decimal('balance_before', 14, 2)->comment('Saldo sebelum mutasi');
            $table->decimal('balance_after', 14, 2)->comment('Saldo setelah mutasi');
            $table->string('description', 255)->comment('Keterangan riwayat transaksi');
            $table->string('reference_type', 50)->nullable()->comment('Contoh: order_disbursement, order_payment, topup, withdrawal');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();

            $table->index(['wallet_id', 'type']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_mutations');
    }
};
