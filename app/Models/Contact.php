<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
		'user_id',
		'address',
		'opening_hours',
		'phone',
		'email',
		'map',
		'whatsapp',
		'facebook',
		'instagram',
		'tiktok',
		'google',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
