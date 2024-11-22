<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    // Definir la tabla personalizada
    protected $table = 'usuario';

    // Definir la clave primaria personalizada si es diferente de 'id'
    protected $primaryKey = 'idUsuario';

    // Si no utilizas timestamps (created_at, updated_at) en la tabla, desactívalos
    public $timestamps = false;

    // Si la clave primaria no es auto-incremental, indica que no es "incrementing"
    public $incrementing = true;

    // Si la clave primaria no es de tipo int, usa 'string'
    protected $keyType = 'int';

    // Definir los campos que pueden ser asignados de forma masiva
    protected $fillable = ['correoUsuario', 'passwordUsuario', 'nombre', 'imagen'];

    // Si usas AES_ENCRYPT en la base de datos, puedes agregar este accesor para comparar las contraseñas
    public function setPasswordUsuarioAttribute($password)
    {
        $this->attributes['passwordUsuario'] = DB::raw("AES_ENCRYPT('{$password}', 'AES')");
    }
}
