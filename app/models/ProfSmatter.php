<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class ProfSmatter extends Model
{
    /**
     * @type object Account
     */
    protected $table = 'prof_smatter';

    /**
     * @type array
     */
    protected $fillable = ['id_prof', 'id_smatter'];
}
