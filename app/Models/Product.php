<?php

namespace App\Models;

use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Models\ProductCollection;
use Botble\Ecommerce\Models\ProductLabel;
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
        'status',
        'images',
        'sku',
        'order',
        'quantity',
        'allow_checkout_when_out_of_stock',
        'with_storehouse_management',
        'is_featured',
        'options',
        'brand_id',
        'is_variation',
        'is_searchable',
        'is_show_on_list',
        'sale_type',
        'price',
        'sale_price',
        'start_date',
        'end_date',
        'length',
        'wide',
        'height',
        'weight',
        'barcode',
        'length_unit',
        'wide_unit',
        'height_unit',
        'weight_unit',
        'tax_id',
        'status',
        'views',
        'stock_status',
    ];


    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'ec_product_category_product',
            'product_id',
            'category_id'
        );
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



}
