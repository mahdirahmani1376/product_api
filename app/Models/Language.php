<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['iso_code','name'];

    public function products(){
        return $this->hasMany(LanguageProduct::class);
    }
}
