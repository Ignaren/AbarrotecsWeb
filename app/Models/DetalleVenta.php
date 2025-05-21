<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'PK_Id_Detalle_Venta';
    public $timestamps = false;

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'FK_Id_Venta', 'PK_Id_Venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'FK_Id_Producto', 'PK_Id_Producto');
    }
}
