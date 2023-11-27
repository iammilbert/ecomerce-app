<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NextOfKin extends Model
{
    use HasFactory, UUIDHelper;


    protected $table = 'next_of_kins';

    protected $guarded = [
        'id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
