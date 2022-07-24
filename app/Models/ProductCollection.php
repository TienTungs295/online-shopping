<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    use HasFactory;
    protected $table='ec_product_collections';
    protected $fillable = [
        'name',
        'description',
        'is_featured'
    ];
}
