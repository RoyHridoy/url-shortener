<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.name' => 'required|string',
            'data.attributes.email' => 'required|string|email|unique:users,email',
            'data.attributes.password' => 'required|string|min:8|max:24'
        ];
    }

    public function mappedAttributes()
    {
        $attributes = [
            'data.attributes.name' => 'name',
            'data.attributes.email' => 'email',
            'data.attributes.password' => 'password'
        ];
        $mappedAttributes = [];
        foreach ($attributes as $key => $value) {
            $mappedAttributes[$value] = $this[$key];
        }
        return $mappedAttributes;
    }
}
