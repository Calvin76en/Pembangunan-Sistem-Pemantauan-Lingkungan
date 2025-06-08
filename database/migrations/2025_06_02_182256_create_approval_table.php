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
        Schema::create('approval', function (Blueprint $table) {
            $table->id('approval_id'); // Primary Key untuk tabel approval

            $table->string('approval_name'); // Nama approval (misalnya: nama yang memberikan persetujuan)
            $table->enum('approval_type', ['daily', 'monthly']); // Tipe approval (daily atau monthly)
            $table->date('approval_date'); // Tanggal approval
            $table->text('signature')->nullable(); // Kolom untuk tanda tangan
            $table->enum('status', ['approved', 'rejected'])->default('approved'); // Status approval
            $table->text('notes')->nullable(); // Kolom catatan terkait approval

            // Foreign keys untuk NIK_user, daily_report_id, dan monthly_report_id
            $table->integer('NIK_user');
            $table->foreign('NIK_user')->references('NIK_user')->on('users')->onDelete('cascade'); // Foreign key ke tabel 'users'

            $table->unsignedBigInteger('daily_report_id');
            $table->foreign('daily_report_id')->references('id')->on('daily')->onDelete('cascade'); // Foreign key ke tabel 'daily'

            $table->unsignedBigInteger('monthly_report_id');
            $table->foreign('monthly_report_id')->references('id')->on('monthly')->onDelete('cascade'); // Foreign key ke tabel 'monthly'

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval');
    }
};
