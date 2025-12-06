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
        Schema::create('lokers', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_loker')->unique();
            $table->enum('status', ['kosong', 'terpakai', 'maintenance'])->default('kosong');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokers');
    }

};
