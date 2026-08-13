<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Nonaktifkan produk yang stoknya sudah habis sebelum aturan otomatis diterapkan.
     */
    public function up(): void
    {
        DB::table('products')
            ->where('stock', '<=', 0)
            ->update(['active' => false]);
    }

    /**
     * Status sebelumnya tidak dapat diketahui dengan aman.
     */
    public function down(): void
    {
        // Tidak ada perubahan balik agar produk yang sebelumnya memang nonaktif tetap aman.
    }
};
