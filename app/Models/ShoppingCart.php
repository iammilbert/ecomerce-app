<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Helpers\UUIDHelper;


class ShoppingCart extends Model
{
    use HasApiTokens, HasFactory, Notifiable, UUIDHelper;


     protected $table = 'shopping_carts';

    protected $guarded = [
        'id'
    ];


       public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
