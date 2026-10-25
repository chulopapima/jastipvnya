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
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            
            // Ini kolom-kolom wajib yang dari tadi dicariin sama kodingan lain:
            $table->unsignedBigInteger('user_id');
            $table->string('nama_barang');
            $table->integer('estimasi_harga')->nullable();
            $table->string('destinasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->string('progress_status')->nullable();
            $table->integer('progress_percent')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};