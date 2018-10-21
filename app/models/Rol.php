<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    /**
     * @type object Rol
     */
    protected $table = 'rol';

    /**
     * @type array
     */
    protected $fillable =  ['name_rol'];
}