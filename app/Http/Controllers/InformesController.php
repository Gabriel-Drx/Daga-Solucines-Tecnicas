<?php

namespace App\Http\Controllers;
abstract class Controller
{
    //
}
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\InformesController;


class InformesController extends Controller
{
    public function index(Request $request)
{
    // Obtenemos el término de búsqueda
    $search = $request->input('search');

    // Realizamos la búsqueda por nombre del cliente
    $informes = DB::table('informe')
        ->join('cliente', 'informe.idCliente', '=', 'cliente.idCliente')
        ->select('informe.*', 'cliente.Nombre')
        ->when($search, function ($query, $search) {
            return $query->where('cliente.Nombre', 'like', '%' . $search . '%');
        })
        ->get();

    // Obtener todos los clientes para los formularios
    $clientes = DB::table('cliente')->get();

    return view('informes', compact('informes', 'clientes', 'search'));
}

    // Crear un nuevo informe
    public function create(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'fechaInfo' => 'required|date',
            'descripcion' => 'required|string|max:4294967295', // Tamaño máximo para LONGTEXT
            'idCliente' => 'required|exists:cliente,idCliente', // Asegurarse que el cliente exista
        ]);

        // Insertar el nuevo informe en la base de datos
        DB::table('informe')->insert([
            'fechaInfo' => $request->fechaInfo,
            'descripcion' => $request->descripcion,
            'idCliente' => $request->idCliente
        ]);

        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('Correcto', 'Informe registrado correctamente');
    }
    

    public function update(Request $request, $id)
{
    // Validar los datos
    $request->validate([
        'fechaInfo' => 'required|date',
        'descripcion' => 'required|string|max:4294967295', // Tamaño máximo para LONGTEXT
        'idCliente' => 'required|exists:cliente,idCliente',
    ]);

    // Actualizar el informe en la base de datos
    DB::table('informe')->where('idInforme', $id)->update([
        'fechaInfo' => $request->fechaInfo,
        'descripcion' => $request->descripcion,
        'idCliente' => $request->idCliente,
    ]);

    // Redirigir con un mensaje de éxito
    return back()->with('Correcto', 'Informe actualizado correctamente');
}

public function destroy($id)
{
    // Eliminar el informe
    DB::table('informe')->where('idInforme', $id)->delete();

    // Redirigir con un mensaje de éxito
    return back()->with('Correcto', 'Informe eliminado correctamente');
}

public function generatePDF($id)
{
    // Obtén los datos del informe
    $informe = DB::table('informe')
        ->join('cliente', 'informe.idCliente', '=', 'cliente.idCliente')
        ->select('informe.*', 'cliente.Nombre', 'cliente.Direccion')
        ->where('idInforme', $id)
        ->first();

    if (!$informe) {
        return back()->with('Incorrecto', 'Informe no encontrado.');
    }

    // Genera el PDF
    $pdf = Pdf::loadView('informes.pdf', compact('informe'));

    // Devuelve el PDF en el navegador
    return $pdf->stream("Informe_{$informe->idInforme}.pdf");
}

}
