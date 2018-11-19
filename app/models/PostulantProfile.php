<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class PostulantProfile extends Model
{
    /**
     * @type object PostulantProfile
     */
    protected $table = 'postulant_profile';

    /**
     * @type array
     */
    protected $fillable = ['id_postulant', 'id_profile', 'id_career', 'id_period'];
}
