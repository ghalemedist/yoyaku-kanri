<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YoyakuuserRequest extends FormRequest
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
            'yoyakujikan_id' => 'required',
            // 'type' => 'required',
            'your_name' => 'required',
            // 'your_kana' => 'required',
            // 'postal_code' => 'required',
            // 'address_line' => 'required',
            // 'tel' => 'required',
            // 'pet_name' => 'required',
            // 'pet_message2' => 'required',
        ];
    }
}
