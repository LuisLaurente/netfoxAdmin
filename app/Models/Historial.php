<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;
    
    protected $table = 'historial';
    
    protected $fillable = [
        'tipo_accion', 'modelo', 'modelo_id', 
        'datos_previos', 'datos_nuevos', 'usuario_sistema_id'
    ];
    
    public function modelo()
    {
        return $this->morphTo();
    }
}