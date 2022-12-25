<?php

namespace App\Http\Requests;

use App\Models\Brand;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class UpdateproductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
            return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $CountOfProducts = Language::count();
        $ListOfBrands = Brand::all()->pluck('name');
        return [
            'brand'                 => ['required','string',"exists:brands,name"],
            'category'                 => ['required','string',"exists:categories,name"],
            'width'                 => ['nullable','numeric'],
            'height'                 => ['nullable','numeric'],
            'depth'                 => ['nullable','numeric'],
            'image_url'                 => ['nullable','file'],
            'data'                   =>  ['required', 'array', "min:$CountOfProducts", "max:$CountOfProducts"],
            'data.*.language_id'     =>  ['required', 'numeric'],
            'data.*.name'             =>  ['required','string'],
            'data.*.meta_title'       =>  ['nullable','max:100'],
            'data.*.meta_description' =>  ['nullable','max:190'],
            'data.*.meta_keywords'    =>  ['nullable','max:50'],
            'data.*.english_name'    =>  ['nullable','max:50'],
            'data.*.canonical'        =>  ['nullable'],
            'data.*.description'      =>  ['required','max:300'],
        ];
    }
}
