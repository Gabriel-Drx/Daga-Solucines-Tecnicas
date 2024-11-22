<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

abstract class Controller
{
    //
}

class Dashboard2Controller extends Controller
{
    public function index()
    {
        $anio = Carbon::now()->year;

        // Calcula el total de ingresos para el año actual
        $ingresosAnuales = DB::table('facturas')
                            ->whereYear('fecha', $anio)
                            ->sum('monto');

        // Contar el total de clientes
    $totalClientes = DB::table('cliente')->count();

    return view('dashboard2', compact('ingresosAnuales', 'anio', 'totalClientes'));
    }
}
