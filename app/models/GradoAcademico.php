<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class GradoAcademico extends Model
{
    /**
     * Eloquent por defacto los unico que necesita parabajar es que se defina el nombre de la tabla en una variable protegida
     */
    protected $table = 'grado_academico';

    /**
     * Para salvar datos desde un formulario, Eloquent protege estos modelos
     * Se  define la variable que contendrá los datos a salvar
     */
    protected $fillable =  ['nombre_grado'];
}
