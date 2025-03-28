<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcacion extends Model
{

    protected $table = 'marcaciones';

    protected $primaryKey = 'id';

    //public $timestamps = false;

    use HasFactory;

    protected $fillable = ['empleado_id', 'tipo_marcacion'];



    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }
}
