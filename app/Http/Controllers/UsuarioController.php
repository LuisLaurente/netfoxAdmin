<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Cuenta;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('cuenta')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $cuentas = Cuenta::all();
        return view('usuarios.create', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cuenta_id' => 'required|exists:cuentas,id',
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        // Verificar si la cuenta ya tiene 5 usuarios
        $cuenta = Cuenta::findOrFail($request->cuenta_id);
        if ($cuenta->usuarios()->count() >= 5) {
            return back()->withErrors(['cuenta_id' => 'Esta cuenta ya tiene el máximo de 5 usuarios permitidos']);
        }

        $usuario = Usuario::create($validated);
        
        Historial::create([
            'tipo_accion' => 'crear',
            'modelo' => 'usuario',
            'modelo_id' => $usuario->id,
            'datos_nuevos' => json_encode($usuario->toArray()),
            'usuario_sistema_id' => Auth::id(),
        ]);

        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Usuario creado correctamente');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('cuenta');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        $cuentas = Cuenta::all();
        return view('usuarios.edit', compact('usuario', 'cuentas'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $validated = $request->validate([
            'cuenta_id' => 'required|exists:cuentas,id',
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        // Si cambia de cuenta, verificar límite
        if ($usuario->cuenta_id != $request->cuenta_id) {
            $nuevaCuenta = Cuenta::findOrFail($request->cuenta_id);
            if ($nuevaCuenta->usuarios()->count() >= 5) {
                return back()->withErrors(['cuenta_id' => 'La cuenta destino ya tiene el máximo de 5 usuarios']);
            }
        }

        $datosPrevios = $usuario->toArray();
        $usuario->update($validated);
        
        Historial::create([
            'tipo_accion' => 'editar',
            'modelo' => 'usuario',
            'modelo_id' => $usuario->id,
            'datos_previos' => json_encode($datosPrevios),
            'datos_nuevos' => json_encode($usuario->toArray()),
            'usuario_sistema_id' => Auth::id(),
        ]);

        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(Usuario $usuario)
    {
        $datosPrevios = $usuario->toArray();
        
        Historial::create([
            'tipo_accion' => 'eliminar',
            'modelo' => 'usuario',
            'modelo_id' => $usuario->id,
            'datos_previos' => json_encode($datosPrevios),
            'usuario_sistema_id' => Auth::id(),
        ]);
        
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    public function transferir(Request $request, Usuario $usuario)
    {
        $request->validate([
            'cuenta_destino_id' => 'required|exists:cuentas,id|different:cuenta_id',
        ]);
        
        $cuentaDestino = Cuenta::findOrFail($request->cuenta_destino_id);
        
        // Verificar límite de usuarios en la cuenta destino
        if ($cuentaDestino->usuarios()->count() >= 5) {
            return back()->withErrors(['cuenta_destino_id' => 'La cuenta destino ya tiene el máximo de 5 usuarios']);
        }
        
        $datosPrevios = $usuario->toArray();
        $cuentaOrigen = $usuario->cuenta_id;
        
        $usuario->update(['cuenta_id' => $request->cuenta_destino_id]);
        
        Historial::create([
            'tipo_accion' => 'transferir',
            'modelo' => 'usuario',
            'modelo_id' => $usuario->id,
            'datos_previos' => json_encode(['cuenta_id' => $cuentaOrigen]),
            'datos_nuevos' => json_encode(['cuenta_id' => $request->cuenta_destino_id]),
            'usuario_sistema_id' => Auth::id(),
        ]);
        
        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Usuario transferido correctamente');
    }
}