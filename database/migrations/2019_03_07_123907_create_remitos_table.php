<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remitos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('numremito');

            $table->date('fecha');

            $table->decimal('recargo', 8, 2);

            $table->decimal('total', 8, 2);

            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('proveedor_id')->references('id')->on('suppliers');
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
        Schema::dropIfExists('remitos');
    }
}
