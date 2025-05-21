<?php
// 2025_05_21_000004_create_producto_proveedores_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoProveedoresTable extends Migration
{
    public function up()
    {
        Schema::create('producto_proveedores', function (Blueprint $table) {
            $table->increments('PK_Id_Producto_Proveedor');
            $table->integer('Cantidad');
            $table->decimal('Precio_Unitario', 10, 2);
            $table->unsignedInteger('FK_Id_Proveedor');
            $table->unsignedInteger('FK_Id_Producto');
            $table->foreign('FK_Id_Proveedor')->references('PK_Id_Proveedor')->on('proveedores')->onDelete('cascade');
            $table->foreign('FK_Id_Producto')->references('PK_Id_Producto')->on('producto')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('producto_proveedores');
    }
}
