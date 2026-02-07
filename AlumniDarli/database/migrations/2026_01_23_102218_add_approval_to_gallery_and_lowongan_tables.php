<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalToGalleryAndLowonganTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('album', function (Blueprint $table) {
            $table->string('status_admin')->default('pending')->after('cover');
            $table->string('status_pimpinan')->default('pending')->after('status_admin');
        });

        Schema::table('galeri', function (Blueprint $table) {
            $table->string('status_admin')->default('pending')->after('tipe');
            $table->string('status_pimpinan')->default('pending')->after('status_admin');
        });

        Schema::table('lowongan', function (Blueprint $table) {
            $table->string('status_admin')->default('pending')->after('status');
            $table->string('status_pimpinan')->default('pending')->after('status_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('album', function (Blueprint $table) {
            $table->dropColumn(['status_admin', 'status_pimpinan']);
        });

        Schema::table('galeri', function (Blueprint $table) {
            $table->dropColumn(['status_admin', 'status_pimpinan']);
        });

        Schema::table('lowongan', function (Blueprint $table) {
            $table->dropColumn(['status_admin', 'status_pimpinan']);
        });
    }
}
