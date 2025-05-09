<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,'.$this->customer?->id,
            'phone' => 'required|string|unique:customers,phone,'.$this->customer?->id,
            'company_name' => 'nullable|string',
            'address' => 'nullable|string'
        ];
    }
}