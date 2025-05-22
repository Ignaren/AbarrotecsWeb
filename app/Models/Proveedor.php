<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores'; // Nombre de la tabla

    protected $primaryKey = 'PK_Id_Proveedor'; // Clave primaria

    public $timestamps = false; // Desactiva created_at y updated_at

    protected $fillable = [
        'Nombre',
        'Telefono',
        'Direccion',
    ];
}
