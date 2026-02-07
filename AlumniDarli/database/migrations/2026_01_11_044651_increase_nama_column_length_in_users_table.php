<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseNamaColumnLengthInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menggunakan Raw SQL karena doctrine/dbal mungkin tidak terpasang
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE users MODIFY COLUMN nama VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Tidak mengembalikan ke ukuran semula untuk menghindari data loss jika sudah ada nama panjang
    }
}
