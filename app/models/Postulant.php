<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Postulant extends Model
{
     /**
     * @type object Postulant
     */
    protected $table = 'postulant';

    /**
     * @type array
     */
    protected $fillable =  [
        'ci',
        'name',
        'l_name',
        'ml_name',
        'email',
        'phone',
        'address',
        'avatar',
        'cod_sis',
        'id_account'
    ];
}