@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Cuenta</h1>
        <a href="{{ route('cuentas.show', $cuenta) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('cuentas.update', $cuenta) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="plataforma" class="form-label">Plataforma</label>
                        <input type="text" class="form-control @error('plataforma') is-invalid @enderror" 
                               id="plataforma" name="plataforma" value="{{ old('plataforma', $cuenta->plataforma) }}">
                        @error('plataforma')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre', $cuenta->nombre) }}">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="perfil" class="form-label">Perfil</label>
                        <input type="text" class="form-control @error('perfil') is-invalid @enderror" 
                               id="perfil" name="perfil" value="{{ old('perfil', $cuenta->perfil) }}">
                        @error('perfil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="celular" class="form-label">Celular</label>
                        <input type="text" class="form-control @error('celular') is-invalid @enderror" 
                               id="celular" name="celular" value="{{ old('celular', $cuenta->celular) }}">
                        @error('celular')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control @error('correo') is-invalid @enderror" 
                               id="correo" name="correo" value="{{ old('correo', $cuenta->correo) }}">
                        @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="text" class="form-control @error('contraseña') is-invalid @enderror" 
                               id="contraseña" name="contraseña" value="{{ old('contraseña', $cuenta->contraseña) }}">
                        @error('contraseña')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="vencimiento" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control @error('vencimiento') is-invalid @enderror" 
                               id="vencimiento" name="vencimiento" value="{{ old('vencimiento', $cuenta->vencimiento) }}">
                        @error('vencimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="alerta_vencimiento" 
                                   name="alerta_vencimiento" value="1" 
                                   {{ old('alerta_vencimiento', $cuenta->alerta_vencimiento) ? 'checked' : '' }}>
                            <label class="form-check-label" for="alerta_vencimiento">
                                Alerta de vencimiento
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="vencimiento_cuenta" class="form-label">Vencimiento de Cuenta</label>
                        <input type="date" class="form-control @error('vencimiento_cuenta') is-invalid @enderror" 
                               id="vencimiento_cuenta" name="vencimiento_cuenta" 
                               value="{{ old('vencimiento_cuenta', $cuenta->vencimiento_cuenta) }}">
                        @error('vencimiento_cuenta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="alerta_cuenta" 
                                   name="alerta_cuenta" value="1" 
                                   {{ old('alerta_cuenta', $cuenta->alerta_cuenta) ? 'checked' : '' }}>
                            <label class="form-check-label" for="alerta_cuenta">
                                Alerta de vencimiento de cuenta
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection