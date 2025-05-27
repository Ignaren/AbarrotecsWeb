<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('PK_Id_Proveedor'); // Clave primaria
            $table->string('Nombre', 100);
            $table->string('Telefono', 20)->nullable();
            $table->string('Direccion', 200)->nullable();
            $table->boolean('Estado')->default(1);     // Activo por defecto
            $table->boolean('Eliminado')->default(0);  // No eliminado por defecto
            // No incluye timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
