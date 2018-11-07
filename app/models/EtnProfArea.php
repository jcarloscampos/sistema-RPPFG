<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class EtnProfArea extends Model{

    /**
     * @type object Account
     */
    protected $table = 'etnprof_area';

    /**
     * @type array
     */
    protected $fillable =  ['id_prof', 'id_area'];
}
