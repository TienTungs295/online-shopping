<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class ProductCollection extends Model
{
    use HasFactory;

    protected $table = 'ec_product_collections';
    protected $fillable = [
        'name',
        'description',
        'is_featured',
        'priority'
    ];

    public function products()
    {
        return $this
            ->belongsToMany(
                Product::class,
                'ec_product_collection_products',
                'product_collection_id',
                'product_id'
            );
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (ProductCollection $collection) {
            $collection->products()->detach();
        });
    }
}
