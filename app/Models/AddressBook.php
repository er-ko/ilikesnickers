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
        'due_date',
        'billing_code',
		'billing_company_name',
        'billing_company_id',
        'billing_vat_id',
        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_address_ext',
        'billing_postcode',
        'billing_city',
        'billing_phonecode',
        'billing_phone',
        'billing_email',
        'branch_code',
		'branch_company_name',
        'branch_company_id',
        'branch_vat_id',
        'branch_first_name',
        'branch_last_name',
        'branch_address',
        'branch_address_ext',
        'branch_postcode',
        'branch_city',
        'branch_phonecode',
        'branch_phone',
        'branch_email',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
