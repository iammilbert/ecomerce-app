<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, UUIDHelper;

    protected $table = 'categories';


    protected $guarded = [
        'id'
    ];


    public function product() : HasMany
    {
        return $this->hasMany(Product::class);
    }
}
