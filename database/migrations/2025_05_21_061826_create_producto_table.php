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
            $table->string('Nombre', 50);
            $table->string('Descripcion', 50)->nullable();
            $table->integer('Stock_Minimo');
            $table->integer('Existencia');
            $table->date('Fecha_Entrada');
            $table->date('Fecha_Caducidad')->nullable();
            $table->decimal('Precio', 10, 2);
            $table->unsignedInteger('FK_Id_Categoria');
            $table->foreign('FK_Id_Categoria')->references('PK_Id_Categoria')->on('categoria')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}