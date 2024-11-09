<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Migration file untuk menambahkan constraint unique pada no_sim
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan unique constraint pada kolom no_sim
            $table->string('sim_number')->unique()->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus unique constraint jika rollback
            $table->dropUnique(['sim_number']);
        });
    }

};
