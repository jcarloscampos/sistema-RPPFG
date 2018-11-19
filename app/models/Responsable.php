<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
     /**
     * @type object Career
     */
    protected $table = 'responsable';

    /**
     * @type array
     */
    protected $fillable = ['id_intprof', 'id_profile', 'id_type_resp'];
}
