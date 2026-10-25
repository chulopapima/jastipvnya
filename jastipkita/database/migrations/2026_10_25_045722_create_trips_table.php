<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users (Jastiper)
            $table->string('destinasi'); // Contoh: Bangkok, Jepang, Korea
            $table->date('tanggal_berangkat');
            $table->date('tanggal_pulang');
            $table->decimal('estimasi_fee', 12, 2); // Harga/fee jastip
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // Untuk upload foto trip/banner
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};