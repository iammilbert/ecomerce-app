<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Transave\ScolaCvManagement\Database\Factories\StateFactory;

class State extends Model
{
    use HasFactory;

    protected $table = "states";

    protected $guarded = [
        "id"
    ];
    
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function lgs() : HasMany
    {
        return $this->hasMany(Lg::class);
    }
}
