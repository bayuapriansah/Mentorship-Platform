<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'email' => 'required|unique:companies,email',
            'logo' => 'required|file|mimes:png,jpg,jpeg|max:5000'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'The email address has already been taken by another company.',
        ];
    }
}
