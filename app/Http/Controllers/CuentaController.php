<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuentaController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::with('usuarios')->get();
        return view('cuentas.index', compact('cuentas'));
    }

    public function create()
    {
        return view('cuentas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plataforma' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'perfil' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:20',
            'correo' => 'required|email|max:255',
            'contraseña' => 'required|string|max:255',
            'vencimiento' => 'required|date',
            'alerta_vencimiento' => 'boolean',
            'vencimiento_cuenta' => 'nullable|date',
            'alerta_cuenta' => 'boolean',
        ]);

        $cuenta = Cuenta::create($validated);

        // Registrar en historial
        Historial::create([
            'tipo_accion' => 'crear',
            'modelo' => 'cuenta',
            'modelo_id' => $cuenta->id,
            'datos_nuevos' => json_encode($cuenta->toArray()),
            'usuario_sistema_id' => Auth::id(),
        ]);

        return redirect()->route('cuentas.show', $cuenta)
            ->with('success', 'Cuenta creada correctamente');
    }

    public function show(Cuenta $cuenta)
    {
        $cuenta->load('usuarios');
        return view('cuentas.show', compact('cuenta'));
    }

    public function edit(Cuenta $cuenta)
    {
        return view('cuentas.edit', compact('cuenta'));
    }

    public function update(Request $request, Cuenta $cuenta)
    {
        $validated = $request->validate([
            'plataforma' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'perfil' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:20',
            'correo' => 'required|email|max:255',
            'contraseña' => 'required|string|max:255',
            'vencimiento' => 'required|date',
            'alerta_vencimiento' => 'boolean',
            'vencimiento_cuenta' => 'nullable|date',
            'alerta_cuenta' => 'boolean',
        ]);

        $datosPrevios = $cuenta->toArray();
        $cuenta->update($validated);

        // Registrar en historial
        Historial::create([
            'tipo_accion' => 'editar',
            'modelo' => 'cuenta',
            'modelo_id' => $cuenta->id,
            'datos_previos' => json_encode($datosPrevios),
            'datos_nuevos' => json_encode($cuenta->toArray()),
            'usuario_sistema_id' => Auth::id(),
        ]);

        return redirect()->route('cuentas.show', $cuenta)
            ->with('success', 'Cuenta actualizada correctamente');
    }

    public function destroy(Cuenta $cuenta)
    {
        $datosPrevios = $cuenta->toArray();

        // Registrar en historial antes de eliminar
        // En cada método donde se crea un registro de historial
        Historial::create([
            'tipo_accion' => 'crear', // o editar, eliminar, etc.
            'modelo' => 'cuenta',
            'modelo_id' => $cuenta->id,
            'datos_nuevos' => json_encode($cuenta->toArray()),
            'usuario_sistema_id' => Auth::id(), // ID del usuario autenticado
        ]);

        $cuenta->delete();

        return redirect()->route('cuentas.index')
            ->with('success', 'Cuenta eliminada correctamente');
    }
}
