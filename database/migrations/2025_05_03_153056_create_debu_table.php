<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebuTable extends Migration
{
    public function up()
    {
        Schema::create('debu', function (Blueprint $table) {
            $table->id();
            $table->enum('waktu', ['Pagi', 'Siang', 'Sore']);
            $table->string('status_debu');
            $table->unsignedBigInteger('monitoring_id'); // Foreign Key
            $table->unsignedBigInteger('location_id'); // Foreign Key
            $table->timestamps();

            $table->foreign('monitoring_id')->references('monitoring_id')->on('monitoring_types')->onDelete('cascade');
            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('debu');
    }
}
