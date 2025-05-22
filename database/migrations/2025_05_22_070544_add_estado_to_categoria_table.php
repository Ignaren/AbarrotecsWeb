<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('categoria', function (Blueprint $table) {
        $table->string('estado')->default('activo');  // o booleano si prefieres
    });
}

public function down()
{
    Schema::table('categoria', function (Blueprint $table) {
        $table->dropColumn('estado');
    });
}

};
