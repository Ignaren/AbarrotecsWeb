<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEliminadoToCategoriaTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('categoria', 'Eliminado')) {
            Schema::table('categoria', function (Blueprint $table) {
                $table->boolean('Eliminado')->default(0);
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('categoria', 'Eliminado')) {
            Schema::table('categoria', function (Blueprint $table) {
                $table->dropColumn('Eliminado');
            });
        }
    }
}
