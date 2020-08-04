<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_kk');
            $table->unsignedInteger('user_id');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('no_hp');

            // Penyakit
            $table->enum('flag_hamil', [0, 1])->default(0);
            $table->enum('flag_paru', [0, 1])->default(0);
            $table->enum('flag_jantung', [0, 1])->default(0);
            $table->enum('flag_autoimun', [0, 1])->default(0);
            $table->enum('flag_diabet', [0, 1])->default(0);
            $table->enum('flag_ginjal', [0, 1])->default(0);
            $table->enum('flag_liver', [0, 1])->default(0);
            $table->enum('flag_hipertensi', [0, 1])->default(0);
            $table->enum('flag_perokok', [0, 1])->default(0);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warga');
    }
}
