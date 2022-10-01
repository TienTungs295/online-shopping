<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'ec_order_product';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'qty',
        'weight',
        'price',
        'tax_amount',
        'options',
        'restock_quantity',
    ];

    protected $appends = ['sub_total_format', 'sub_total', 'format_price'];

    public function getSubTotalAttribute()
    {
        return $this->qty * $this->price;
    }

    public function getSubTotalFormatAttribute()
    {
        return number_format($this->qty * $this->price, 0, '', ',') . " đ";
    }

    public function getFormatPriceAttribute()
    {
        return number_format($this->price, 0, '', ',') . " đ";
    }


    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
