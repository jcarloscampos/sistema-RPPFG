<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    /**
     * Eloquent por defacto los unico que necesita parabajar es que se defina el nombre de la tabla en una variable protegida
     */
    protected $table = 'docente';

    /**
     * Para salvar datos desde un formulario, Eloquent protege estos modelos
     * Se  define la variable que contendrá los datos a salvar
     */
    protected $fillable =  ['cod_sis_docente', 'cod_esis_docente', 'perfil_docente', 'id_grado_academico', 'id_usuario', 'id_carga_horaria'];
}
