<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ProfilePicture extends Model
{
    use HasFactory, UUIDHelper;

    protected $table = 'profile_pictures';


    protected $guarded = [
        'id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
