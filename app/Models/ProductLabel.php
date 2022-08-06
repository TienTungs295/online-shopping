<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLabel extends Model
{
    use HasFactory;

    protected $table = 'ec_product_labels';
    protected $fillable = ['name', 'color'];

    public function products()
    {
        return $this
            ->belongsToMany(
                Product::class,
                'ec_product_label_products',
                'product_label_id',
                'product_id'
            );
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (ProductLabel $label) {
            $label->products()->detach();
        });
    }
}
