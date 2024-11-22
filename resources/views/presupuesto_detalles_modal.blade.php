<!-- RECORRIDO PARA MOSTRAR LA DATA EN EL MODAL PRESUPUESTO.BLADE.PHP -->
<div>
    <p><strong>Fecha:</strong> {{ $presupuesto->fechaPresu }}</p>
    <p><strong>Cliente:</strong> {{ $presupuesto->Nombre }}</p>
    <p><strong>Dirección:</strong> {{ $presupuesto->Direccion }}</p>
    <p><strong>Entidad:</strong> {{ $presupuesto->entidad }}</p>

    <p><strong>Servicio:</strong> {{ $presupuesto->servicios }}</p>
    <p><strong>Descripción:</strong> {{ $presupuesto->descripcionPres }}</p>

    <h5>Detalles del Presupuesto:</h5>
    <ul>
        @foreach($detalles as $detalle)
            <li>
                <strong>Detalle {{ $loop->iteration }}:</strong><br>
                <strong>Descripción:</strong> {{ $detalle->descriptabla }}<br>
                <strong>Unidad de Medida:</strong> {{ $detalle->unidadMed }}<br>
                <strong>Cantidad:</strong> {{ $detalle->cantidad }}<br>
                <strong>Precio Unitario:</strong> S/. {{ $detalle->precioUnitario }}<br>
                <strong>Total:</strong> S/. {{ $detalle->TotalPres }}<br>
                <strong>Nota:</strong> {{ $detalle->nota }}<br>
                <strong>Garantía:</strong> {{ $detalle->garantia }}<br>
                <hr>
            </li>
        @endforeach
    </ul>
</div>
