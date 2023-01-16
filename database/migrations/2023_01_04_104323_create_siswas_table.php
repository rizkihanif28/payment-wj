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
            $table->string('kode_siswa')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('nama_siswa')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('email')->unique();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
