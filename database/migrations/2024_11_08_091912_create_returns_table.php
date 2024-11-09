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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained()->onDelete('cascade'); // Menghubungkan dengan tabel rental
            $table->date('return_date'); // Tanggal pengembalian
            $table->integer('late_days')->default(0); // Jumlah hari keterlambatan
            $table->decimal('penalty', 15, 2)->default(0); // Denda keterlambatan
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
