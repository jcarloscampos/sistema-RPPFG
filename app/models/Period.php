<?php

namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
     /**
     * @type object Period
     */
    protected $table = 'period';

    /**
     * @type array
     */
    protected $fillable = ['start_date', 'end_date', 'period'];
}
