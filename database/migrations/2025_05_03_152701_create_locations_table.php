<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id('location_id');
            $table->string('location_name');
            $table->unsignedBigInteger('monitoring_id');  // Foreign Key
            $table->timestamps();

            // Definisikan relasi ke monitoring_types
            $table->foreign('monitoring_id')->references('monitoring_id')->on('monitoring_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
