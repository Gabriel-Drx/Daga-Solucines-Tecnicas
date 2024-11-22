<?php

namespace App\Http\Controllers;
abstract class Controller
{
    //
}
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 
use App\Models\Presu;

class PresuController extends Controller
{
    public function index(Request $request)
    {
        $mes = $request->input('mes');
        $anio = $request->input('anio');

        $query = Presu::query();

        if ($mes && $anio) {
            $query->whereYear('fecha', $anio)->whereMonth('fecha', $mes);
        }

        $subidas = $query->get();

        return view('presu', compact('subidas', 'mes', 'anio'));
    }

    public function store(Request $request)
    {
        $subida = new Presu();
        $subida->nombre = $request->nombre;
        $subida->fecha = $request->fecha;

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoName = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('uploads'), $archivoName);
            $subida->archivo = $archivoName;
        }

        $subida->save();
        return redirect()->route('presu.index')->with('success', 'Subida agregada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $subida = Presu::find($id);
        $subida->nombre = $request->nombre;
        $subida->fecha = $request->fecha;

        if ($request->hasFile('archivo')) {
            
            if ($subida->archivo && file_exists(public_path('uploads/' . $subida->archivo))) {
                unlink(public_path('uploads/' . $subida->archivo));
            }

            $archivo = $request->file('archivo');
            $archivoName = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('uploads'), $archivoName);
            $subida->archivo = $archivoName;
        }

        $subida->save();
        return redirect()->route('presu.index')->with('success', 'Subida actualizada exitosamente');
    }

    public function destroy($id)
    {
        $subida = Presu::find($id);
        
       
        if ($subida->archivo && file_exists(public_path('uploads/' . $subida->archivo))) {
            unlink(public_path('uploads/' . $subida->archivo));
        }

        $subida->delete();
        return redirect()->route('presu.index')->with('success', 'Subida eliminada exitosamente');
    }
}