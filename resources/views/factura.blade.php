@extends('dashboard')

@section('title', 'Factura')

@section('content')
<div class="container mt-5">

@php
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
@endphp
    <!-- Filtro de Mes y Año -->
    <form id="filtroMesAnio" action="{{ route('factura.index') }}" method="GET" class="mb-4">
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
                <!-- Botón para abrir el modal de agregar/editar factura -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarFactura">
                    Agregar Factura
                </button>
            </div>
        </div>
    </form>

    <!-- Encabezado del mes y año -->
    <h5>Facturas de {{ DateTime::createFromFormat('!m', $mes)->format('F') }} {{ $anio }}</h5>
    <p>Facturas encontradas: {{ $facturas->count() }}</p>

    <!-- Modal para agregar/editar factura -->
    <div class="modal fade" id="modalAgregarFactura" tabindex="-1" aria-labelledby="modalAgregarFacturaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarFacturaLabel">Agregar/Editar Factura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('factura.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="fecha" class="col-sm-3 col-form-label">Fecha</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="archivo" class="col-sm-3 col-form-label">Archivo</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="archivo" name="archivo" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="monto" class="col-sm-3 col-form-label">Monto</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                            </div>
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

    <!-- Tabla de facturas -->
    <div class="p-5 table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Archivo</th>
                    <th>Monto</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    <th>Descargar</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMonto = 0;
                @endphp
                @foreach ($facturas as $factura)
                <tr>
                    <td>{{ $factura->id }}</td>
                    <td>{{ $factura->fecha }}</td>
                    <td>{{ $factura->archivo }}</td>
                    <td>{{ $factura->monto }}</td>

                    @php
                        $totalMonto += $factura->monto;
                    @endphp

                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{$factura->id}}">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>

                    <div class="modal fade" id="modalEditar{{$factura->id}}" tabindex="-1" aria-labelledby="modalEditarLabel{{$factura->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalEditarLabel{{$factura->id}}">Editar Factura</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('factura.update', $factura->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="fecha" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" name="fecha" value="{{ $factura->fecha }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="archivo" class="form-label">Archivo</label>
                                            <input type="file" class="form-control" id="archivo" name="archivo">
                                        </div>
                                        <div class="mb-3">
                                            <label for="monto" class="form-label">Monto</label>
                                            <input type="text" class="form-control" name="monto" value="{{ $factura->monto }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{$factura->id}}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>

                    <div class="modal fade" id="modalEliminar{{$factura->id}}" tabindex="-1" aria-labelledby="modalEliminarLabel{{$factura->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalEliminarLabel{{$factura->id}}">Eliminar Factura</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar esta factura?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('factura.destroy', $factura->id) }}" method="POST">
                                        @csrf
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <td>
                        <a href="{{ asset('uploads/' . $factura->archivo) }}" class="btn btn-warning btn-sm" download>
                            <i class="fa fa-download"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <h5>Monto Total: S./{{ number_format($totalMonto, 2) }}</h5>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function actualizarIngresosDashboard(mes, anio) {
        $.ajax({
            url: "{{ route('api.ingresos_del_mes') }}",
            method: "GET",
            data: { mes: mes, anio: anio },
            success: function(response) {
                window.parent.document.getElementById('ingresosDelMes').innerText = 'S/ ' + parseFloat(response.ingresosDelMes).toFixed(2);
            },
            error: function() {
                console.error("No se pudo obtener el monto de ingresos del mes");
            }
        });
    }

    $('#filtroMesAnio').on('submit', function(event) {
        event.preventDefault();
        let mes = $('#mes').val();
        let anio = $('#anio').val();
        actualizarIngresosDashboard(mes, anio);
        this.submit();
    });
</script>
@endsection
