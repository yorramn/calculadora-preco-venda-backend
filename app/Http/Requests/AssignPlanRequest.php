<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignPlanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'plan_id' => 'required|exists:plans,id',
            'address' => 'required|string',
            'number' => 'required|integer',
            'complement' => 'sometimes',
            'district' => 'required|string',
            'cep' => 'required|string',
            'uf' => 'required|string',
            'locality' => 'required|string',
        ];
    }
}
