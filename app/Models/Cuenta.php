<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'plataforma', 'nombre', 'perfil', 'celular', 'correo', 
        'contraseña', 'vencimiento', 'alerta_vencimiento',
        'vencimiento_cuenta', 'alerta_cuenta'
    ];
    
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
    
    public function historial()
    {
        return $this->morphMany(Historial::class, 'modelo');
    }
}