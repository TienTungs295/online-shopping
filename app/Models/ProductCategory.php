<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductCategory extends Model
{
    use HasFactory;

    protected $table='ec_product_categories';
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'is_featured'];

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }
}
