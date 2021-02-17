<?php

namespace App\Http\Requests\API\Product;

use App\Models\Product\Product;
use InfyOm\Generator\Request\APIRequest;

class UpdateProductAPIRequest extends APIRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = Product::$rules;
        $rules['sku'] = $rules['sku'].",".$this->route("product");
        return $rules;
    }
}
