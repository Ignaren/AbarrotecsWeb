<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'PK_Id_Cliente';
    public $timestamps = false;

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'FK_Id_Cliente', 'PK_Id_Cliente');
    }
}
