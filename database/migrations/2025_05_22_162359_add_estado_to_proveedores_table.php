<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToProveedoresTable extends Migration
{
    public function up()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->string('Estado')->default('activo')->after('Direccion');
        });
    }

    public function down()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->dropColumn('Estado');
        });
    }
}
