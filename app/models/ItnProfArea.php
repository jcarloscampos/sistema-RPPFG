<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class ItnProfArea extends Model{

    /**
     * @type object Account
     */
    protected $table = 'itnprof_area';

    /**
     * @type array
     */
    protected $fillable =  ['id_prof', 'id_area'];
}
