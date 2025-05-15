<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKebisinganTable extends Migration
{
    public function up()
    {
        Schema::create('kebisingan', function (Blueprint $table) {
            $table->id();
            $table->float('spl_db');
            $table->json('second');  // Menyimpan data detik (120 detik per 5 detik)
            $table->unsignedBigInteger('monitoring_id'); // Foreign Key
            $table->unsignedBigInteger('location_id'); // Foreign Key
            $table->timestamps();

            $table->foreign('monitoring_id')->references('monitoring_id')->on('monitoring_types')->onDelete('cascade');
            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kebisingan');
    }
}