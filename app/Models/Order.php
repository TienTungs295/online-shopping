<?php

namespace App\Models;

use App\Models\OrderAddress;

//use App\Models\OrderHistory;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    //Enum
    //status 1: Đang chờ, 2:Đã xác nhận, 3: Đã thanh toán, 4: Đã giao hàng
    //payment_method 1: Chuyển khoản, 2:COD

    /**
     * @var string
     */
    protected $table = 'ec_orders';

    /**
     * @var array
     */
    protected $fillable = [
        'status',
        'user_id',
//        'amount',
//        'currency_id',
//        'tax_amount',
//        'shipping_method',
//        'shipping_option',
        'shipping_fee',
        'description',
        'coupon_code',
        'discount_value',
        'sub_total',
        'sub_total_final',
        'received_price',
//        'is_confirmed',
//        'discount_description',
//        'is_finished',
//        'token',
    ];

    protected $appends = ['sub_total_final_format', 'sub_total_format', 'discount_value_format', 'shipping_fee_format', 'received_price_format'];

    public function getSubTotalFormatAttribute()
    {
        return number_format(($this->sub_total), 0, '', ',') . " đ";
    }

    public function getSubTotalFinalFormatAttribute()
    {
        return number_format(($this->sub_total_final), 0, '', ',') . " đ";
    }

    public function getDiscountValueFormatAttribute()
    {
        if ($this->discount_value != null)
            return number_format(($this->discount_value), 0, '', ',') . " đ";
    }

    public function getShippingFeeFormatAttribute()
    {
        return number_format($this->shipping_fee, 0, '', ',') . " đ";
    }

    public function getReceivedPriceFormatAttribute()
    {
        return number_format($this->received_price, 0, '', ',') . " đ";
    }

    /**
     * @return HasOne
     */
    public function address()
    {
        return $this->hasOne(OrderAddress::class, 'order_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($order) {
//            OrderHistory::where('order_id', $order->id)->delete();
            OrderProduct::where('order_id', $order->id)->delete();
            OrderAddress::where('order_id', $order->id)->delete();
        });
    }
}
