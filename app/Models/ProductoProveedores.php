<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoProveedores extends Model
{
    protected $table = 'producto_proveedores';
    protected $primaryKey = 'PK_Id_Producto_Proveedor';
    public $timestamps = false;

    protected $fillable = ['Cantidad', 'Precio_Unitario', 'FK_Id_Proveedor', 'FK_Id_Producto'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'FK_Id_Proveedor', 'PK_Id_Proveedor');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'FK_Id_Producto', 'PK_Id_Producto');
    }
}
