<?php
// 2025_05_21_000005_create_cliente_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('PK_Id_Cliente');
            $table->string('Nombre', 50);
            $table->string('Email', 50)->nullable();
            $table->string('RFC', 50)->nullable();
            $table->string('Telefono', 15)->nullable();
            $table->string('Direccion', 100)->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
