<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'cuenta_id', 'nombre', 'correo', 'telefono'
    ];
    
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }
    
    public function historial()
    {
        return $this->morphMany(Historial::class, 'modelo');
    }
}