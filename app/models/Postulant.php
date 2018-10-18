<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Postulant extends Model
{
    protected $table = 'postulant';

    /**
     * Para salvar datos desde un formulario, Eloquent protege estos modelos
     * Se  define la variable que contendrá los datos a salvar
     */
    protected $fillable =  ['ci', 'name', 'l_name', 'ml_name', 'email', 'phone', 'address', 'avatar', 'cod_sis'];
}
