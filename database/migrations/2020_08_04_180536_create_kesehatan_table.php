<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKesehatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kesehatan', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_isi');
            $table->enum('demam', [0, 1])->default(0);
            $table->enum('batuk_kering', [0, 1])->default(0);
            $table->enum('hidung_tersumbat', [0, 1])->default(0);
            $table->enum('pilek', [0, 1])->default(0);
            $table->enum('sakit_tenggorokan', [0, 1])->default(0);
            $table->enum('diare', [0, 1])->default(0);
            $table->enum('sulit_bernafas', [0, 1])->default(0);
            $table->unsignedInteger('warga_id');

            $table->timestamps();

            $table->foreign('warga_id')->references('id')->on('warga')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kesehatan');
    }
}
