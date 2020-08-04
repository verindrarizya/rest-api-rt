<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKesejahteraanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kesejahteraan', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('penghasilan', [1, 2, 3, 4]);
            $table->enum('flag_phk', [0, 1]);
            $table->enum('flag_usaha', [0, 1]);
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
        Schema::dropIfExists('kesejahteraan');
    }
}
