<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('request_items', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('metode_pembayaran')->default('Transfer Bank / QRIS');
            $table->string('bukti_bayar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('request_items', function (Blueprint $table) {
            $table->dropColumn(['trip_id', 'jumlah', 'metode_pembayaran', 'bukti_bayar']);
        });
    }
};