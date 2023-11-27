<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerMessage extends Model
{

   use HasFactory, UUIDHelper;

    protected $table = 'customers_messages';

    protected $guarded = [
        'ticket_id'
    ];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
