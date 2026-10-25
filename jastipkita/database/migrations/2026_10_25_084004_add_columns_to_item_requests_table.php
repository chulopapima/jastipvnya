<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('item_requests', 'kategori')) {
                $table->string('kategori')->default('Umum')->after('nama_barang');
            }
            if (!Schema::hasColumn('item_requests', 'progress_status')) {
                $table->string('progress_status')->default('Menunggu Konfirmasi')->after('status');
            }
            if (!Schema::hasColumn('item_requests', 'progress_percent')) {
                $table->integer('progress_percent')->default(0)->after('progress_status');
            }
            if (!Schema::hasColumn('item_requests', 'bukti_bayar')) {
                $table->string('bukti_bayar')->nullable()->after('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'progress_status', 'progress_percent', 'bukti_bayar']);
        });
    }
};