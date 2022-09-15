<?php

namespace App\Models;

use App\Models\Discount;
use App\Models\Image;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\ProductLabel;
use App\Models\WithList;
use App\Models\FlashSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    ];

    protected $appends = ['real_price', 'on_sale','sale_off'];


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

    public function withList()
    {
        return $this->hasMany(WithList::class, 'product_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->discounts()->detach();
            $product->flashSales()->detach();
            $product->productLabels()->detach();
            $product->productCollections()->detach();
//            $product->withList()->detach();
        });
    }
}
