<?php
// app/Models/Proveedor.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'PK_Id_Proveedor';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'Direccion', 'Email', 'Telefono'];

    public function productoProveedores()
    {
        return $this->hasMany(ProductoProveedor::class, 'FK_Id_Proveedor', 'PK_Id_Proveedor');
    }
}
