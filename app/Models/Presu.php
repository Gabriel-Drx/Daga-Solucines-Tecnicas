<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presu extends Model
{
    use HasFactory;

    protected $table = 'presu'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idSubida'; // Clave primaria
    public $timestamps = false; // Si no usas columnas created_at y updated_at

    protected $fillable = ['nombre', 'fecha', 'archivo'];
}
