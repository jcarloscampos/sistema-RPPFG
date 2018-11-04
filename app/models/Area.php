<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * @type object area
     */
    protected $table = 'area';

    /**
     * Para salvar datos desde un formulario, Eloquent protege estos modelos
     * Se  define la variable que contendrá los datos a salvar
     * @type array
     */
    protected $fillable =  ['name_area', 'desc_area', 'id_parent_area', 'status'];
}
