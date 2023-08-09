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
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('siswa_id')->nullable()->constrained('siswas')->onUpdate('cascade')->onDelete('cascade');
            // $table->string('kode_pembayaran');
            $table->enum('status', ['unpaid', 'paid']);
            $table->string('tanggal_bayar');
            $table->string('bulan_bayar');
            $table->string('tahun_bayar');
            $table->bigInteger('jumlah_bayar');
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
