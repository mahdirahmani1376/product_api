<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Brand|null $brand
 * @property string $category
 * @property string $default_colors
 * @property int $width
 * @property int $height
 * @property int $depth
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LanguageProduct[] $languages
 * @property-read int|null $languages_count
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDefaultColors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidth($value)
 * @mixin \Eloquent
 * @property int $category_id
 * @property int $brand_id
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 */
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
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    public function tags(){
        return $this->morphToMany(Tag::class,'taggable');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
