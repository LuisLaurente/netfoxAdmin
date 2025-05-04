<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $query = Historial::query()->orderBy('created_at', 'desc');
        
        // Filtros
        if ($request->has('tipo_accion')) {
            $query->where('tipo_accion', $request->tipo_accion);
        }
        
        if ($request->has('modelo')) {
            $query->where('modelo', $request->modelo);
        }
        
        if ($request->has('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        
        if ($request->has('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        
        $historial = $query->paginate(15);
        
        return view('historial.index', compact('historial'));
    }

    public function show(Historial $historial)
    {
        return view('historial.show', compact('historial'));
    }
}