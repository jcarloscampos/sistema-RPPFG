<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * Eloquent por defacto los unico que necesita parabajar es que se defina el nombre de la tabla en una variable protegida
     */
    protected $table = 'area';

    /**
     * Para salvar datos desde un formulario, Eloquent protege estos modelos
     * Se  define la variable que contendrá los datos a salvar
     */
    protected $fillable =  ['nomb_area', 'desc_area'];
}
