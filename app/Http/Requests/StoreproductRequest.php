<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class StoreproductRequest extends FormRequest
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
        $count_of_products = Language::count();
        
        return [
            'data'                   =>  ['required', 'array','min:$count_of_products','max:$count_of_products'],
            'data.*.language_id'     =>  ['required', 'numeric'],
            'data.*.name'            =>  ['required', 'string'],
            'data.*.model'            =>  ['required','string'],
            'data.*.name'             =>  ['required','string'],
            'data.*.meta_title'       =>  ['nullable','max:100'],
            'data.*.meta_description' =>  ['nullable','max:190'],
            'data.*.meta_keywords'    =>  ['nullable','max:50'],
            'data.*.canonical'        =>  ['nullable'],
            'data.*.description'      =>  ['required','max:300'],
        ];
    }
}
