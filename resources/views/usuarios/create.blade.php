@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Nuevo Usuario</h1>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="cuenta_id" class="form-label">Cuenta</label>
                    <select class="form-select @error('cuenta_id') is-invalid @enderror" id="cuenta_id" name="cuenta_id">
                        <option value="">Seleccionar cuenta</option>
                        @foreach($cuentas as $cuenta)
                            @if($cuenta->usuarios->count() < 5)
                                <option value="{{ $cuenta->id }}" {{ old('cuenta_id') == $cuenta->id || (isset($cuenta_id) && $cuenta_id == $cuenta->id) ? 'selected' : '' }}>
                                    {{ $cuenta->plataforma }} - {{ $cuenta->nombre }} ({{ $cuenta->usuarios->count() }}/5)
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('cuenta_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control @error('correo') is-invalid @enderror" 
                           id="correo" name="correo" value="{{ old('correo') }}">
                    @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                           id="telefono" name="telefono" value="{{ old('telefono') }}">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection