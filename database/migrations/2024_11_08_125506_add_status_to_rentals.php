<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Migration untuk menambah kolom status pada tabel rental
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('status')->default('menunggu_mulai');  // status awal
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            //
        });
    }
};
