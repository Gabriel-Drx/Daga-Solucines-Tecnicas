@extends('dashboard')

@section('title', 'Clientes')

@section('content')

    @if (session("Correcto"))
        <div class="alert alert-success">{{ session("Correcto") }}</div>
    @endif
    @if (session("Incorrecto"))
        <div class="alert alert-danger">{{ session("Incorrecto") }}</div>
    @endif

    <script>
        var res = function() {
            var not = confirm("Estas seguro de eliminar?");
            return not;
        }
    </script>

    <div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditarLabel">Registrar nuevo cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crud.create') }}" method="POST" id="registroForm">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="txtNombre" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="txtDireccion" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="entidad" class="form-label">Entidad</label>
                            <input type="text" class="form-control" id="entidad" name="txtentidad" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="tipoDocumento" name="tipoDocumento" required>
                                <option value="" selected>Seleccionar Tipo de Documento</option>
                                <option value="dni">DNI</option>
                                <option value="ruc">RUC</option>
                            </select>
                        </div>
                    
                        <div class="mb-3">
                            <label for="documento" class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" id="documento" name="txtRUC_DNI" maxlength="8" inputmode="numeric" pattern="\d*" required oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="p-5 table-responsive">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalRegistrar">Nuevo cliente</button>
        <div class="d-flex justify-content-between mb-3">
            <input type="text" class="form-control w-25" placeholder="Buscar por nombre" name="search" id="search">
        </div>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Entidad</th>
                    <th>RUC / DNI</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    <th>Historial</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item)
                <tr>
                    <td>{{ $item->idCliente }}</td>
                    <td>{{ $item->Nombre }}</td>
                    <td>{{ $item->Direccion }}</td>
                    <td>{{ $item->entidad }}</td>
                    <td>{{ $item->RUC_DNI }}</td>
                    <td>
                        <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $item->idCliente }}"
                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                    </td>
                    <td>
                        <a href="{{route("crud.delete", $item->idCliente)}}" onclick="return res()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm"><i class="fa fa-print"></i></button>
                    </td>

                    <!-- Modal Editar -->
                    <div class="modal fade" id="modalEditar{{ $item->idCliente }}" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalEditarLabel">Modificar datos del cliente</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route("crud.update")}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">idCliente</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="txtidCliente" value="{{$item->idCliente}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="txtNombre" value="{{$item->Nombre}}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Direccion</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="txtDireccion" value="{{$item->Direccion}}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Entidad</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="txtentidad" value="{{$item->entidad}}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="tipoDocumentoEditar" class="form-label">Tipo de Documento</label>
                                            <select class="form-select" id="tipoDocumentoEditar" name="tipoDocumento" required>
                                                <option value="" {{ $item->RUC_DNI == '' ? 'selected' : '' }}>Seleccionar Tipo de Documento</option>
                                                <option value="dni" {{ $item->RUC_DNI == 'dni' ? 'selected' : '' }}>DNI</option>
                                                <option value="ruc" {{ $item->RUC_DNI == 'ruc' ? 'selected' : '' }}>RUC</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="documentoEditar" class="form-label">Número de Documento</label>
                                            <input type="text" class="form-control" id="documentoEditar" name="txtRUC_DNI" value="{{ $item->RUC_DNI }}"
                                                maxlength="{{ $item->RUC_DNI == 'dni' ? '8' : '11' }}" inputmode="numeric" pattern="\d*" required
                                                oninput="this.value = this.value.replace(/\D/g, '')">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Modificar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cliente.js') }}"></script>

    <script>
        // Función para actualizar el Total Clientes en el dashboard
        function actualizarTotalClientes() {
            $.ajax({
                url: "{{ route('api.total_clientes') }}", // Ruta para obtener el total de clientes
                method: "GET",
                success: function(response) {
                    // Actualiza el valor de "Total Clientes" en el dashboard
                    window.parent.document.getElementById('totalClientes').innerText = response.totalClientes;
                },
                error: function() {
                    console.error("No se pudo obtener el total de clientes");
                }
            });
        }
    
        // Llama a actualizarTotalClientes después de agregar un cliente
        $('#registroForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function() {
                    actualizarTotalClientes(); // Actualiza el total de clientes en el dashboard
                    location.reload(); // Recarga la página para mostrar el nuevo cliente en la lista
                },
                error: function() {
                    console.error("Error al registrar el cliente");
                }
            });
        });
    
        // Llama a actualizarTotalClientes después de eliminar un cliente
        $('a.btn-danger').on('click', function(event) {
            event.preventDefault();
            if (confirm("¿Estás seguro de que deseas eliminar este cliente?")) {
                $.ajax({
                    type: "DELETE",
                    url: $(this).attr('href'),
                    success: function() {
                        actualizarTotalClientes(); // Actualiza el total de clientes en el dashboard
                        location.reload(); // Recarga la página para actualizar la lista de clientes
                    },
                    error: function() {
                        console.error("Error al eliminar el cliente");
                    }
                });
            }
        });
    </script>

@endsection
