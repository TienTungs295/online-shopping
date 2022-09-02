<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table='posts';
    protected $fillable = [
        'name',
        'content',
        'image',
        'is_featured'
    ];

    protected $appends = ['excerpt_content'];

    public function getExcerptContentAttribute()
    {
        if (empty($this->content)) return "";
        return substr("$this->content", 0,100);
    }

}
