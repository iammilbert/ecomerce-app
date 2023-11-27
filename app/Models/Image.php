<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Image extends Model
{
    use HasFactory, UUIDHelper;

    protected $table = 'images';

    protected $guarded = [
        'id'
    ];


    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
