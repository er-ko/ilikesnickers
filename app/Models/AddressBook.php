<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
		'company_name',
        'company_id',
        'vat_id',
        'first_name',
        'last_name',
        'address',
        'address_2',
        'postcode',
        'city',
        'phonecode',
        'phone',
        'email',
        'due_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
