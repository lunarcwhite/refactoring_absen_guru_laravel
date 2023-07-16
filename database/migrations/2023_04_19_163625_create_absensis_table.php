<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->date('tanggal_absensi')->nullable();
            $table->string('photo_absen_masuk', 255)->nullable();
            $table->string('photo_absen_pulang', 255)->nullable();
            $table->string('lokasi_absen_masuk', 50)->nullable();
            $table->string('lokasi_absen_pulang', 50)->nullable();
            $table->char('status_absensi', 1)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
