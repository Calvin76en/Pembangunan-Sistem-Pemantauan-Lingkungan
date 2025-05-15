<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirLimbahTambangTable extends Migration
{
    public function up()
    {
        Schema::create('air_limbah_tambang', function (Blueprint $table) {
            $table->id();
            $table->float('ph_inlet');
            $table->float('ph_outlet_1');
            $table->float('ph_outlet_2');
            $table->float('treatment_kapur');
            $table->float('treatment_pac');
            $table->float('treatment_tawas');
            $table->float('tss_inlet');
            $table->float('tss_outlet');
            $table->float('fe_outlet');
            $table->float('mn_outlet');
            $table->float('debit');
            $table->float('velocity');
            $table->string('keterangan');
            $table->unsignedBigInteger('monitoring_id'); // Foreign Key
            $table->unsignedBigInteger('location_id'); // Foreign Key
            $table->timestamps();

            $table->foreign('monitoring_id')->references('monitoring_id')->on('monitoring_types')->onDelete('cascade');
            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('air_limbah_tambang');
    }
}
