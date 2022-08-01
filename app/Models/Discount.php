<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'ec_discounts';

    /**
     * @var array
     */
    protected $fillable = [
//        'title',
        'code',
        'start_date',
        'end_date',
        'quantity',
        'total_used',
        'value',
//        'type',
//        'can_use_with_promotion',
        'type_option',
        'target',
//        'min_order_price',
        'discount_on',
        'product_quantity',
    ];

    /**
     * @return bool
     */
    public function isExpired()
    {
        if ($this->end_date && strtotime($this->end_date) < strtotime(now()->toDateTimeString())) {
            return true;
        }

        return false;
    }

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'ec_discount_products', 'discount_id', 'product_id');
    }


    public static function boot() {
        parent::boot();

        static::deleting(function($discount) { // before delete() method call this
            $discount->products()->detach();
        });
    }

}
