<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UpdateCompanyRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'email' => [
                'required',
                Rule::unique('companies')->ignore($this->route('partner'))
            ],
            'logo' => 'nullable|file|mimes:png,jpg,jpeg|max:5000'
        ];
    
        Log::info('Validation rules:', $rules);
        return $rules;
    }
    
    public function messages()
    {
        $messages = [
            'email.unique' => 'The email address has already been taken by another company.',
        ];
    
        Log::info('Validation messages:', $messages);
        return $messages;
    }
}
