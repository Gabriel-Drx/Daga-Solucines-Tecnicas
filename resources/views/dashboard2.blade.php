@extends('dashboard')

@section('title', 'Dashboard2')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <!-- Total Clientes -->
        <div class="card bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Clientes</h5>
                <i class="bi bi-people"></i>
                <p id="totalClientes" class="card-text display-4">{{ $totalClientes }}</p> <!-- Agregado id -->
            </div>
            <div class="card-footer">
                <span>Actualizado: Hoy</span>
            </div>
        </div>

        <div class="card bg-success">
            <div class="card-body">
                <h5 class="card-title">Servicios Activos</h5>
                <i class="bi bi-pin-angle"></i>
                <p class="card-text display-4">85</p>
            </div>
            <div class="card-footer">
                <span>Actualizado: Hoy</span>
            </div>
        </div>

        <div class="card bg-danger">
            <div class="card-body">
                <h5 class="card-title">Tickets Pendientes</h5>  
                <i class="bi bi-ticket-perforated"></i>              
                <p class="card-text display-4">12</p>
            </div>
            <div class="card-footer">
                <span>Actualizado: Hoy</span>
            </div>
        </div>

        <!-- Cuadro de Ingresos Anuales -->
        <div class="card bg-warning">
            <div class="card-body">
                <h5 class="card-title">Ingresos Anuales</h5>
                <i class="bi bi-cash-coin"></i>
                <p id="ingresosAnuales" class="card-text display-4">S/ {{ number_format($ingresosAnuales, 2) }}</p>
            </div>
            <div class="card-footer">
                <span>Actualizado: Hoy</span>
            </div>
        </div>
    </div>

    <!-- Gráfico centrado -->
    <div class="row justify-content-center mt-4">
        <div class="col-12">
            <div class="chart-container">
                <h5 class="card-title text-center">Visión General</h5>
                <canvas id="myChart"></canvas> <!-- Gráfico de Chart.js -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Configuración del gráfico de Chart.js
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Clientes Registrados',
                data: [12, 19, 3, 5, 2, 3, 6, 7, 8, 5, 6, 10], // Ejemplo de datos
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }, {
                label: 'Ingresos',
                data: [5000, 7000, 3000, 8000, 6000, 12000, 15000, 10000, 9000, 8500, 12000, 14000], // Ejemplo de datos
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // AJAX para actualizar el Total Clientes
    function actualizarTotalClientes() {
        $.ajax({
            url: "{{ route('api.total_clientes') }}", // Nueva ruta para obtener el total de clientes
            method: "GET",
            success: function(response) {
                $('#totalClientes').text(response.totalClientes);
            },
            error: function() {
                console.error("No se pudo obtener el total de clientes");
            }
        });
    }

    // Llama a la función al cargar la página
    $(document).ready(function() {
        actualizarTotalClientes();
    });
</script>
@endsection
