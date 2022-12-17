<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "brand",
        "english_name",
        "category",
        "default_colors",
        "width",
        "height",
        "depth",
    ];


    public function languages(){
        return $this->hasMany(LanguageProduct::class, 'product_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class);
    }

}
