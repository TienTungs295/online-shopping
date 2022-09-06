<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WithList extends Model
{
    use HasFactory;

    protected $table = 'ec_wish_lists';
    protected $fillable = [
        'customer_id',
        'product_id',
        'is_featured'
    ];

    /**
     * @return HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
