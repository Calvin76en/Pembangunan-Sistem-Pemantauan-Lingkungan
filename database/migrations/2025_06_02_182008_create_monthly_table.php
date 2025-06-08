<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up()
    {
        Schema::create('monthly', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('daily_id'); // Foreign Key

            $table->unsignedBigInteger('location_id'); // Foreign Key

            // Foreign key untuk NIK_user, mengacu ke kolom 'NIK_user' di tabel 'users'
            $table->integer('NIK_user'); 

            // Kolom status (misal: aktif, tidak aktif, selesai, dll)
            $table->tinyInteger('status')->default(1); // Kolom status dengan default 1 (aktif)

            // Kolom bulan (misal: bulan laporan yang dibuat, format 'YYYY-MM')
            $table->string('month'); // Kolom untuk bulan laporan, bisa menggunakan format 'YYYY-MM'

            $table->timestamps(); // Kolom created_at dan updated_at
            
            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
            $table->foreign('NIK_user')->references('NIK_user')->on('users')->onDelete('cascade'); // Foreign key ke tabel 'users'
            $table->foreign('daily_id')->references('id')->on('daily')->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly');
    }
};
