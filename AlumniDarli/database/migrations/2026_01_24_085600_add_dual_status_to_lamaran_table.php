<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDualStatusToLamaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lamaran', function (Blueprint $table) {
            $table->enum('status_admin', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu')->after('cv_path');
            $table->enum('status_pimpinan', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu')->after('status_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lamaran', function (Blueprint $table) {
            $table->dropColumn(['status_admin', 'status_pimpinan']);
        });
    }
}
