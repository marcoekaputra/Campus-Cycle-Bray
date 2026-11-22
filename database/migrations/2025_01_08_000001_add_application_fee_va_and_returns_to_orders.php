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
        Schema::table('orders', function (Blueprint $table) {
            // 1. Application Fee (1.5% Buyer, 1.5% Seller = 3% Platform Fee)
            $table->decimal('buyer_app_fee', 14, 2)->default(0.00)->after('shipping_fee');
            $table->decimal('seller_app_fee', 14, 2)->default(0.00)->after('buyer_app_fee');
            $table->decimal('net_seller_amount', 14, 2)->default(0.00)->after('seller_app_fee');

            // 2. Virtual Account Mobile Banking (BCA, BRI, Mandiri)
            $table->string('va_bank', 20)->nullable()->after('payment_method')->comment('bca, bri, mandiri');
            $table->string('va_number', 50)->nullable()->after('va_bank');
            $table->timestamp('va_expired_at')->nullable()->after('va_number');

            // 3. Return & Komplain System (Delivery Orders)
            $table->string('return_status', 30)->default('none')->after('notes')
                ->comment('none, requested, approved_by_seller, rejected_by_seller, approved_by_admin, completed, cancelled');
            $table->string('return_method', 20)->nullable()->after('return_status')->comment('cod, delivery');
            $table->string('return_courier', 50)->nullable()->after('return_method');
            $table->string('return_tracking_number', 100)->nullable()->after('return_courier');
            $table->decimal('return_shipping_fee', 14, 2)->default(0.00)->after('return_tracking_number');
            $table->string('return_reason')->nullable()->after('return_shipping_fee');
            $table->text('return_description')->nullable()->after('return_reason');
            $table->string('return_proof_image')->nullable()->after('return_description');
            $table->decimal('return_refund_amount', 14, 2)->nullable()->after('return_proof_image');
            $table->timestamp('return_requested_at')->nullable()->after('return_refund_amount');
            $table->timestamp('return_seller_confirmed_at')->nullable()->after('return_requested_at');
            $table->timestamp('return_admin_approved_at')->nullable()->after('return_seller_confirmed_at');
        });

        // Update database trigger to disburse net_seller_amount to seller
        DB::unprepared("DROP TRIGGER IF EXISTS trg_auto_disburse_completed_order;");

        DB::unprepared("
            CREATE TRIGGER trg_auto_disburse_completed_order
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE v_wallet_id BIGINT UNSIGNED;
                DECLARE v_current_balance DECIMAL(14, 2) DEFAULT 0.00;
                DECLARE v_disburse_amount DECIMAL(14, 2) DEFAULT 0.00;

                -- Eksekusi hanya ketika status pesanan berubah menjadi 'completed'
                IF NEW.status = 'completed' AND (OLD.status != 'completed' OR OLD.status IS NULL) THEN
                    -- Cari data wallet milik penjual (seller)
                    SELECT id, balance INTO v_wallet_id, v_current_balance
                    FROM wallets
                    WHERE user_id = NEW.seller_id
                    LIMIT 1;

                    -- Tentukan nominal pencairan (net_seller_amount atau fallback ke total_amount)
                    IF NEW.net_seller_amount > 0 THEN
                        SET v_disburse_amount = NEW.net_seller_amount;
                    ELSE
                        SET v_disburse_amount = NEW.total_amount;
                    END IF;

                    -- Jika wallet penjual tersedia di sistem
                    IF v_wallet_id IS NOT NULL THEN
                        -- 1. Tambahkan saldo pada wallet penjual
                        UPDATE wallets
                        SET balance = balance + v_disburse_amount,
                            updated_at = NOW()
                        WHERE id = v_wallet_id;

                        -- 2. Catat riwayat mutasi kredit (dana masuk) ke wallet_mutations
                        INSERT INTO wallet_mutations (
                            wallet_id,
                            order_id,
                            type,
                            amount,
                            balance_before,
                            balance_after,
                            description,
                            reference_type,
                            reference_id,
                            created_at,
                            updated_at
                        ) VALUES (
                            v_wallet_id,
                            NEW.id,
                            'credit',
                            v_disburse_amount,
                            v_current_balance,
                            v_current_balance + v_disburse_amount,
                            CONCAT('Pencairan dana pesanan #', NEW.order_number, ' (Potong Biaya Layanan 1.5%)'),
                            'order_disbursement',
                            NEW.id,
                            NOW(),
                            NOW()
                        );

                        -- 3. Perbarui status produk terkait menjadi terjual ('sold')
                        UPDATE products
                        SET status = 'sold',
                            updated_at = NOW()
                        WHERE id = NEW.product_id;
                    END IF;
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_auto_disburse_completed_order;");

        // Restore original trigger
        DB::unprepared("
            CREATE TRIGGER trg_auto_disburse_completed_order
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE v_wallet_id BIGINT UNSIGNED;
                DECLARE v_current_balance DECIMAL(14, 2) DEFAULT 0.00;

                IF NEW.status = 'completed' AND (OLD.status != 'completed' OR OLD.status IS NULL) THEN
                    SELECT id, balance INTO v_wallet_id, v_current_balance
                    FROM wallets
                    WHERE user_id = NEW.seller_id
                    LIMIT 1;

                    IF v_wallet_id IS NOT NULL THEN
                        UPDATE wallets
                        SET balance = balance + NEW.total_amount,
                            updated_at = NOW()
                        WHERE id = v_wallet_id;

                        INSERT INTO wallet_mutations (
                            wallet_id,
                            order_id,
                            type,
                            amount,
                            balance_before,
                            balance_after,
                            description,
                            reference_type,
                            reference_id,
                            created_at,
                            updated_at
                        ) VALUES (
                            v_wallet_id,
                            NEW.id,
                            'credit',
                            NEW.total_amount,
                            v_current_balance,
                            v_current_balance + NEW.total_amount,
                            CONCAT('Pencairan dana pesanan #', NEW.order_number),
                            'order_disbursement',
                            NEW.id,
                            NOW(),
                            NOW()
                        );

                        UPDATE products
                        SET status = 'sold',
                            updated_at = NOW()
                        WHERE id = NEW.product_id;
                    END IF;
                END IF;
            END;
        ");

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'buyer_app_fee',
                'seller_app_fee',
                'net_seller_amount',
                'va_bank',
                'va_number',
                'va_expired_at',
                'return_status',
                'return_method',
                'return_courier',
                'return_tracking_number',
                'return_shipping_fee',
                'return_reason',
                'return_description',
                'return_proof_image',
                'return_refund_amount',
                'return_requested_at',
                'return_seller_confirmed_at',
                'return_admin_approved_at',
            ]);
        });
    }
};
