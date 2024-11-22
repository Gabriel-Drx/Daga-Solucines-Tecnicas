<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;
use Exception;
use Carbon\Carbon;


abstract class Controller
{
    //
}


class FacturaController extends Controller
{
    public function index(Request $request)
    {
        // Obtén el mes y el año de los parámetros de la solicitud o usa el mes y año actuales por defecto
        $mes = $request->input('mes', Carbon::now()->month);
        $anio = $request->input('anio', Carbon::now()->year);

        // Filtra las facturas por el mes y el año especificados
        $facturas = DB::table('facturas')
                      ->whereMonth('fecha', $mes)
                      ->whereYear('fecha', $anio)
                      ->get();

        // Calcula el monto total para las facturas filtradas
        $totalMonto = $facturas->sum('monto');

        // Pasa los datos a la vista
        return view('factura', compact('facturas', 'totalMonto', 'mes', 'anio'));
    }

    // Crear un nuevo informe (factura)
    public function create(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'fecha' => 'required|date',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validar tipo y tamaño
            'monto' => 'required|numeric',
        ]);

        try {
            // Mover el archivo subido a la carpeta storage
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $nombreArchivo = time() . '_' . Str::limit($archivo->getClientOriginalName(), 50); // Limitar el nombre a 50 caracteres
                $archivo->move(public_path('uploads'), $nombreArchivo); 
            }

            // Insertar los datos en la base de datos
            DB::table('facturas')->insert([
                'fecha' => $request->fecha,
                'archivo' => $nombreArchivo, // Guardar el nombre del archivo
                'monto' => $request->monto
            ]);

            // Redirigir con mensaje de éxito
            return back()->with('Correcto', 'Factura registrada correctamente');
        } catch (Exception $e) {
            // Capturar el error e informarlo
            Log::error('Error al insertar la factura: ' . $e->getMessage());
            return back()->withErrors('Error al registrar la factura. Inténtalo de nuevo.');
        }
    }

    // Actualizar una factura
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'fecha' => 'required|date',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Archivo opcional en la actualización
            'monto' => 'required|numeric',
        ]);

        // Comprobar si hay un archivo nuevo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . Str::limit($archivo->getClientOriginalName(), 50); // Limitar el nombre a 50 caracteres
            $archivo->move(public_path('uploads'), $nombreArchivo); // Guardar en public/uploads
        } else {
            // Si no hay archivo nuevo, conservar el archivo anterior
            $nombreArchivo = DB::table('facturas')->where('id', $id)->value('archivo');
        }

        // Actualizar los datos en la base de datos
        DB::table('facturas')->where('id', $id)->update([
            'fecha' => $request->fecha,
            'archivo' => $nombreArchivo, 
            'monto' => $request->monto,
        ]);

        // Redirigir con mensaje de éxito
        return back()->with('Correcto', 'Factura actualizada correctamente');
    }

    // Eliminar una factura
    public function destroy($id)
    {
        $archivo = DB::table('facturas')->where('id', $id)->value('archivo');

        // Eliminar el archivo del sistema de almacenamiento
        if ($archivo) {
            $rutaArchivo = public_path('uploads/' . $archivo);
            if (File::exists($rutaArchivo)) {
                File::delete($rutaArchivo);
            }
        }
        
        // Eliminar la factura de la base de datos
        DB::table('facturas')->where('id', $id)->delete();
        
        // Redirigir con mensaje de éxito
        return back()->with('Correcto', 'Factura eliminada correctamente');
    }
}