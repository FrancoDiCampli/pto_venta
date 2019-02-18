<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('nombre');
           
            $table->string('doc');
            $table->string('direccion');
            $table->string('cp')->nullable();

            
            $table->boolean('percibeiva')->default(false);
            $table->boolean('percibeiibb')->default(false);
            $table->boolean('enviarcomprobante')->default(false);
            $table->boolean('estado')->default(false);

            $table->string('condicionpago');
            $table->string('mail')->nullable();
            $table->string('telefono');
            
            $table->text('foto')->nullable();

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
        Schema::dropIfExists('clientes');
    }
}
