<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoProveedoresTable extends Migration
{
    public function up()
    {
        Schema::create('producto_proveedores', function (Blueprint $table) {
            $table->increments('PK_Id_Producto_Proveedor');
            $table->unsignedInteger('FK_Id_Producto');
            $table->unsignedInteger('FK_Id_Proveedor');

            $table->foreign('FK_Id_Producto')->references('PK_Id_Producto')->on('producto')->onDelete('cascade');
            $table->foreign('FK_Id_Proveedor')->references('PK_Id_Proveedor')->on('proveedores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto_proveedores');
    }
}
