<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id');
            $table->integer('kelas_id');
            $table->string('kode_siswa')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('nama_siswa')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('email')->unique();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
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
        Schema::dropIfExists('siswas');
    }
}
