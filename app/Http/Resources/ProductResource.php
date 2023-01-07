<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "brand_name" => Brand::find($this->brand_id)->name,
            "category_name" => Category::find($this->category_id)->name,
            "default_colors" => $this->default_colors,
            "width" => $this->width,
            "height" => $this->height,
            "depth" => $this->depth,
            "image_url" => $this->image_url,
            "user_name" => User::find($this->user_id)->name,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
