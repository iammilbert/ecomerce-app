<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Country extends Model
{
    use HasFactory;


    protected $table = 'countries';

    protected $fillable = [
        'id',
        'name',
        'code',
    ];


    public function address() : HasMany
    {
        return $this->hasMany(Address::class);
    }

        public function state() : HasMany
    {
        return $this->hasMany(State::class);
    }
}
