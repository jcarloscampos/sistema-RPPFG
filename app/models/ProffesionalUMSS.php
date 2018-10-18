<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class ProffesionalUMSS extends Model
{
    /**
     * Eloquent por defacto los unico que necesita parabajar es que se defina el nombre de la tabla en una variable protegida
     */
    protected $table = 'professional_umss';

    /**
     * Para salvar datos desde un formulario, Eloquent protege estos modelos
     * Se  define la variable que contendrá los datos a salvar
     */
    protected $fillable =  ['ci', 'name', 'l_name', 'ml_name', 'email', 'phone', 'address',
                            'avatar', 'cod_sis', 'id_a_degree', 'id_workload', 'profile', 'id_account'];
}
