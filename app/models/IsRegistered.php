<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class IsRegistered extends Model
{
    /**
     * @type object IsRegistered
     */
    protected $table = 'is_registered';

    protected $fillable =  ['ci', 'sigla_mat'];
}