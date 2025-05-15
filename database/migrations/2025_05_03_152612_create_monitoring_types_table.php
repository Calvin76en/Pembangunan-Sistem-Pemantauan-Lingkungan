<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringTypesTable extends Migration
{
    public function up()
    {
        Schema::create('monitoring_types', function (Blueprint $table) {
            $table->id('monitoring_id');
            $table->string('monitoring_types');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monitoring_types');
    }
}
