<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Trigger pembuatan wallet otomatis setelah user baru terdaftar
        DB::unprepared("
            CREATE TRIGGER trg_auto_create_user_wallet
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                INSERT INTO wallets (user_id, balance, status, created_at, updated_at)
                VALUES (NEW.id, 0.00, 'active', NOW(), NOW());
            END;
        ");

        // 2. Trigger pencairan dana otomatis setelah status pesanan selesai ('completed')
        DB::unprepared("
            CREATE TRIGGER trg_auto_disburse_completed_order
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE v_wallet_id BIGINT UNSIGNED;
                DECLARE v_current_balance DECIMAL(14, 2) DEFAULT 0.00;

                -- Eksekusi hanya ketika status pesanan berubah menjadi 'completed'
                IF NEW.status = 'completed' AND (OLD.status != 'completed' OR OLD.status IS NULL) THEN
                    -- Cari data wallet milik penjual (seller)
                    SELECT id, balance INTO v_wallet_id, v_current_balance
                    FROM wallets
                    WHERE user_id = NEW.seller_id
                    LIMIT 1;

                    -- Jika wallet penjual tersedia di sistem
                    IF v_wallet_id IS NOT NULL THEN
                        -- 1. Tambahkan saldo pada wallet penjual
                        UPDATE wallets
                        SET balance = balance + NEW.total_amount,
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
                            NEW.total_amount,
                            v_current_balance,
                            v_current_balance + NEW.total_amount,
                            CONCAT('Pencairan dana pesanan #', NEW.order_number),
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
        DB::unprepared("DROP TRIGGER IF EXISTS trg_auto_create_user_wallet;");
    }
};
