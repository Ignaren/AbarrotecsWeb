<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('PK_Id_Venta');
            $table->unsignedInteger('FK_Id_Cliente');
            $table->date('Fecha');

            $table->foreign('FK_Id_Cliente')->references('PK_Id_Cliente')->on('cliente')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
