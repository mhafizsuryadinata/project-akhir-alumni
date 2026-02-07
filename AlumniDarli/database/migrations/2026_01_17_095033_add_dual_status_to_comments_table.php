<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDualStatusToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->enum('admin_status', ['pending', 'approved', 'rejected'])->default('pending')->after('parent_id');
            $table->enum('mudir_status', ['pending', 'approved', 'rejected'])->default('pending')->after('admin_status');
        });

        // Migrate data from old status to admin_status and mudir_status
        \DB::table('comments')->update([
            'admin_status' => \DB::raw('status'),
            'mudir_status' => \DB::raw('status'),
        ]);

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('parent_id');
        });

        \DB::table('comments')->update([
            'status' => \DB::raw('admin_status'),
        ]);

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['admin_status', 'mudir_status']);
        });
    }
}
