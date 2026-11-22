<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Perbarui Database View v_seller_statistics agar mengkalkulasi
     * average_rating dan total_reviews dari tabel reviews.
     *
     * (BasDat Lanjut: LEFT JOIN + Aggregate AVG/COUNT pada View)
     */
    public function up(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS v_seller_statistics;");

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
                COALESCE(SUM(CASE WHEN o.status = 'completed' THEN o.total_amount ELSE 0.00 END), 0.00) AS total_revenue,
                COALESCE(r_agg.average_rating, 0.00) AS average_rating,
                COALESCE(r_agg.total_reviews, 0) AS total_reviews
            FROM users u
            LEFT JOIN wallets w ON u.id = w.user_id
            LEFT JOIN products p ON u.id = p.seller_id
            LEFT JOIN orders o ON u.id = o.seller_id
            LEFT JOIN (
                SELECT 
                    seller_id,
                    ROUND(AVG(rating), 2) AS average_rating,
                    COUNT(id) AS total_reviews
                FROM reviews
                GROUP BY seller_id
            ) r_agg ON u.id = r_agg.seller_id
            GROUP BY 
                u.id,
                u.name,
                u.email,
                u.nim,
                u.campus_name,
                w.balance,
                r_agg.average_rating,
                r_agg.total_reviews;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS v_seller_statistics;");

        // Restore view asli tanpa rating
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
};
