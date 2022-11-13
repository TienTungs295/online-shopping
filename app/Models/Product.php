<?php

namespace App\Models;

use App\Models\Discount;
use App\Models\Image;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\ProductLabel;
use App\Models\Review;
use App\Models\WithList;
use App\Models\FlashSale;
use \stdClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ec_products';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'content',
//        'status',
        'image',
        'sku',
        'order',
        'quantity',
        'allow_checkout_when_out_of_stock',
        'with_storehouse_management',
        'is_featured',
//        'options',
//        'brand_id',
//        'is_variation',
        'is_searchable',
        'is_show_on_list',
        'sale_type',
        'price',
        'sale_price',
        'start_date',
        'end_date',
//        'length',
//        'wide',
//        'height',
//        'weight',
//        'barcode',
//        'length_unit',
//        'wide_unit',
//        'height_unit',
//        'weight_unit',
//        'tax_id',
//        'views',
        'stock_status',
        'is_contact',
        'is_flash_sale',
    ];

    protected $appends = ['real_price', 'on_sale', 'sale_off', 'max_rating', 'start_date_time_stamp', 'in_progress_range', 'max_range', 'is_out_of_stock'];


    public function getRealPriceAttribute()
    {
        if (($this->sale_price != 0) &&
            (($this->start_date == null && $this->end_date == null)
                || ($this->start_date == null && $this->end_date >= now())
                || ($this->start_date <= now() && $this->end_date == null)
                || ($this->start_date <= now() && $this->end_date >= now()))) {
            return $this->sale_price;
        } else {
            return $this->price;
        }
    }

    public function getOnSaleAttribute()
    {
        return (($this->sale_price != 0) &&
            (($this->start_date == null && $this->end_date == null)
                || ($this->start_date == null && $this->end_date >= now())
                || ($this->start_date <= now() && $this->end_date == null)
                || ($this->start_date <= now() && $this->end_date >= now())));
    }

    public function getSaleOffAttribute()
    {
        if ($this->getOnSaleAttribute()) {
            return ceil(100 - (($this->sale_price / $this->price) * 100));
        }
        return null;
    }

    public function getMaxRatingAttribute()
    {
        $query = $this->reviews();
        if ($query->count() > 0) {
            $max_rating = new stdClass();
            $rateMap = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
            $reviews = $query->get();
            foreach ($reviews as $item) $rateMap[$item->star]++;
            foreach ($rateMap as $key => $value) {
                if ($value > 0) {
                    $max_rating->star = $key;
                    $max_rating->total = $value;
                }
            }
            return $max_rating;
        }
        return null;
    }

    public function getInProgressRangeAttribute()
    {
        $value = null;
        if ($this->end_date != null) {
            $value = time() - strtotime($this->start_date);
            if ($value < 0) return 0;
        }
        return $value;
    }

    public function getMaxRangeAttribute()
    {
        $value = null;
        if ($this->end_date != null) {
            $value = strtotime($this->end_date) - strtotime($this->start_date);
            if ($value < 0) return 0;
        }
        return $value;
    }

    public function getStartDateTimeStampAttribute()
    {
        if ($this->start_date != null) return strtotime($this->start_date);
        return null;
    }

    public function getIsOutOfStockAttribute()
    {
        if ($this->allow_checkout_when_out_of_stock == 1) return true;
        return ($this->stock_status != null && $this->stock_status == 1) || ($this->quantity != null && $this->quantity > 0);
    }

    /**
     * @return BelongsToMany
     */
    public function productsRelated()
    {
        return $this->belongsToMany(Product::class, 'ec_product_related_relations', 'from_product_id', 'to_product_id');
    }

    /**
     * @return BelongsToMany
     */
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'ec_discount_products', 'product_id', 'discount_id');
    }


    /**
     * @return BelongsToMany
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function productCollections()
    {
        return $this->belongsToMany(
            ProductCollection::class,
            'ec_product_collection_products',
            'product_id',
            'product_collection_id'
        );
    }


    /**
     * @return BelongsToMany
     */
    public function productLabels()
    {
        return $this->belongsToMany(
            ProductLabel::class,
            'ec_product_label_products',
            'product_id',
            'product_label_id'
        );
    }

    public function flashSales()
    {
        return $this->belongsToMany(FlashSale::class, 'ec_flash_sale_products', 'product_id', 'flash_sale_id')
            ->withPivot(['price', 'quantity', 'sold']);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'pro_id');
    }

    /**
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->discounts()->detach();
            $product->flashSales()->detach();
            $product->productLabels()->detach();
            $product->productCollections()->detach();
        });
    }
}
