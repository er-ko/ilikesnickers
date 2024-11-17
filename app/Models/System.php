<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'app_name',
        'meta_suffix',
        'country_id',
        'language_id',
        'contact_company_name',
        'contact_address',
		'contact_opening_hours',
		'contact_phone',
		'contact_email',
        'contact_web',
		'contact_map',
		'contact_whatsapp',
		'contact_facebook',
		'contact_instagram',
		'contact_tiktok',
		'contact_google'
    ];
}
