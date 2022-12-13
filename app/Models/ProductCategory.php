<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'ec_product_categories';
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'image',
        'priority',
        'is_featured'];

    protected $appends = ['is_expand', 'is_show'];


    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with('childs');
    }

    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function parentIds()
    {
        $parent_ids = collect([]);
        $parent = $this->parent;
        while (!is_null($parent)) {
            $parent_ids->push($parent->id);
            $parent = $parent->parent;
        }
        return $parent_ids;
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function getIsExpandAttribute()
    {
        return false;
    }

    public function getIsShowAttribute()
    {
        return false;
    }

}
