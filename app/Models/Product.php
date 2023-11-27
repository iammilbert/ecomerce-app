<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    use HasFactory, UUIDHelper;

    protected $table = 'products';

    protected $guarded = [
        'id'
    ];


    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
