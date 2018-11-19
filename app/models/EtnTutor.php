<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class EtnTutor extends Model
{
    /**
     * @type object EtnTutor
     */
    protected $table = 'etntutor';

    /**
     * @type array
     */
    protected $fillable = ['id_entprof', 'id_profile'];
}
