<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'name' => 'required|max:80|unique:products',
            'category' => 'required|in:Pakaian Pria,Pakaian Wanita',
            'price' => 'required|integer',
            'qty' => 'required|integer',
            'color' => 'required|array',
            'size' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product Name Cannot Be Empty',
            'name.max' => 'Product Name Cannot Exceed 80 Characters',           
            'name.unique' => 'Product Name Already Exists',
            'category.required' => 'Category Cannot Be Empty',
            'category.in' => 'Category Can Only Be Filled With "Pakaian Pria" or "Pakaian Wanita"',            
            'price.required' => 'Price Cannot Be Empty',
            'price.integer' => 'Price Can Only Be Filled With Numbers',
            'qty.required' => 'Quantity Cannot Be Empty',
            'qty.integer' => 'Quantity Can Only Be Filled With Numbers',
            'color.required' => 'Color Cannot Be Empty',
            'size.required' => 'Size Cannot Be Empty',         
        ];
    }

   /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json(['error' => $validator->errors()], 400));
    }
}
