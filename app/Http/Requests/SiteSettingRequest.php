<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
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
            // 'mail_mailer' => 'required',
            // 'mail_host' => 'required',
            // 'mail_port' => 'required',
            // 'mail_encryption' => 'required',
            // 'mail_username' => 'required',
            // 'mail_password' => 'required',
            'channel_id' => 'required',
            'channel_secret' => 'required',
            'channel_token' => 'required',
            'liffId' => 'required',
            'yoyaku_url' => 'required',

        ];
    }
}
