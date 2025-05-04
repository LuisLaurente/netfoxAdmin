@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Cuentas</h1>
        <a href="{{ route('cuentas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Cuenta
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Plataforma</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Vencimiento</th>
                            <th>Usuarios</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuentas as $cuenta)
                            <tr>
                                <td>{{ $cuenta->id }}</td>
                                <td>{{ $cuenta->plataforma }}</td>
                                <td>{{ $cuenta->nombre }}</td>
                                <td>{{ $cuenta->correo }}</td>
                                <td>{{ date('d/m/Y', strtotime($cuenta->vencimiento)) }}</td>
                                <td>{{ $cuenta->usuarios->count() }}/5</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('cuentas.show', $cuenta) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('cuentas.edit', $cuenta) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="document.getElementById('delete-form-{{ $cuenta->id }}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $cuenta->id }}" 
                                              action="{{ route('cuentas.destroy', $cuenta) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay cuentas registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection