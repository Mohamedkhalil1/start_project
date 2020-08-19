<?php

namespace App\Http\Requests\Admin;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class LoginRequest extends FormRequest
{
    use GeneralTrait;
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
        return [
            "password" => "required",
            "email" => "required|exists:admins,email"
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('messages.email'),
            'password.required' => __('messages.password'),
            'email.exists' => __('messages.email_exist'),
            "email.email" => __('messages.email_invalid'),
        ];
    }
}
