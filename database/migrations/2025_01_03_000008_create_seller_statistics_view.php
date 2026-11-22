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
        DB::unprepared("
            CREATE OR REPLACE VIEW v_seller_statistics AS
            SELECT 
                u.id AS seller_id,
                u.name AS seller_name,
                u.email AS seller_email,
                u.nim AS seller_nim,
                u.campus_name AS seller_campus,
                COALESCE(w.balance, 0.00) AS current_wallet_balance,
                COUNT(DISTINCT p.id) AS total_products,
                COUNT(DISTINCT CASE WHEN p.status = 'available' THEN p.id END) AS active_products,
                COUNT(DISTINCT CASE WHEN p.status = 'sold' THEN p.id END) AS sold_products,
                COUNT(DISTINCT o.id) AS total_orders,
                COUNT(DISTINCT CASE WHEN o.status = 'completed' THEN o.id END) AS completed_orders,
                COUNT(DISTINCT CASE WHEN o.status = 'cancelled' THEN o.id END) AS cancelled_orders,
                COALESCE(SUM(CASE WHEN o.status = 'completed' THEN o.total_amount ELSE 0.00 END), 0.00) AS total_revenue
            FROM users u
            LEFT JOIN wallets w ON u.id = w.user_id
            LEFT JOIN products p ON u.id = p.seller_id
            LEFT JOIN orders o ON u.id = o.seller_id
            GROUP BY 
                u.id,
                u.name,
                u.email,
                u.nim,
                u.campus_name,
                w.balance;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS v_seller_statistics;");
    }
};
