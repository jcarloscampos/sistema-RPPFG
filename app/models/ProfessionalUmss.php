<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalUmss extends Model
{
    /**
     * @type object ProfessionalUmss
     */
    protected $table = 'professional_umss';

    /**
     * @type array
     */
    protected $fillable = [
        'ci',
        'name',
        'l_name',
        'ml_name',
        'email',
        'phone',
        'address',
        'avatar',
        'cod_sis',
        'active',
        'id_ad',
        'id_wl',
        'profile',
        'id_account'
    ];
}
