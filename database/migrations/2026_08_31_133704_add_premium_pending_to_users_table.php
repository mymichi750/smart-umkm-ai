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
        Schema::table('users', function (Blueprint $table) {
            // Level premium yang sedang menunggu verifikasi admin
            $table->unsignedTinyInteger('premium_pending_level')->nullable()->after('premium_level');
            // Path file bukti pembayaran (local storage)
            $table->string('premium_proof_path')->nullable()->after('premium_pending_level');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['premium_pending_level', 'premium_proof_path']);
        });
    }
};
