<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
		'user_id',
        'priority',
        'locale',
        'question', 
        'answer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
