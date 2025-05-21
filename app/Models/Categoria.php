<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'PK_Id_Categoria';
    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'FK_Id_Categoria', 'PK_Id_Categoria');
    }
}
