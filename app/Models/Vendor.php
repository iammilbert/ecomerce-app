<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    use HasFactory, UUIDHelper;

    protected $table = 'vendors';
    
    protected $guarded = [
        'id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function country_of_resident() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'company_country_of_residence_id');
    }

        public function lg_of_resident() : BelongsTo
    {
        return $this->belongsTo(Lg::class, 'company_lg_of_residence_id');
    }

        public function state_of_resident() : BelongsTo
    {
        return $this->belongsTo(State::class, 'company_state_of_resident_id');
    }
}