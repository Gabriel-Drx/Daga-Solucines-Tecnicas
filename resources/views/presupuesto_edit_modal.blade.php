<form action="{{ route('presupuestos.update', $presupuesto->idPresu) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="fechaPresu" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fechaPresu" value="{{ $presupuesto->fechaPresu }}">
    </div>
    <div class="mb-3">
        <label for="descripcionPres" class="form-label">Descripción General</label>
        <input type="text" class="form-control" name="descripcionPres" value="{{ $presupuesto->descripcionPres }}">
    </div>
    <div class="mb-3">
        <label for="servicios" class="form-label">Servicio</label>
        <select class="form-control" name="servicios">
            <option value="Mantenimiento" {{ $presupuesto->servicios == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
            <option value="Instalación" {{ $presupuesto->servicios == 'Instalación' ? 'selected' : '' }}>Instalación</option>
            <option value="Reparación" {{ $presupuesto->servicios == 'Reparación' ? 'selected' : '' }}>Reparación</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="idCliente" class="form-label">Cliente</label>
        <select class="form-control" name="idCliente">
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->idCliente }}" {{ $cliente->idCliente == $presupuesto->idCliente ? 'selected' : '' }}>
                    {{ $cliente->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <h5>Detalles del Presupuesto</h5>
    <div id="detalles-container">
        @foreach($detalles as $index => $detalle)
            <div class="detalle mb-3 p-3" style="border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;">
              
                <div class="mb-3">
                    <label for="descriptabla" class="form-label">Descripción Detalle  {{ $index + 1 }}</label>
                    <input type="text" class="form-control" name="detalles[{{ $index }}][descriptabla]" value="{{ $detalle->descriptabla }}" required>
                </div>
                <div class="mb-3">
                    <label for="unidadMed" class="form-label">Unidad de Medida</label>
                    <input type="text" class="form-control" name="detalles[{{ $index }}][unidadMed]" value="{{ $detalle->unidadMed }}" required>
                </div>
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="detalles[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}" required>
                </div>
                <div class="mb-3">
                    <label for="precioUnitario" class="form-label">Precio Unitario</label>
                    <input type="number" class="form-control" name="detalles[{{ $index }}][precioUnitario]" value="{{ $detalle->precioUnitario }}" required>
                </div>
                <div class="mb-3">
                    <label for="descuentoPres" class="form-label">Descuento</label>
                    <input type="number" class="form-control" name="detalles[{{ $index }}][descuentoPres]" value="{{ $detalle->descuentoPres }}">
                </div>
                <div class="mb-3">
                    <label for="TotalPres" class="form-label">Total</label>
                    <input type="number" class="form-control" name="detalles[{{ $index }}][TotalPres]" value="{{ $detalle->TotalPres }}" required>
                </div>
                <div class="mb-3">
                    <label for="nota" class="form-label">Nota</label>
                    <input type="text" class="form-control" name="detalles[{{ $index }}][nota]" value="{{ $detalle->nota }}">
                </div>
                <div class="mb-3">
                    <label for="garantia" class="form-label">Garantía</label>
                    <input type="text" class="form-control" name="detalles[{{ $index }}][garantia]" value="{{ $detalle->garantia }}">
                </div>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>