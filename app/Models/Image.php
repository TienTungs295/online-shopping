<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ec_product_imgs';

    protected $fillable = ['id', 'image', 'pro_id'];


    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsTo(Product::class, 'pro_id');
    }
}
