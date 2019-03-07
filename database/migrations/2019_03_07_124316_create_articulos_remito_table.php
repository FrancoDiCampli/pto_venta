<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosRemitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_remito', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('articulo_id');
            $table->unsignedInteger('remito_id');

            $table->integer('lote');
            $table->integer('cantidad');
            $table->string('medida');
            $table->decimal('costo');
            $table->decimal('subtotal');

            $table->timestamps();
            $table->foreign('remito_id')->references('id')->on('remitos');
            $table->foreign('articulo_id')->references('id')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos_remito');
    }
}
