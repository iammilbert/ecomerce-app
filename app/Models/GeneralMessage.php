<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneralMessage extends Model
{

   use HasFactory;

    protected $table = 'general_messages';

    protected $guarded = [
        'id',
        'name',
        'message',
        'subject',
        'phone_number',
        'email'
    ];

}
