<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran');
            $table->integer('petugas_id');
            $table->integer('siswa_id');
            $table->string('nisn')->nullable();
            $table->string('tangga_bayar')->nullable();
            $table->string('bulan_bayar')->nullable();
            $table->string('tahun_bayar')->nullable();
            $table->string('jumlah_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
}
