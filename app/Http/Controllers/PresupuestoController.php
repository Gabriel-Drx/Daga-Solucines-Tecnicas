<?php

namespace App\Http\Controllers;
abstract class Controller
{
    //
}
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 

class PresupuestoController extends Controller
{
    
    public function index()
    {
         // Obtener presupuestos y sus respectivos clientes, incluyendo Direccion y entidad
        $presupuestos = DB::table('presupuesto')
            ->join('cliente', 'presupuesto.idCliente', '=', 'cliente.idCliente')
            ->select('presupuesto.*', 'cliente.Nombre', 'cliente.Direccion', 'cliente.entidad') // Agregar Direccion y entidad
            ->get();
    
        // Obtener clientes para el modal de creación
        $clientes = DB::table('cliente')->get();
    
        return view('presupuesto', compact('presupuestos', 'clientes'));
    }

    public function edit($idPresu)
    {
        // Obtener el presupuesto y sus detalles
        $presupuesto = DB::table('presupuesto')
            ->join('cliente', 'presupuesto.idCliente', '=', 'cliente.idCliente')
            ->where('presupuesto.idPresu', $idPresu)
            ->select('presupuesto.*', 'cliente.Nombre')
            ->first();

        if (!$presupuesto) {
            return abort(404, 'Presupuesto no encontrado.');
        }

        $clientes = DB::table('cliente')->get();

        // Obtener detalles del presupuesto
        $detalles = DB::table('detallepresu')
            ->where('idPresu', $idPresu)
            ->get();

        return view('presupuesto_edit_modal', compact('presupuesto', 'clientes', 'detalles'));
    }

    public function update(Request $request, $idPresu)
{
    // Actualizar el presupuesto
    DB::table('presupuesto')
        ->where('idPresu', $idPresu)
        ->update([
            'fechaPresu' => $request->fechaPresu,
            'descripcionPres' => $request->descripcionPres,
            'servicios' => $request->servicios, // Agregar el servicio
            'idCliente' => $request->idCliente,
        ]);

    // Eliminar y reinsertar los detalles
    DB::table('detallepresu')->where('idPresu', $idPresu)->delete();

    foreach ($request->detalles as $detalle) {
        DB::table('detallepresu')->insert([
            'descriptabla' => $detalle['descriptabla'],
            'unidadMed' => $detalle['unidadMed'],
            'cantidad' => $detalle['cantidad'],
            'precioUnitario' => $detalle['precioUnitario'],
            'descuentoPres' => $detalle['descuentoPres'],
            'TotalPres' => $detalle['TotalPres'],
            'nota' => $detalle['nota'],
            'garantia' => $detalle['garantia'],
            'idPresu' => $idPresu,
        ]);
    }

    return redirect()->route('presupuestos.index')->with('Correcto', 'Presupuesto actualizado correctamente');
}

    public function delete($idPresu)
    {
        DB::table('detallepresu')->where('idPresu', $idPresu)->delete();
        DB::table('presupuesto')->where('idPresu', $idPresu)->delete();

        return back()->with('Correcto', 'Presupuesto eliminado correctamente');
    }

    public function detalles($idPresu)
    {
         // Obtener el presupuesto y sus detalles, incluyendo Direccion y entidad del cliente
    $presupuesto = DB::table('presupuesto')
    ->join('cliente', 'presupuesto.idCliente', '=', 'cliente.idCliente')
    ->where('presupuesto.idPresu', $idPresu)
    ->select('presupuesto.*', 'cliente.Nombre', 'cliente.Direccion', 'cliente.entidad') // Agregar Direccion y entidad
    ->first();

if (!$presupuesto) {
    return abort(404, 'Presupuesto no encontrado.');
}

// Obtener los detalles del presupuesto
$detalles = DB::table('detallepresu')
    ->where('idPresu', $idPresu)
    ->get();

return view('presupuesto_detalles_modal', compact('presupuesto', 'detalles'));
    }
    public function create(Request $request)
{
    // Insertar el presupuesto
    $idPresu = DB::table('presupuesto')->insertGetId([
        'fechaPresu' => $request->fechaPresu,
        'descripcionPres' => $request->descripcionPres,
        'servicios' => $request->servicios, 
        'idCliente' => $request->idCliente,
    ]);

    // Insertar detalles del presupuesto
    foreach ($request->detalles as $detalle) {
        DB::table('detallepresu')->insert([
            'descriptabla' => $detalle['descriptabla'],
            'unidadMed' => $detalle['unidadMed'],
            'cantidad' => $detalle['cantidad'],
            'precioUnitario' => $detalle['precioUnitario'],
            'descuentoPres' => $detalle['descuentoPres'],
            'TotalPres' => $detalle['TotalPres'],
            'nota' => $detalle['nota'],
            'garantia' => $detalle['garantia'],
            'idPresu' => $idPresu,
        ]);
    }

    return redirect()->route('presupuestos.index')->with('Correcto', 'Presupuesto creado correctamente');
}
}