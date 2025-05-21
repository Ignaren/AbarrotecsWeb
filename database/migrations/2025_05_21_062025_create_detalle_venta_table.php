<?php
// 2025_05_21_000007_create_detalle_venta_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentaTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->increments('PK_Id_Detalle_Venta');
            $table->integer('Cantidad');
            $table->decimal('Precio_Unitario', 10, 2);
            $table->unsignedInteger('FK_Id_Venta');
            $table->unsignedInteger('FK_Id_Producto');
            $table->foreign('FK_Id_Venta')->references('PK_Id_Venta')->on('ventas')->onDelete('cascade');
            $table->foreign('FK_Id_Producto')->references('PK_Id_Producto')->on('producto')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('detalle_venta');
    }
}
