<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'PK_Id_Venta';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'FK_Id_Cliente', 'PK_Id_Cliente');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'FK_Id_Venta', 'PK_Id_Venta');
    }
}
