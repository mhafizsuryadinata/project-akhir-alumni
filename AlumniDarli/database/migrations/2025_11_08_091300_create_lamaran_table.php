<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLamaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lamaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lowongan_id');
            $table->unsignedInteger('user_id');
            $table->string('cv_path')->nullable();
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
            $table->timestamps();
            
            // $table->foreign('lowongan_id')->references('id')->on('lowongan')->onDelete('cascade');
            // $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            
            // Pastikan satu user hanya bisa apply sekali per lowongan
            $table->unique(['lowongan_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lamaran');
    }
}
