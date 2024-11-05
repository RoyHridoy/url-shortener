<?php

namespace App\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.shortUrl' => 'required|string|min:5|regex:/^[a-zA-Z0-9_-]+$/|unique:urls,shortUrl',
            'data.relationships.user.data.id' => 'required|numeric|size:'.auth()->id()
        ];
    }

    public function mappedAttributes(): array
    {
        $attributes = [
            'shortUrl' => 'data.attributes.shortUrl',
            'user_id' => 'data.relationships.user.data.id'
        ];
        $mappedAttributes = [];
        foreach ($attributes as $key => $value) {
            $mappedAttributes[$key] = $this[$value];
        }
        return $mappedAttributes;
    }

    public function messages(): array
    {
        return [
            'data.attributes.shortUrl.regex' => 'data.attributes.shortUrl field can contains alphabet, number, underscore( _ ) and dash( - )',
            'data.attributes.shortUrl.not_in' => 'It\'s your current data.attributes.shortUrl value. Try different one to update.'
        ];
    }
}
