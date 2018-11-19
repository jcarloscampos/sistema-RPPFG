<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class AreaProfile extends Model
{
    /**
     * @type object Account
     */
    protected $table = 'area_profile';

    /**
     * @type array
     */
    protected $fillable = ['id_profile', 'id_area'];
}
