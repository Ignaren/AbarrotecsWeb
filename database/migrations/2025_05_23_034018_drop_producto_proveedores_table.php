<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('producto_proveedores');
    }

    public function down(): void {
        Schema::create('producto_proveedores', function ($table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->timestamps();

            $table->foreign('producto_id')->references('PK_Id_Producto')->on('producto')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('PK_Id_Proveedor')->on('proveedor')->onDelete('cascade');
        });
    }
};
