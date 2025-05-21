<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('PK_Id_Producto');
            $table->string('Nombre', 100);
            $table->string('Descripcion', 150)->nullable();
            $table->unsignedInteger('FK_Id_Categoria');
            $table->decimal('Precio', 10, 2);

            $table->foreign('FK_Id_Categoria')->references('PK_Id_Categoria')->on('categoria')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
