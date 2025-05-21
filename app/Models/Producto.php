<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'PK_Id_Producto';
    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'FK_Id_Categoria', 'PK_Id_Categoria');
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'producto_proveedores', 'FK_Id_Producto', 'FK_Id_Proveedor');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'FK_Id_Producto', 'PK_Id_Producto');
    }
}
