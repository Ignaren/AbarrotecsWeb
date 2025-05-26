<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEliminadoToCategoriaTable extends Migration
{
    public function up()
    {
        Schema::table('categoria', function (Blueprint $table) {
            $table->boolean('Eliminado')->default(false);
        });
    }

    public function down()
    {
        Schema::table('categoria', function (Blueprint $table) {
            $table->dropColumn('Eliminado');
        });
    }
}