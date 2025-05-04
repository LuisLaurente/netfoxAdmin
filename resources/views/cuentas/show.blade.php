@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalles de Cuenta</h1>
        <div>
            <a href="{{ route('cuentas.edit', $cuenta) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('cuentas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Información de la Cuenta</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Plataforma:</strong> {{ $cuenta->plataforma }}</p>
                    <p><strong>Nombre:</strong> {{ $cuenta->nombre }}</p>
                    <p><strong>Perfil:</strong> {{ $cuenta->perfil ?? 'No especificado' }}</p>
                    <p><strong>Celular:</strong> {{ $cuenta->celular ?? 'No especificado' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Correo:</strong> {{ $cuenta->correo }}</p>
                    <p><strong>Contraseña:</strong> {{ $cuenta->contraseña }}</p>
                    <p><strong>Vencimiento:</strong> {{ date('d/m/Y', strtotime($cuenta->vencimiento)) }}</p>
                    <p><strong>Alerta de vencimiento:</strong> {{ $cuenta->alerta_vencimiento ? 'Sí' : 'No' }}</p>
                    <p><strong>Vencimiento de cuenta:</strong> 
                        {{ $cuenta->vencimiento_cuenta ? date('d/m/Y', strtotime($cuenta->vencimiento_cuenta)) : 'No especificado' }}
                    </p>
                    <p><strong>Alerta de vencimiento de cuenta:</strong> {{ $cuenta->alerta_cuenta ? 'Sí' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Usuarios de la Cuenta ({{ $cuenta->usuarios->count() }}/5)</h4>
            @if($cuenta->usuarios->count() < 5)
                <a href="{{ route('usuarios.create', ['cuenta_id' => $cuenta->id]) }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </a>
            @endif
        </div>
        <div class="card-body">
            @if($cuenta->usuarios->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cuenta->usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->id }}</td>
                                    <td>{{ $usuario->nombre }}</td>
                                    <td>{{ $usuario->correo ?? 'No especificado' }}</td>
                                    <td>{{ $usuario->telefono ?? 'No especificado' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" 
                                                    onclick="document.getElementById('delete-user-form-{{ $usuario->id }}').submit();">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-user-form-{{ $usuario->id }}" 
                                                  action="{{ route('usuarios.destroy', $usuario) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No hay usuarios registrados para esta cuenta.</p>
            @endif
        </div>
    </div>
@endsection