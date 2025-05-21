<?php
// 2025_05_21_000001_create_categoria_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaTable extends Migration
{
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('PK_Id_Categoria');
            $table->string('Nombre', 50);
            $table->string('Descripcion', 50)->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categoria');
    }
}
