<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email',
            'number' => 'required|max:15|numeric',
            'address' => 'required',
            'transaction_total' => 'required|integer',
            'transaction_status' => 'nullable|string|in:PENDING,SUCCESS,FAILED',
            'transaction_details' => 'required|array',
            'transaction_details.*' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product Name Cannot Be Empty',
            'name.max' => 'Product Name Cannot Exceed 255 Characters', 
            'email.required' => 'Email Cannot Be Empty',
            'email.email' => 'The content must be in email format, for example: xxxx@xxx.com',  
            'number.required' => 'No. Handphone Cannot Be Empty',
            'number.max' => 'No. Handphone Exceed 15 Number',
            'number.numeric' => 'Format Ejject',
            'address.required' => 'Address Cannot Be Empty',
            'transaction_total.required' => 'Transaction Total Cannot Be Empty',
            'transaction_total.integer' => 'Transaction Total Format Must Number',
            'transaction_status.in' => 'Status Transaction PENDING, SUCCESS, FAILED'
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
