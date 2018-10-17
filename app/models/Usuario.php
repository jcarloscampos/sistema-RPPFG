<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    /**
     * Eloquent por defacto los unico que necesita parabajar es que se defina el nombre de la tabla en una variable protegida
     */
    protected $table = 'usuario';

    /**
     * Para salvar datos desde un formulario, Eloquent protege estos modelos
     * Se  define la variable que contendrá los datos a salvar
     */
    protected $fillable =  ['nomb_usuario', 'ap_pat_usuario', 'ap_mat_usuario', 'ci_usuario', 'email_usuario', 'telf_usuario', 'dir_usuario', 'imagen_usuario', 'nombre_cta', 'pass_cta', 'status_usuario'];
}
