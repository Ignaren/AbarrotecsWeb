<?php
// app/Models/Producto.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'PK_Id_Producto';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'Descripcion', 'Stock_Minimo', 'Existencia', 'Fecha_Entrada', 'Fecha_Caducidad', 'Precio', 'FK_Id_Categoria'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'FK_Id_Categoria', 'PK_Id_Categoria');
    }

    public function productoProveedores()
    {
        return $this->hasMany(ProductoProveedor::class, 'FK_Id_Producto', 'PK_Id_Producto');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'FK_Id_Producto', 'PK_Id_Producto');
    }
}
