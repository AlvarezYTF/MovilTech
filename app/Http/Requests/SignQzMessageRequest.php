<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignQzMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'request' => ['required', 'string', 'max:65535'],
        ];
    }
}
