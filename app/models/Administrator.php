<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
     /**
     * @type object Administrator
     */
    protected $table = 'administrator';

    /**
     * @type array
     */
    protected $fillable =  [
        'name',
        'l_name',
        'ml_name',
        'phone',
        'email',
        'address',
        'id_account'
    ];
}