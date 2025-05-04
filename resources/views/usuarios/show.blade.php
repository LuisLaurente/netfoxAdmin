@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalles de Usuario</h1>
        <div>
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Información del Usuario</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $usuario->id }}</p>
                    <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
                    <p><strong>Correo:</strong> {{ $usuario->correo ?? 'No especificado' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No especificado' }}</p>
                    <p><strong>Cuenta:</strong> {{ $usuario->cuenta->plataforma }} - {{ $usuario->cuenta->nombre }}</p>
                    <p><strong>Fecha de creación:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Transferir Usuario a Otra Cuenta</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.transferir', $usuario) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="cuenta_destino_id" class="form-label">Cuenta Destino</label>
                    <select class="form-select @error('cuenta_destino_id') is-invalid @enderror" 
                            id="cuenta_destino_id" name="cuenta_destino_id">
                        <option value="">Seleccionar cuenta destino</option>
                        @foreach(App\Models\Cuenta::all() as $cuenta)
                            @if($cuenta->id != $usuario->cuenta_id && $cuenta->usuarios->count() < 5)
                                <option value="{{ $cuenta->id }}">
                                    {{ $cuenta->plataforma }} - {{ $cuenta->nombre }} ({{ $cuenta->usuarios->count() }}/5)
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('cuenta_destino_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-exchange-alt"></i> Transferir
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection