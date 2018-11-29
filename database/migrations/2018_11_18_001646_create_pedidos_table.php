<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *-me
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcomida')->unsigned();
            $table->string('codigo', 50)->nullable();
            $table->integer('numero_mesa');
            $table->integer('cantidad_platos');
            $table->dateTime('fecha_hora');
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idcomida')->references('id')->on('comidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
