<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;

class Discount extends Model
{
    use HasFactory, UUIDHelper;


    protected $table = 'discounts';

    protected $guarded = [
        'id'
    ];
}
