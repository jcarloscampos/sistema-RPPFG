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
        'title',
        'general_obj',
        'id_period',
        'registry_date',
        'id_modality',
        'id_area',
        'id_subarea',
        'id_area_2',
        'id_subarea_2',
        'id_postulant',
        'id_postulant_2',
        'id_tutor',
        'id_tutor_2',
        'id_status',
        'id_career'
    ];
}