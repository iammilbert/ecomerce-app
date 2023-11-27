<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UUIDHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ProductDiscount extends Model
{
    use HasFactory, UUIDHelper;

    protected $table = 'product_discounts';

    protected $guarded = [
        'id'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function discount() : BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
