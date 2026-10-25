<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable()->after('user_id');
            $table->integer('jumlah')->default(1)->after('estimasi_harga');
            $table->string('metode_pembayaran')->default('Transfer Bank / QRIS')->after('keterangan');
            $table->string('bukti_bayar')->nullable()->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->dropColumn(['trip_id', 'jumlah', 'metode_pembayaran', 'bukti_bayar']);
        });
    }
};