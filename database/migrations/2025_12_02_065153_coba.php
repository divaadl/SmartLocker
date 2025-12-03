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
        Schema::create('lockers', function (Blueprint $table) {
        $table->id();
        $table->string('kode_loker', 5)->unique(); // contoh: "01", "02"
        $table->enum('status', ['kosong', 'terkunci', 'terbuka'])->default('kosong');
        
        $table->string('rfid')->nullable(); // RFID kartu penyewa
        $table->dateTime('waktu_selesai')->nullable(); // batas durasi sewa

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
