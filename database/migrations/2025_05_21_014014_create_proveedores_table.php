<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('PK_Id_Proveedor');
            $table->string('Nombre', 100);
            $table->string('Direccion', 150)->nullable();
            $table->string('Telefono', 20)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
