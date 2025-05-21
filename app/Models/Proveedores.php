<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'PK_Id_Proveedor';
    public $timestamps = false;

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_proveedores', 'FK_Id_Proveedor', 'FK_Id_Producto');
    }
}
