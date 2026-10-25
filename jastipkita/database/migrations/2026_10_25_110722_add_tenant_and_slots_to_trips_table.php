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
        Schema::table('trips', function (Blueprint $table) {
            // Menambahkan kolom slot maksimal kuota barang (default 50)
            if (!Schema::hasColumn('trips', 'slot_maksimal')) {
                $table->integer('slot_maksimal')->default(50);
            }
            // Menambahkan kolom tenants untuk menyimpan daftar toko (Footlocker, H&M, Uniqlo, dll dalam format JSON)
            if (!Schema::hasColumn('trips', 'tenants')) {
                $table->json('tenants')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['slot_maksimal', 'tenants']);
        });
    }
};