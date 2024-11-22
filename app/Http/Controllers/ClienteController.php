<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
}

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class ClienteController extends Controller
{
    public function 
    index(Request $request)
    {
        $search = $request->input('search');  // Recibimos el término de búsqueda
        if ($search) {
            // Si hay una búsqueda, filtramos los clientes por nombre o entidad
            $datos = DB::table('cliente')
                ->where('Nombre', 'like', '%' . $search . '%')
                ->orWhere('entidad', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Si no hay búsqueda, mostramos todos los clientes
            $datos = DB::table('cliente')->get();
        }

        return view('cliente')->with("datos", $datos);
    }
    public function search(Request $request)
    {
        $search = $request->input('query'); // Recibimos el término de búsqueda desde AJAX
        if ($search) {
            // Filtramos los clientes por nombre, entidad, o RUC/DNI
            $clientes = DB::table('cliente')
                ->where('Nombre', 'like', '%' . $search . '%')
                ->orWhere('entidad', 'like', '%' . $search . '%')
                ->orWhere('RUC_DNI', 'like', '%' . $search . '%') // Buscar también por RUC o DNI
                ->get();
        } else {
            // Si no hay búsqueda, devolvemos todos los clientes
            $clientes = DB::table('cliente')->get();
        }

        // Retornamos la respuesta como JSON para que JavaScript la procese
        return response()->json($clientes);
    }


    public function create(Request $request){
        try {
            $sql=DB::insert(" insert into cliente(Nombre,Direccion,entidad,RUC_DNI)values(?,?,?,?) ", 
        [
        
            $request->txtNombre,
            $request->txtDireccion,
            $request->txtentidad,
            $request->txtRUC_DNI,

        ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("Correcto","Cliente registrado correctamente");
           
        } else {
            return back()->with("Incorrecto","Error al registrar");
        }
        

    }

    public function update(Request $request){
        try {
            $sql=DB::update(" update cliente set Nombre=?, Direccion=?, entidad=?, RUC_DNI=? where idCliente=?", [
          
            $request->txtNombre,
            $request->txtDireccion,
            $request->txtentidad,
            $request->txtRUC_DNI,
            $request->txtidCliente,
          

            ]);
            if ($sql==0) {
                $sql=1;
            }
        } catch (\Throwable $th) {
            $sql=0;
        }
        if ($sql == true) {
            return back()->with("Correcto","Cliente modificado correctamente");
           
        } else {
            return back()->with("Incorrecto","Error al modificar");
        }


    }
        public function delete ($id){
            try {
                $sql=DB::delete(" delete from cliente where idCliente=$id ");
            } catch (\Throwable $th) {
                $sql = 0;
            }
            if ($sql == true) {
                return back()->with("Correcto","Cliente eliminado correctamente");
               
            } else {
                return back()->with("Incorrecto","Error al eliminar");
            }


        }

         // Método adicional para obtener el total de clientes
    public function getTotalClientes()
    {
        $totalClientes = DB::table('cliente')->count();
        return response()->json(['totalClientes' => $totalClientes]);
    }
}

