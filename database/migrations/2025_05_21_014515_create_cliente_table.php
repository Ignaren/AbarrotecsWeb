<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('PK_Id_Cliente');
            $table->string('Nombre', 100);
            $table->string('Direccion', 150)->nullable();
            $table->string('Telefono', 20)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
