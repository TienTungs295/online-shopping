<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class ProductCategory extends Model
{
    use HasFactory;

    protected $table='ec_product_categories';
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'image',
        'is_featured'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
