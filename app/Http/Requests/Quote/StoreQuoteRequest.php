<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            '*.name' => 'required|string|min:3',
            '*.total_fixed_costs' => 'required|numeric',
            '*.total_variable_costs' => 'required|numeric',
            '*.price_sale' => 'required|numeric',
            '*.link' => 'sometimes',
            '*.category_id' => 'required|exists:categories,id',
        ];
    }
}
