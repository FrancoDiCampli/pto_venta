<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numcomprobante');
            $table->string('cae');
            $table->string('fechavto');
            $table->string('codbarra');

            $table->unsignedInteger('factura_id');

            $table->timestamps();

            $table->foreign('factura_id')->references('id')->on('facturas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('afips');
    }
}
