<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LanguageProduct
 *
 * @property int $language_id
 * @property int $product_id
 * @property string $name
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $canonical
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\LanguageProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereCanonical($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LanguageProduct extends Model
{
    use HasFactory;
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


    public function product()
    {
        $this->belongsTo(Product::class, 'product_id');
    }

}

