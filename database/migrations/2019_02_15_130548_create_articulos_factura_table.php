<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_factura', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('articulo_id');
            $table->unsignedInteger('factura_id');
           
            $table->integer('cantidad');
            $table->string('medida');
            $table->decimal('preciounitario',8,2);
            $table->decimal('subTotal',8,2);

            $table->timestamps();
            $table->foreign('factura_id')->references('id')->on('facturas');
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
        Schema::dropIfExists('articulos_factura');
    }
}
