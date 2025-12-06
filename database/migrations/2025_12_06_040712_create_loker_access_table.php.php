<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('loker_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loker_id');
            $table->unsignedBigInteger('card_id');
            $table->string('kode_akses');
            $table->dateTime('awal_sewa');
            $table->dateTime('akhir_sewa')->nullable();
            $table->enum('status', ['aktif', 'expired', 'selesai'])->default('aktif');
            $table->timestamps();

            $table->foreign('loker_id')->references('id')->on('lokers')->onDelete('cascade');
            $table->foreign('card_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('loker_access');
    }

};
