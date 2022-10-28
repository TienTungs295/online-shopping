<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerAccount;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;
    //Enum
    //status 1: Đang chờ, 2:Đã xác nhận
    /**
     * @var string
     */
    protected $table = 'ec_reviews';

    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'customer_id',
        'star',
        'comment',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(CustomerAccount::class, 'customer_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return string
     */
    public function getProductNameAttribute()
    {
        return $this->product->name;
    }

    /**
     * @return string
     */
    public function getCustomerNameAttribute()
    {
        return $this->customer->name;
    }
}
