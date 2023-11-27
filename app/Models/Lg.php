<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Lg extends Model
{
    use HasFactory;

    protected $table = 'lgs';

    protected $fillable = [
        'id',
        'name',
        'state_id',
    ];


    public function address() : HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function state() : BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
