<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * @type object Profile
     */
    protected $table = 'profile';

    /**
     * @type array
     */
    protected $fillable = [
        'num_profile',
        'title',
        'g_objective',
        's_objects',
        'description',
        'id_cmpy_area',
        'id_mod',
        'id_status',
        'tchange'
    ];
}