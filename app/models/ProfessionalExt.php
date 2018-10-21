<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalExt extends Model
{
    /**
     * @type object ProfessionalExt
     */
    protected $table = 'professional_ext';

    /**
     * @type array
     */
    protected $fillable = [
        'ci',
        'name',
        'l_name',
        'ml_name',
        'email',
        'address',
        'avatar',
        'a_degree',
        'profile',
        'id_account'
    ];
}