<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLabel extends Model
{
    use HasFactory;
    protected $table='ec_product_labels';
    protected $fillable = ['name', 'color'];
}
