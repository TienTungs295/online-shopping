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
        'priority',
        'is_featured'];

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
