@extends('dashboard')

@section('title', 'Subidas')

@section('content')
<div class="container mt-5">
    
    <h1>Subir Presupuesto</h1>


    @php
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
@endphp

<!-- Filtro de Mes y Año -->
<form id="filtroMesAnio" action="{{ route('presu.index') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <label for="mes">Mes</label>
            <select name="mes" id="mes" class="form-control">
                @foreach ($meses as $numero => $nombre)
                    <option value="{{ $numero }}" {{ request('mes') == $numero ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="anio">Año</label>
            <select name="anio" id="anio" class="form-control">
                @for ($i = date('Y'); $i >= 2019; $i--)
                    <option value="{{ $i }}" {{ request('anio') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
        <div class="col-md-3 align-self-end text-end">
            <!-- Botón para abrir el modal de agregar subida -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarSubida">
                Agregar Subida
            </button>
        </div>
    </div>
</form>


    <!-- Modal para agregar nueva subida -->
    <div class="modal fade" id="modalAgregarSubida" tabindex="-1" aria-labelledby="modalAgregarSubidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarSubidaLabel">Agregar Subida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('presu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" class="form-control" id="archivo" name="archivo" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de subidas -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subidas as $subida)
                <tr>
                    <td>{{ $subida->nombre }}</td>
                    <td>{{ $subida->fecha }}</td>
                    <td>{{ $subida->archivo }}</td>
                    <td>
                      <!-- Botón para editar -->
<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $subida->idSubida }}">
    Editar
</button>

<!-- Modal para editar subida -->
<div class="modal fade" id="modalEditar{{ $subida->idSubida }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $subida->idSubida }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel{{ $subida->idSubida }}">Editar Subida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('presu.update', $subida->idSubida) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="{{ $subida->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" value="{{ $subida->fecha }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo</label>
                        <input type="file" class="form-control" name="archivo">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                        <!-- Botón para eliminar -->
                        <form action="{{ route('presu.destroy', $subida->idSubida) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>

                        <!-- Botón para descargar -->
                        <a href="{{ asset('uploads/' . $subida->archivo) }}" class="btn btn-warning btn-sm" download>
                            Descargar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection
