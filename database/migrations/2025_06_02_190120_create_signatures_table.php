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
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id'); // Foreign key
            $table->string('name');
            $table->date('date');
            $table->string('company_position');
            $table->text('signature_data'); // Base64 or image URL
            $table->timestamps();

            // Definisikan foreign key untuk 'report_id' yang mengacu ke tabel 'daily'
            $table->foreign('report_id')->references('id')->on('daily')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
