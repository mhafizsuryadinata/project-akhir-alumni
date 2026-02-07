<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLowonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('perusahaan');
            $table->string('lokasi');
            $table->enum('tipe_pekerjaan', ['Full Time', 'Part Time', 'Freelance', 'Contract', 'Internship']);
            $table->enum('level', ['Entry Level', 'Mid Level', 'Senior Level', 'Manager', 'Director']);
            $table->text('deskripsi');
            $table->text('kualifikasi');
            $table->text('benefit')->nullable();
            $table->string('gaji_min')->nullable();
            $table->string('gaji_max')->nullable();
            $table->string('logo_perusahaan')->nullable();
            $table->string('email_kontak');
            $table->string('website')->nullable();
            $table->date('tanggal_tutup');
            $table->enum('status', ['Aktif', 'Ditutup', 'Draft'])->default('Aktif');
            $table->unsignedInteger('posted_by')->nullable();
            $table->timestamps();
            
            // Foreign key jika ingin relasi dengan user
            // $table->foreign('posted_by')->references('id_user')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lowongan');
    }
}
