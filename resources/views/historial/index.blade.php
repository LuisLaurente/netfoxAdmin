@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Historial de Cambios</h1>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Filtros</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('historial.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="tipo_accion" class="form-label">Tipo de Acción</label>
                        <select class="form-select" id="tipo_accion" name="tipo_accion">
                            <option value="">Todas</option>
                            <option value="crear" {{ request('tipo_accion') == 'crear' ? 'selected' : '' }}>Creación</option>
                            <option value="editar" {{ request('tipo_accion') == 'editar' ? 'selected' : '' }}>Edición</option>
                            <option value="eliminar" {{ request('tipo_accion') == 'eliminar' ? 'selected' : '' }}>Eliminación</option>
                            <option value="transferir" {{ request('tipo_accion') == 'transferir' ? 'selected' : '' }}>Transferencia</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <select class="form-select" id="modelo" name="modelo">
                            <option value="">Todos</option>
                            <option value="cuenta" {{ request('modelo') == 'cuenta' ? 'selected' : '' }}>Cuenta</option>
                            <option value="usuario" {{ request('modelo') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fecha_desde" class="form-label">Fecha Desde</label>
                        <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                        <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('historial.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha/Hora</th>
                            <th>Acción</th>
                            <th>Modelo</th>
                            <th>ID Modelo</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historial as $registro)
                            <tr>
                                <td>{{ $registro->id }}</td>
                                <td>{{ $registro->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    @if($registro->tipo_accion == 'crear')
                                        <span class="badge bg-success">Creación</span>
                                    @elseif($registro->tipo_accion == 'editar')
                                        <span class="badge bg-warning">Edición</span>
                                    @elseif($registro->tipo_accion == 'eliminar')
                                        <span class="badge bg-danger">Eliminación</span>
                                    @elseif($registro->tipo_accion == 'transferir')
                                        <span class="badge bg-info">Transferencia</span>
                                    @endif
                                </td>
                                <td>{{ ucfirst($registro->modelo) }}</td>
                                <td>{{ $registro->modelo_id }}</td>
                                <td>
                                    <a href="{{ route('historial.show', $registro) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay registros en el historial</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $historial->links() }}
            </div>
        </div>
    </div>
@endsection