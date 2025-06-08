berikut untuk daily:
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
        Schema::create('daily', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('location_id'); // Foreign Key

            // Foreign key untuk NIK_user, mengacu ke kolom 'NIK_user' di tabel 'users'
            $table->integer('NIK_user'); 

            // Kolom status (misal: aktif, tidak aktif, selesai, dll)
            $table->enum('status', ['approved', 'rejected'])->default('approved');

            // Kolom tanggal (misal: tanggal laporan atau waktu laporan dibuat)
            $table->date('report_date'); // Kolom untuk tanggal laporan

            $table->timestamps(); // Kolom created_at dan updated_at

            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
            $table->foreign('NIK_user')->references('NIK_user')->on('users')->onDelete('cascade'); // Foreign key ke tabel 'users'


        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily');
    }
};