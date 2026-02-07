<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Alumni yang berkomentar
            $table->unsignedBigInteger('target_user_id')->default(0); // 0 untuk komentar aplikasi, atau ID user tertentu
            $table->text('content'); // Isi komentar
            $table->integer('rating')->nullable(); // Rating 1-5 bintang
            $table->unsignedBigInteger('parent_id')->nullable(); // Untuk sistem reply/balasan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}