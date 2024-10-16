<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
		'user_id',
        'public',
        'parent_id',
        'slug', 
        'image',
        'locale',
        'title',
        'title_h1',
        'content',
        'meta_title',
        'meta_desc',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
