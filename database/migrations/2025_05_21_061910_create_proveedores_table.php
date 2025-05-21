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
            $table->string('Nombre', 50);
            $table->string('Direccion', 100)->nullable();
            $table->string('Email', 50)->nullable();
            $table->string('Telefono', 15)->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}