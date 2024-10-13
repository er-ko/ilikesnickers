<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'priority',
		'public',
        'default',
        'locale',
        'locale_3',
        'name',
        'localname',
        'flag',
        'decimal_point',
        'thousand_separator',
        'time_format',
        'date_format',
    ];
}
