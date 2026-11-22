<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom role & is_suspended pada tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'campus_admin', 'student'])
                ->default('student')
                ->after('campus_zone')
                ->comment('Peran pengguna: super_admin, campus_admin, student');
            $table->boolean('is_suspended')
                ->default(false)
                ->after('role')
                ->comment('Status pembekuan akun pengguna oleh admin');
        });

        // 2. Tambah flag moderasi & takedown pada tabel products
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_flagged')
                ->default(false)
                ->after('status')
                ->comment('Apakah produk ditandai melanggar atau perlu moderasi');
            $table->text('takedown_reason')
                ->nullable()
                ->after('is_flagged')
                ->comment('Alasan takedown/pembekuan produk oleh admin');
        });

        // 3. Buat tabel disputes (Pusat Resolusi / Sengketa Transaksi)
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('complainant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('respondent_id')->constrained('users')->cascadeOnDelete();
            $table->string('reason');
            $table->text('description');
            $table->string('proof_image')->nullable();
            $table->enum('status', ['open', 'under_review', 'resolved_refund_buyer', 'resolved_release_seller', 'rejected'])
                ->default('open')
                ->comment('open: Baru diajukan, under_review: Sedang mediasi, resolved_refund_buyer: Uang kembali ke pembeli, resolved_release_seller: Dana diteruskan ke penjual, rejected: Ditolak');
            $table->text('resolution_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'order_id']);
        });

        // 4. Buat tabel withdrawals (Pusat Pencairan Saldo Dompet Mahasiswa)
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('bank_name', 50)->comment('BCA, Mandiri, BNI, BRI, Seabank, GoPay, Dana');
            $table->string('account_number', 50);
            $table->string('account_holder', 100);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->string('proof_document')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'user_id']);
        });

        // 5. Inisialisasi peran akun administrator yang sudah ada
        DB::table('users')->where('email', 'admin@campuscycle.id')->update(['role' => 'super_admin']);
        DB::table('users')->where('email', 'admin@untirta.ac.id')->update(['role' => 'campus_admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
        Schema::dropIfExists('disputes');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_flagged', 'takedown_reason']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_suspended']);
        });
    }
};

