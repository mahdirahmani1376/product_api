<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageProduct extends Model
{
    protected $fillable = [
        "name",
        "description",
        "product_id",
        "language_id",
        "meta_title",
        'meta_description',
        'meta_keywords',
        'canonical',
    ];

    use HasFactory;

    public function product()
    {
        $this->belongsTo(Product::class, 'product_id');
    }

}

