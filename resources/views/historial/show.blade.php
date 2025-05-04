@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Registro</h1>
        <a href="{{ route('historial.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Información del Registro</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $historial->id }}</p>
                    <p><strong>Fecha/Hora:</strong> {{ $historial->created_at->format('d/m/Y H:i:s') }}</p>
                    <p>
                        <strong>Tipo de Acción:</strong> 
                        @if($historial->tipo_accion == 'crear')
                            <span class="badge bg-success">Creación</span>
                        @elseif($historial->tipo_accion == 'editar')
                            <span class="badge bg-warning">Edición</span>
                        @elseif($historial->tipo_accion == 'eliminar')
                            <span class="badge bg-danger">Eliminación</span>
                        @elseif($historial->tipo_accion == 'transferir')
                            <span class="badge bg-info">Transferencia</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Modelo:</strong> {{ ucfirst($historial->modelo) }}</p>
                    <p><strong>ID del Modelo:</strong> {{ $historial->modelo_id }}</p>
                    <p><strong>Usuario que realizó la acción:</strong> 
                        {{ $historial->usuario_sistema_id ? 'ID: ' . $historial->usuario_sistema_id : 'No registrado' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($historial->datos_previos)
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">Datos Previos</h4>
            </div>
            <div class="card-body">
                <pre class="mb-0">{{ json_encode(json_decode($historial->datos_previos), JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    @endif

    @if($historial->datos_nuevos)
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Datos Nuevos</h4>
            </div>
            <div class="card-body">
                <pre class="mb-0">{{ json_encode(json_decode($historial->datos_nuevos), JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    @endif
@endsection