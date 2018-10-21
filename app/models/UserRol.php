<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    /**
     * @type object UserRol
     */
    protected $table = 'user_rol';

    /**
     * @type array
     */
    protected $fillable =  [
        'id_account',
        'id_rol'
    ];
}