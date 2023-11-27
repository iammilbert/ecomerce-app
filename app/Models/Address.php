<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory, UUIDHelper;

    protected $table = 'addresses';
    
    protected $guarded = [
        'id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function country_of_resident() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_of_residence_id');
    }

        public function country_of_origin() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_of_origin_id');
    }

        public function lg_of_resident() : BelongsTo
    {
        return $this->belongsTo(Lg::class, 'lg_of_residence_id');
    }

         public function lg_of_origin() : BelongsTo
    {
        return $this->belongsTo(Lg::class, 'lg_of_origin_id');
    }

        public function state_of_origin() : BelongsTo
    {
        return $this->belongsTo(State::class, 'state_of_origin_id');
    }

        public function state_of_resident() : BelongsTo
    {
        return $this->belongsTo(State::class, 'state_of_resident_id');
    }
}