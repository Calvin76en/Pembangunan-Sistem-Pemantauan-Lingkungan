<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSecondColumnInKebisinganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mengubah kolom 'second' menjadi VARCHAR atau TEXT (sesuai kebutuhan)
        Schema::table('kebisingan', function (Blueprint $table) {
            $table->string('second')->change();  // Ganti tipe kolom 'second' menjadi string
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan kolom 'second' menjadi tipe semula jika diperlukan
        Schema::table('kebisingan', function (Blueprint $table) {
            $table->json('second')->change();  // Mengembalikan ke tipe JSON jika dibutuhkan
        });
    }
}
