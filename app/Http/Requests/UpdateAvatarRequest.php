<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
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
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'avatar' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:2048',
                'file',
                function ($attribute, $value, $fail) {
                    $mimeType = $value->getMimeType();
                    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
                    
                    if (!in_array($mimeType, $allowedMimes)) {
                        $fail('The avatar must be a valid image file.');
                    }
                }
            ],
        ];
    }
}